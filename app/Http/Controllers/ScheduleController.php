<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleType;
use App\Models\TpaClass;
use App\Models\Ustadz;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['tpaClass', 'scheduleType', 'ustadz']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by schedule type
        if ($request->filled('schedule_type_id')) {
            $query->where('schedule_type_id', $request->schedule_type_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Default to upcoming schedules
        if (!$request->filled(['date_from', 'date_to'])) {
            $query->upcoming();
        }

        $schedules = $query->orderBy('date')->orderBy('start_time')->paginate(12);
        
        $classes = TpaClass::where('is_active', true)->get();
        $scheduleTypes = ScheduleType::where('is_active', true)->get();
        $ustadzList = Ustadz::with('user')->where('status', 'active')->get();

        return view('schedule.index', compact('schedules', 'classes', 'scheduleTypes', 'ustadzList'));
    }

    public function create()
    {
        return redirect()->route('schedule.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'schedule_type_id' => 'required|exists:schedule_types,id',
            'ustadz_id' => 'required|exists:ustadz,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1|max:50',
            'santri_ids' => 'nullable|array',
            'santri_ids.*' => 'exists:santris,id',
        ]);

        // Check for schedule conflicts
        $conflict = Schedule::conflict(
            $validated['ustadz_id'],
            $validated['date'],
            $validated['start_time'],
            $validated['end_time']
        )->exists();

        // $conflict = Schedule::where('ustadz_id', $validated['ustadz_id'])
        //                   ->where('date', $validated['date'])
        //                   ->where(function ($query) use ($validated) {
        //                       $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
        //                             ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
        //                             ->orWhere(function ($q) use ($validated) {
        //                                 $q->where('start_time', '<=', $validated['start_time'])
        //                                   ->where('end_time', '>=', $validated['end_time']);
        //                             });
        //                   })
        //                   ->where('status', '!=', 'cancelled')
        //                   ->exists();

        if ($conflict) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Ustadz sudah memiliki jadwal pada waktu tersebut.');
        }

        try {
            DB::beginTransaction();

            $schedule = Schedule::create($validated);

            // Add participants if selected
            if (!empty($validated['santri_ids'])) {
                foreach ($validated['santri_ids'] as $santriId) {
                    $schedule->participants()->create([
                        'santri_id' => $santriId,
                        'status' => 'registered',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('schedule.index')
                           ->with('success', 'Jadwal berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['tpaClass', 'scheduleType', 'ustadz.user', 'participants.santri']);
        return view('schedule.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        return redirect()->route('schedule.index');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'schedule_type_id' => 'required|exists:schedule_types,id',
            'ustadz_id' => 'required|exists:ustadz,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1|max:50',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'santri_ids' => 'nullable|array',
            'santri_ids.*' => 'exists:santris,id',
        ]);

        // Check for schedule conflicts (exclude current schedule)
        $conflict = Schedule::conflict(
            $validated['ustadz_id'],
            $validated['date'],
            $validated['start_time'],
            $validated['end_time'],
            $schedule->id
        )->exists();

        // $conflict = Schedule::where('ustadz_id', $validated['ustadz_id'])
        //                   ->where('id', '!=', $schedule->id)
        //                   ->where('date', $validated['date'])
        //                   ->where(function ($query) use ($validated) {
        //                       $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
        //                             ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
        //                             ->orWhere(function ($q) use ($validated) {
        //                                 $q->where('start_time', '<=', $validated['start_time'])
        //                                   ->where('end_time', '>=', $validated['end_time']);
        //                             });
        //                   })
        //                   ->where('status', '!=', 'cancelled')
        //                   ->exists();

        if ($conflict) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Ustadz sudah memiliki jadwal pada waktu tersebut.');
        }

        try {
            DB::beginTransaction();

            $schedule->update($validated);

            // Update participants
            if (isset($validated['santri_ids'])) {
                $schedule->participants()->delete();
                foreach ($validated['santri_ids'] as $santriId) {
                    $schedule->participants()->create([
                        'santri_id' => $santriId,
                        'status' => 'registered',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('schedule.index')
                           ->with('success', 'Jadwal berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->route('schedule.index')
                           ->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // API endpoint untuk calendar view
    public function calendar(Request $request)
    {
        $schedules = Schedule::with(['tpaClass', 'scheduleType', 'ustadz'])
                            ->when($request->start, function ($query, $start) {
                                return $query->whereDate('date', '>=', $start);
                            })
                            ->when($request->end, function ($query, $end) {
                                return $query->whereDate('date', '<=', $end);
                            })
                            ->get()
                            ->map(function ($schedule) {
                                return [
                                    'id' => $schedule->id,
                                    'title' => $schedule->title,
                                    'start' => $schedule->date->format('Y-m-d') . 'T' . $schedule->start_time_carbon->format('H:i:s'),
                                    'end'   => $schedule->date->format('Y-m-d') . 'T' . $schedule->end_time_carbon->format('H:i:s'),
                                    'backgroundColor' => $this->getScheduleColor($schedule->scheduleType->name),
                                    'borderColor' => $this->getScheduleColor($schedule->scheduleType->name),
                                    'extendedProps' => [
                                        'type' => $schedule->scheduleType->display_name,
                                        'class' => $schedule->tpaClass->display_name,
                                        'ustadz' => $schedule->ustadz->full_name,
                                        'status' => $schedule->status,
                                        'participants' => $schedule->participant_count,
                                    ],
                                ];
                            });

        return response()->json($schedules);
    }

    private function getScheduleColor($type)
    {
        $colors = [
            'setoran' => '#10B981',   // green
            'praktek' => '#3B82F6',   // blue
            'privat' => '#8B5CF6',    // purple
        ];

        return $colors[$type] ?? '#6B7280';
    }
}