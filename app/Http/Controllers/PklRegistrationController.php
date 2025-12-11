<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PklApplication;
use Illuminate\Support\Facades\Auth;

class PklRegistrationController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard.index');
    }

    public function create()
    {
        // Check if user already has an approved application
        $application = PklApplication::where('user_id', Auth::id())->first();

        if ($application && $application->status === 'approved') {
            return redirect()->route('status.index')->with('error', 'Anda sudah diterima sebagai peserta PKL. Anda tidak dapat mendaftar lagi.');
        }

        return view('dashboard.pendaftaran');
    }

    public function status()
    {
        $application = PklApplication::with('unit')->where('user_id', Auth::id())->first();
        return view('dashboard.status', compact('application'));
    }

    public function about()
    {
        return view('dashboard.tentang');
    }

    public function store(Request $request)
    {
        // Check if user already has an application
        $existingApplication = PklApplication::where('user_id', Auth::id())->first();

        if ($existingApplication && $existingApplication->status === 'approved') {
            return redirect()->route('status.index')->with('error', 'Anda sudah diterima sebagai peserta PKL. Anda tidak dapat mendaftar lagi.');
        }

        $request->validate([
            'education_level' => 'required|string',
            'institution_name' => 'required|string',
            'major' => 'required|string',
            'nim' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'file' => 'required|file|mimes:pdf,docx,jpg,png|max:2048',
        ]);

        $path = $request->file('file')->store('pkl_files', 'public');

        PklApplication::create([
            'user_id' => Auth::id(),
            'education_level' => $request->education_level,
            'institution_name' => $request->institution_name,
            'major' => $request->major,
            'nim' => $request->nim,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('status.index')->with('success', 'Pendaftaran berhasil dikirim!');
    }
}
