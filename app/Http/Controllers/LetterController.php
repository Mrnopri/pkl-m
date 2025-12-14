<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterTemplate;
use App\Models\PklApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterController extends Controller
{
    /**
     * Display a listing of generated letters.
     */
    public function index()
    {
        $letters = Letter::with(['template', 'creator', 'participants'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.letters.index', compact('letters'));
    }

    /**
     * Show the form for creating a new letter.
     */
    public function create()
    {
        $templates = LetterTemplate::where('is_active', true)->get();
        $approvedStudents = PklApplication::with(['user', 'unit', 'supervisor'])
            ->where('status', 'approved')
            ->get();

        return view('admin.letters.create', compact('templates', 'approvedStudents'));
    }

    /**
     * Store a newly created letter in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_template_id' => 'required|exists:letter_templates,id',
            'letter_number' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'reference_date' => 'nullable|date',
            'letter_date' => 'required|date',
            'purpose' => 'nullable|string',
            'duration' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'pkl_start_date' => 'nullable|date',
            'signatory_name' => 'required|string|max:255',
            'signatory_position' => 'nullable|string|max:255',
            'signatory_nik' => 'nullable|string|max:255',
            'signature_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:pkl_applications,id',
        ]);

        $letterData = [
            'letter_template_id' => $validated['letter_template_id'],
            'letter_number' => $validated['letter_number'],
            'recipient_name' => $validated['recipient_name'],
            'reference_number' => $validated['reference_number'] ?? null,
            'reference_date' => $validated['reference_date'] ?? null,
            'letter_date' => $validated['letter_date'],
            'purpose' => $validated['purpose'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'pkl_start_date' => $validated['pkl_start_date'] ?? null,
            'signatory_name' => $validated['signatory_name'],
            'signatory_position' => $validated['signatory_position'] ?? null,
            'signatory_nik' => $validated['signatory_nik'] ?? null,
            'created_by' => auth()->id(),
        ];

        // Handle signature upload
        if ($request->hasFile('signature_file')) {
            $file = $request->file('signature_file');
            $path = $file->store('signatures', 'public');
            $letterData['signature_path'] = $path;
        }

        // Create letter
        $letter = Letter::create($letterData);

        // Attach students
        $letter->participants()->attach($validated['student_ids']);

        // Generate letter content
        $this->generateLetterContent($letter);

        return redirect()
            ->route('admin.letters.show', $letter->id)
            ->with('success', 'Surat berhasil dibuat!');
    }

    /**
     * Display the specified letter.
     */
    public function show(string $id)
    {
        $letter = Letter::with(['template', 'creator', 'participants.user', 'participants.unit', 'participants.supervisor'])
            ->findOrFail($id);

        return view('admin.letters.show', compact('letter'));
    }

    /**
     * Show the form for editing the specified letter.
     */
    public function edit(string $id)
    {
        $letter = Letter::with('participants')->findOrFail($id);
        $templates = LetterTemplate::where('is_active', true)->get();
        $approvedStudents = PklApplication::with(['user', 'unit', 'supervisor'])
            ->where('status', 'approved')
            ->get();

        return view('admin.letters.edit', compact('letter', 'templates', 'approvedStudents'));
    }

    /**
     * Update the specified letter in storage.
     */
    public function update(Request $request, string $id)
    {
        $letter = Letter::findOrFail($id);

        $validated = $request->validate([
            'letter_template_id' => 'required|exists:letter_templates,id',
            'letter_number' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'reference_date' => 'nullable|date',
            'letter_date' => 'required|date',
            'purpose' => 'nullable|string',
            'duration' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'pkl_start_date' => 'nullable|date',
            'signatory_name' => 'required|string|max:255',
            'signatory_position' => 'nullable|string|max:255',
            'signatory_nik' => 'nullable|string|max:255',
            'signature_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:pkl_applications,id',
        ]);

        $letterData = [
            'letter_template_id' => $validated['letter_template_id'],
            'letter_number' => $validated['letter_number'],
            'recipient_name' => $validated['recipient_name'],
            'reference_number' => $validated['reference_number'] ?? null,
            'reference_date' => $validated['reference_date'] ?? null,
            'letter_date' => $validated['letter_date'],
            'purpose' => $validated['purpose'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'pkl_start_date' => $validated['pkl_start_date'] ?? null,
            'signatory_name' => $validated['signatory_name'],
            'signatory_position' => $validated['signatory_position'] ?? null,
            'signatory_nik' => $validated['signatory_nik'] ?? null,
        ];

        // Handle signature upload
        if ($request->hasFile('signature_file')) {
            // Delete old signature if exists
            if ($letter->signature_path) {
                Storage::disk('public')->delete($letter->signature_path);
            }

            $file = $request->file('signature_file');
            $path = $file->store('signatures', 'public');
            $letterData['signature_path'] = $path;
        }

        // Update letter
        $letter->update($letterData);

        // Sync students
        $letter->participants()->sync($validated['student_ids']);

        // Regenerate letter content
        $this->generateLetterContent($letter);

        return redirect()
            ->route('admin.letters.show', $letter->id)
            ->with('success', 'Surat berhasil diupdate!');
    }

    /**
     * Remove the specified letter from storage.
     */
    public function destroy(string $id)
    {
        $letter = Letter::findOrFail($id);

        // Delete associated files
        if ($letter->signature_path) {
            Storage::disk('public')->delete($letter->signature_path);
        }
        if ($letter->pdf_path) {
            Storage::disk('public')->delete($letter->pdf_path);
        }

        $letter->delete();

        return redirect()
            ->route('admin.letters.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    /**
     * Download letter as PDF.
     */
    public function download(string $id)
    {
        $letter = Letter::findOrFail($id);

        // Generate PDF if not exists
        if (!$letter->pdf_path || !Storage::disk('public')->exists($letter->pdf_path)) {
            $this->generatePDF($letter);
        }

        return response()->download(storage_path('app/public/' . $letter->pdf_path));
    }

    /**
     * Get approved students for AJAX request.
     */
    public function getApprovedStudents()
    {
        $students = PklApplication::with(['user', 'unit', 'supervisor'])
            ->where('status', 'approved')
            ->get()
            ->map(function ($app) {
                return [
                    'id' => $app->id,
                    'name' => $app->user->name,
                    'nim' => $app->nim,
                    'major' => $app->major,
                    'unit' => $app->unit->name ?? '-',
                    'supervisor' => $app->supervisor->name ?? '-',
                ];
            });

        return response()->json($students);
    }

    /**
     * Generate letter content from template.
     */
    private function generateLetterContent(Letter $letter)
    {
        $letter->load(['template', 'participants.user', 'participants.unit', 'participants.supervisor']);

        $content = $letter->template->content;

        // Replace basic placeholders
        $replacements = [
            '{{letter_number}}' => $letter->letter_number,
            '{{recipient}}' => $letter->recipient_name,
            '{{reference_number}}' => $letter->reference_number ?? '-',
            '{{reference_date}}' => $letter->reference_date ? $letter->reference_date->format('d F Y') : '-',
            '{{letter_date}}' => $letter->letter_date->format('d F Y'),
            '{{purpose}}' => $letter->purpose ?? '-',
            '{{duration}}' => $letter->duration ?? '-',
            '{{start_date}}' => $letter->start_date ? $letter->start_date->format('d F Y') : '-',
            '{{end_date}}' => $letter->end_date ? $letter->end_date->format('d F Y') : '-',
            '{{pkl_start_date}}' => $letter->pkl_start_date ? $letter->pkl_start_date->format('d F Y') : '-',
            '{{signatory_name}}' => $letter->signatory_name,
            '{{signatory_position}}' => $letter->signatory_position ?? '',
            '{{signatory_nik}}' => $letter->signatory_nik ?? '',
        ];

        // Replace signature
        if ($letter->signature_path) {
            $signatureUrl = asset('storage/' . $letter->signature_path);
            $replacements['{{signature}}'] = '<img src="' . $signatureUrl . '" alt="Signature" style="height: 60px;">';
        } else {
            $replacements['{{signature}}'] = '';
        }

        // Generate student table
        $studentTableHtml = $this->generateStudentTable($letter->participants);
        $replacements['{{student_table}}'] = $studentTableHtml;

        foreach ($replacements as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        $letter->update(['generated_content' => $content]);

        // Generate PDF
        $this->generatePDF($letter);
    }

    /**
     * Generate student table HTML.
     */
    private function generateStudentTable($participants)
    {
        $html = '<table class="border-table" style="width: 100%; border-collapse: collapse; margin: 15px 0;">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">No.</th>';
        $html .= '<th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0;">Nama</th>';
        $html .= '<th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">NPM</th>';
        $html .= '<th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">Jurusan</th>';
        $html .= '<th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">Unit</th>';
        $html .= '<th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0;">Pembimbing</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        foreach ($participants as $index => $participant) {
            $html .= '<tr>';
            $html .= '<td style="border: 1px solid #000; padding: 6px; text-align: center;">' . ($index + 1) . '.</td>';
            $html .= '<td style="border: 1px solid #000; padding: 6px;">' . ($participant->user->name ?? '-') . '</td>';
            $html .= '<td style="border: 1px solid #000; padding: 6px; text-align: center;">' . ($participant->nim ?? '-') . '</td>';
            $html .= '<td style="border: 1px solid #000; padding: 6px; text-align: center;">' . ($participant->major ?? '-') . '</td>';
            $html .= '<td style="border: 1px solid #000; padding: 6px; text-align: center;">' . ($participant->unit->name ?? '-') . '</td>';
            $html .= '<td style="border: 1px solid #000; padding: 6px;">' . ($participant->supervisor->name ?? '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    /**
     * Generate PDF from letter content.
     */
    private function generatePDF(Letter $letter)
    {
        $pdf = Pdf::loadHTML($letter->generated_content)
            ->setPaper('a4', 'portrait');

        $filename = 'letter_' . $letter->id . '_' . time() . '.pdf';
        $path = 'letters/pdf/' . $filename;

        // Delete old PDF if exists
        if ($letter->pdf_path && Storage::disk('public')->exists($letter->pdf_path)) {
            Storage::disk('public')->delete($letter->pdf_path);
        }

        Storage::disk('public')->put($path, $pdf->output());

        $letter->update(['pdf_path' => $path]);
    }
}
