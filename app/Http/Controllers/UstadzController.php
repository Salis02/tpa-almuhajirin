<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Ustadz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UstadzController extends Controller
{
    public function index(Request $request)
    {
        $query = Ustadz::with(['user', 'roles']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by employment status
        if ($request->filled('employment_status')) {
            $query->where('employment_status', $request->employment_status);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $ustadz = $query->latest()->paginate(12);
        $roles = Role::where('is_active', true)->get();

        return view('ustadz.index', compact('ustadz', 'roles'));
    }

    public function create()
    {
        return redirect()->route('ustadz.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:ustadz,nip',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date|before:today',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:ustadz,email|unique:users,email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'education_level' => 'required|in:SMA,D3,S1,S2,S3',
            'education_major' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
            'join_date' => 'required|date',
            'employment_status' => 'required|in:tetap,honorer,magang',
            'status' => 'required|in:active,inactive',
            'password' => 'required|min:6',
            'user_role' => 'required|in:admin,ustadz,pengurus',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        try {
            DB::beginTransaction();

            // Create User
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['user_role'],
                'is_active' => $validated['status'] === 'active',
            ]);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $validated['photo_path'] = $request->file('photo')->store('ustadz-photos', 'public');
            }

            // Create Ustadz profile
            $ustadz = Ustadz::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'full_name' => $validated['full_name'],
                'gender' => $validated['gender'],
                'birth_date' => $validated['birth_date'],
                'birth_place' => $validated['birth_place'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'photo_path' => $validated['photo_path'] ?? null,
                'education_level' => $validated['education_level'],
                'education_major' => $validated['education_major'],
                'certification' => $validated['certification'],
                'join_date' => $validated['join_date'],
                'employment_status' => $validated['employment_status'],
                'status' => $validated['status'],
            ]);

            // Attach roles
            if (!empty($validated['roles'])) {
                $ustadz->roles()->attach($validated['roles']);
            }

            DB::commit();

            return redirect()->route('ustadz.index')
                           ->with('success', 'Data ustadz berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Ustadz $ustadz)
    {
        $ustadz->load(['user', 'roles']);
        return view('ustadz.show', compact('ustadz'));
    }

    public function edit(Ustadz $ustadz)
    {
        return redirect()->route('ustadz.index');
    }

    public function update(Request $request, Ustadz $ustadz)
    {
        $validated = $request->validate([
            'nip' => ['required', 'string', Rule::unique('ustadz', 'nip')->ignore($ustadz->id)],
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date|before:today',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => [
                'required', 
                'email', 
                Rule::unique('ustadz', 'email')->ignore($ustadz->id),
                Rule::unique('users', 'email')->ignore($ustadz->user_id)
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'education_level' => 'required|in:SMA,D3,S1,S2,S3',
            'education_major' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
            'join_date' => 'required|date',
            'employment_status' => 'required|in:tetap,honorer,magang',
            'status' => 'required|in:active,inactive,resign',
            'user_role' => 'required|in:admin,ustadz,pengurus',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        try {
            DB::beginTransaction();

            // Update User
            $ustadz->user->update([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'role' => $validated['user_role'],
                'is_active' => $validated['status'] === 'active',
            ]);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                if ($ustadz->photo_path) {
                    Storage::disk('public')->delete($ustadz->photo_path);
                }
                $validated['photo_path'] = $request->file('photo')->store('ustadz-photos', 'public');
            }

            // Update Ustadz profile
            $ustadz->update([
                'nip' => $validated['nip'],
                'full_name' => $validated['full_name'],
                'gender' => $validated['gender'],
                'birth_date' => $validated['birth_date'],
                'birth_place' => $validated['birth_place'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'photo_path' => $validated['photo_path'] ?? $ustadz->photo_path,
                'education_level' => $validated['education_level'],
                'education_major' => $validated['education_major'],
                'certification' => $validated['certification'],
                'join_date' => $validated['join_date'],
                'employment_status' => $validated['employment_status'],
                'status' => $validated['status'],
            ]);

            // Sync roles
            $ustadz->roles()->sync($validated['roles'] ?? []);

            DB::commit();

            return redirect()->route('ustadz.index')
                           ->with('success', 'Data ustadz berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Ustadz $ustadz)
    {
        try {
            DB::beginTransaction();

            // Delete photo if exists
            if ($ustadz->photo_path) {
                Storage::disk('public')->delete($ustadz->photo_path);
            }

            // Delete user (will cascade delete ustadz due to foreign key constraint)
            $ustadz->user->delete();

            DB::commit();

            return redirect()->route('ustadz.index')
                           ->with('success', 'Data ustadz berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}