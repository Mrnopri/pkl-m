<?php

namespace App\Http\Controllers;

use App\Models\LetterTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

class LetterTemplateController extends Controller
{
    /**
     * Display a listing of the letter templates.
     */
    public function index()
    {
        $templates = LetterTemplate::with('creator')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.letters.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        return view('admin.letters.templates.form', [
            'template' => null,
        ]);
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_file' => 'nullable|file|mimes:doc,docx,html|max:10240',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $templateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'is_active' => $request->has('is_active'),
            'created_by' => auth()->id(),
        ];

        // Handle Word file upload
        if ($request->hasFile('template_file')) {
            $file = $request->file('template_file');
            $path = $file->store('letter-templates', 'public');
            $templateData['template_file_path'] = $path;

            // Extract content from Word file (optional - for preview)
            if (in_array($file->getClientOriginalExtension(), ['doc', 'docx'])) {
                try {
                    $phpWord = IOFactory::load($file->getRealPath());
                    $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

                    ob_start();
                    $htmlWriter->save('php://output');
                    $htmlContent = ob_get_clean();

                    $templateData['content'] = $htmlContent;
                } catch (\Exception $e) {
                    // If extraction fails, just store the file path
                }
            }
        }

        LetterTemplate::create($templateData);

        return redirect()
            ->route('admin.letter-templates.index')
            ->with('success', 'Template surat berhasil dibuat!');
    }

    /**
     * Display the specified template.
     */
    public function show(string $id)
    {
        $template = LetterTemplate::with('creator')->findOrFail($id);
        return view('admin.letters.templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(string $id)
    {
        $template = LetterTemplate::findOrFail($id);
        return view('admin.letters.templates.form', compact('template'));
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, string $id)
    {
        $template = LetterTemplate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_file' => 'nullable|file|mimes:doc,docx,html|max:10240',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $templateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        // Handle Word file upload
        if ($request->hasFile('template_file')) {
            // Delete old file if exists
            if ($template->template_file_path) {
                Storage::disk('public')->delete($template->template_file_path);
            }

            $file = $request->file('template_file');
            $path = $file->store('letter-templates', 'public');
            $templateData['template_file_path'] = $path;

            // Extract content from Word file
            if (in_array($file->getClientOriginalExtension(), ['doc', 'docx'])) {
                try {
                    $phpWord = IOFactory::load($file->getRealPath());
                    $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

                    ob_start();
                    $htmlWriter->save('php://output');
                    $htmlContent = ob_get_clean();

                    $templateData['content'] = $htmlContent;
                } catch (\Exception $e) {
                    // If extraction fails, just store the file path
                }
            }
        }

        $template->update($templateData);

        return redirect()
            ->route('admin.letter-templates.index')
            ->with('success', 'Template surat berhasil diupdate!');
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(string $id)
    {
        $template = LetterTemplate::findOrFail($id);

        // Delete associated file if exists
        if ($template->template_file_path) {
            Storage::disk('public')->delete($template->template_file_path);
        }

        $template->delete();

        return redirect()
            ->route('admin.letter-templates.index')
            ->with('success', 'Template surat berhasil dihapus!');
    }

    /**
     * Preview template with sample data.
     */
    public function preview(string $id)
    {
        $template = LetterTemplate::findOrFail($id);

        // Sample data for preview
        $sampleData = [
            'letter_number' => 'Tel. 43/PS 0000/R1W-KD2000/00/2024',
            'recipient' => 'Yth. Dekan Fakultas Teknologi Industri Itera',
            'reference_number' => 'Nomor: 2475/IT.9.3/PK.01.06/2024',
            'letter_date' => now()->format('d F Y'),
            'purpose' => 'Penerimaan Mahasiswa Praktik Kerja Lapangan',
            'duration' => '1 bulan',
            'start_date' => '10 Juni 2024',
            'end_date' => '20 Juli 2024',
            'pkl_start_date' => '20 Juni 2024',
            'signatory_name' => 'SULASMADI',
            'signatory_position' => 'MANAGER SHARED SERVICE LAMPUNG',
            'signatory_nik' => 'NIK. 710116',
            'signature' => '/images/sample-signature.png',
        ];

        $content = $this->replacePlaceholders($template->content, $sampleData);

        return view('admin.letters.templates.preview', compact('template', 'content'));
    }

    public function getData(string $id)
    {
        $template = LetterTemplate::findOrFail($id);
        return response()->json([
            'id' => $template->id,
            'name' => $template->name,
            'content' => $template->content,
        ]);
    }


    /**
     * Replace placeholders in template content with actual data.
     */
    private function replacePlaceholders($content, $data)
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }
}
