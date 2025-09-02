<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TpaClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('tpaClass');

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $santris = $query->latest()->paginate(12);
        $classes = TpaClass::where('is_active', true)->get();

        return view('santri.index', compact('santris', 'classes'));
    }

    public function create()
    {
        $classes = TpaClass::where('is_active', true)->get();
        return view('santri.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:santris,nis',
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date|before:today',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'guardian_address' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('santri-photos', 'public');
        }

        Santri::create($validated);

        return redirect()->route('santri.index')
                        ->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function show(Santri $santri)
    {
        $santri->load('tpaClass');
        return view('santri.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        $classes = TpaClass::where('is_active', true)->get();
        return view('santri.edit', compact('santri', 'classes'));
    }

    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', Rule::unique('santris', 'nis')->ignore($santri->id)],
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date|before:today',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'guardian_address' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,inactive,graduated,dropped',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($santri->photo_path) {
                Storage::disk('public')->delete($santri->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('santri-photos', 'public');
        }

        $santri->update($validated);

        return redirect()->route('santri.index')
                        ->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        // Delete photo if exists
        if ($santri->photo_path) {
            Storage::disk('public')->delete($santri->photo_path);
        }

        $santri->delete();

        return redirect()->route('santri.index')
                        ->with('success', 'Data santri berhasil dihapus.');
    }
}