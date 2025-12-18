<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisors = Supervisor::latest()->paginate(10);
        return view('admin.supervisors', compact('supervisors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        Supervisor::create([
            'name' => $request->name,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.supervisors.index')->with('success', 'Pembimbing berhasil ditambahkan.');
    }

    public function update(Request $request, Supervisor $supervisor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $supervisor->update([
            'name' => $request->name,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.supervisors.index')->with('success', 'Pembimbing berhasil diperbarui.');
    }

    public function destroy(Supervisor $supervisor)
    {
        $supervisor->delete();
        return redirect()->route('admin.supervisors.index')->with('success', 'Pembimbing berhasil dihapus.');
    }
}
