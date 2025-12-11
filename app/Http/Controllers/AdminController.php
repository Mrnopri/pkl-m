<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PklApplication;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $pendingCount = PklApplication::where('status', 'pending')->count();
        $activeCount = PklApplication::where('status', 'approved')->count();

        $units = \App\Models\Unit::withCount([
            'applications' => function ($query) {
                $query->where('status', 'approved');
            }
        ])->get();

        $quotaAvailable = 0;
        $fullUnits = 0;

        foreach ($units as $unit) {
            $remaining = $unit->quota - $unit->applications_count;
            if ($remaining > 0) {
                $quotaAvailable += $remaining;
            } else {
                $fullUnits++;
            }
        }

        $recentApplications = PklApplication::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('pendingCount', 'activeCount', 'quotaAvailable', 'fullUnits', 'recentApplications', 'units'));
    }

    public function pendaftar()
    {
        $applications = PklApplication::with('user')->where('status', 'pending')->latest()->get();
        $units = \App\Models\Unit::all();
        $supervisors = \App\Models\Supervisor::orderBy('name')->get();
        return view('admin.pendaftar', compact('applications', 'units', 'supervisors'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'supervisor_id' => 'required|exists:supervisors,id',
        ]);

        $unit = \App\Models\Unit::findOrFail($request->unit_id);
        $filled = $unit->applications()->where('status', 'approved')->count();

        if ($filled >= $unit->quota) {
            return redirect()->back()->with('error', 'Kuota unit ' . $unit->name . ' sudah penuh.');
        }

        $application = PklApplication::findOrFail($id);
        $application->update([
            'status' => 'approved',
            'unit_id' => $unit->id,
            'supervisor_id' => $request->supervisor_id,
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil diterima dan ditempatkan di ' . $unit->name . '.');
    }

    public function reject(Request $request, $id)
    {
        $application = PklApplication::findOrFail($id);
        $application->update(['status' => 'rejected']);
        // In a real app, we might save the rejection reason
        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak.');
    }

    public function peserta()
    {
        $activeParticipants = PklApplication::with(['user', 'unit', 'supervisor'])->where('status', 'approved')->get();
        return view('admin.peserta', compact('activeParticipants'));
    }
}
