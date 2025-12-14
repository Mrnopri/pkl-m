@extends('layouts.admin')

@section('header', 'Buat Surat Baru')

@section('content')
    <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-100px)]">
        <!-- LEFT COLUMN: FORM -->
        <div class="w-full lg:w-1/3 bg-white rounded-xl border border-slate-200 flex flex-col shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-slate-50">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span>📝</span> Konfigurasi Surat
                </h2>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4">
                <form id="letterForm" action="{{ route('admin.letters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Template Selection -->
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                        <label for="letter_template_id" class="block text-xs font-bold text-blue-800 mb-1 uppercase">Template Surat <span class="text-rose-600">*</span></label>
                        <select id="letter_template_id" name="letter_template_id"
                            class="block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">-- Pilih Template --</option>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}" {{ old('letter_template_id') == $template->id ? 'selected' : '' }}>
                                    {{ $template->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('letter_template_id')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Letter Data -->
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 space-y-3">
                        <h3 class="text-xs font-bold text-slate-500 uppercase">Data Surat</h3>
                        
                        <div>
                            <label for="letter_number" class="block text-xs font-medium text-slate-700">Nomor Surat <span class="text-rose-600">*</span></label>
                            <input type="text" id="letter_number" name="letter_number" value="{{ old('letter_number') }}"
                                placeholder="Tel. 43/PS 0000/..."
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="letter_date" class="block text-xs font-medium text-slate-700">Tanggal Surat <span class="text-rose-600">*</span></label>
                            <input type="date" id="letter_date" name="letter_date" value="{{ old('letter_date', date('Y-m-d')) }}"
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="recipient_name" class="block text-xs font-medium text-slate-700">Kepada Yth. <span class="text-rose-600">*</span></label>
                            <textarea id="recipient_name" name="recipient_name" rows="2"
                                placeholder="Dekan Fakultas..."
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ old('recipient_name') }}</textarea>
                        </div>
                    </div>

                    <!-- Reference Data -->
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 space-y-3">
                        <h3 class="text-xs font-bold text-slate-500 uppercase">Referensi</h3>
                        
                        <div>
                            <label for="reference_number" class="block text-xs font-medium text-slate-700">Surat Saudara Nomor</label>
                            <input type="text" id="reference_number" name="reference_number" value="{{ old('reference_number') }}"
                                placeholder="Nomor: 2475/..."
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="reference_date" class="block text-xs font-medium text-slate-700">Tanggal Surat Saudara</label>
                            <input type="date" id="reference_date" name="reference_date" value="{{ old('reference_date') }}"
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Execution Data -->
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 space-y-3">
                        <h3 class="text-xs font-bold text-slate-500 uppercase">Pelaksanaan</h3>
                        
                        <div>
                            <label for="purpose" class="block text-xs font-medium text-slate-700">Perihal / Kegiatan</label>
                            <input type="text" id="purpose" name="purpose" value="{{ old('purpose', 'Praktik Kerja Lapangan') }}"
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="duration" class="block text-xs font-medium text-slate-700">Durasi</label>
                                <input type="text" id="duration" name="duration" value="{{ old('duration', '1 bulan') }}"
                                    class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="pkl_start_date" class="block text-xs font-medium text-slate-700">Tgl Briefing</label>
                                <input type="date" id="pkl_start_date" name="pkl_start_date" value="{{ old('pkl_start_date') }}"
                                    class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="start_date" class="block text-xs font-medium text-slate-700">Mulai</label>
                                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                                    class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-xs font-medium text-slate-700">Sampai</label>
                                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                                    class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Signatory -->
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 space-y-3">
                        <h3 class="text-xs font-bold text-slate-500 uppercase">Penandatangan</h3>
                        
                        <div>
                            <label for="signatory_position" class="block text-xs font-medium text-slate-700">Jabatan</label>
                            <input type="text" id="signatory_position" name="signatory_position" value="{{ old('signatory_position', 'MANAGER SHARED SERVICE LAMPUNG') }}"
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="signatory_name" class="block text-xs font-medium text-slate-700">Nama Lengkap <span class="text-rose-600">*</span></label>
                            <input type="text" id="signatory_name" name="signatory_name" value="{{ old('signatory_name', 'SULASMADI') }}"
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="signatory_nik" class="block text-xs font-medium text-slate-700">NIK</label>
                            <input type="text" id="signatory_nik" name="signatory_nik" value="{{ old('signatory_nik', 'NIK. 710116') }}"
                                class="mt-1 block w-full text-sm border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="signature_file" class="block text-xs font-medium text-slate-700">Upload Tanda Tangan</label>
                            <input type="file" id="signature_file" name="signature_file" accept="image/*"
                                class="mt-1 block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <!-- Students -->
                    <div class="bg-white p-3 rounded-lg border-2 border-slate-300 space-y-3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xs font-bold text-slate-700 uppercase">Pilih Peserta</h3>
                            <span id="selected-count" class="text-xs text-slate-500">0 terpilih</span>
                        </div>
                        
                        <div class="max-h-40 overflow-y-auto border border-slate-200 rounded text-sm">
                            <table class="w-full text-left">
                                <thead class="bg-slate-100 sticky top-0">
                                    <tr>
                                        <th class="p-2 w-8 text-center"><input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll()"></th>
                                        <th class="p-2 text-xs font-semibold text-slate-600">Nama</th>
                                        <th class="p-2 text-xs font-semibold text-slate-600">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($approvedStudents as $student)
                                        <tr class="border-b hover:bg-slate-50">
                                            <td class="p-2 text-center">
                                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                    data-name="{{ $student->user->name ?? '-' }}"
                                                    data-nim="{{ $student->nim ?? '-' }}"
                                                    data-major="{{ $student->major ?? '-' }}"
                                                    data-unit="{{ $student->unit->name ?? '-' }}"
                                                    data-supervisor="{{ $student->supervisor->name ?? '-' }}"
                                                    class="student-checkbox rounded text-blue-600 focus:ring-blue-500"
                                                    onchange="updateSelectedCount()">
                                            </td>
                                            <td class="p-2 text-xs">{{ $student->user->name ?? '-' }}</td>
                                            <td class="p-2 text-xs text-slate-500">{{ $student->unit->name ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-xs text-slate-400">Tidak ada peserta approved</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="pt-4 sticky bottom-0 bg-white border-t border-slate-100">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition text-sm">
                            💾 Simpan & Generate PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT COLUMN: PREVIEW -->
        <div class="flex-1 bg-slate-200 rounded-xl border border-slate-300 overflow-hidden flex flex-col">
            <div class="p-3 bg-slate-800 text-white flex justify-between items-center">
                <h3 class="text-sm font-bold flex items-center gap-2">
                    <span>👁️</span> Live Preview
                </h3>
                <span class="text-xs text-slate-400">Preview mungkin sedikit berbeda dengan hasil PDF</span>
            </div>
            
            <div class="flex-1 overflow-auto p-8 flex justify-center bg-slate-200" id="preview-container">
                <!-- A4 Paper -->
                <div id="letter-preview" class="bg-white shadow-lg relative hidden" style="width: 210mm; min-height: 297mm; padding: 20mm;">
                    <!-- Content will be injected here -->
                </div>
                
                <div id="preview-placeholder" class="flex flex-col items-center justify-center h-full text-slate-400">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p>Pilih template untuk melihat preview</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data & Elements
        const form = document.getElementById('letterForm');
        const templateSelect = document.getElementById('letter_template_id');
        const previewContainer = document.getElementById('letter-preview');
        const previewPlaceholder = document.getElementById('preview-placeholder');
        
        let currentTemplateContent = '';

        // Format Date Indo
        const formatDateIndo = (dateString) => {
            if (!dateString) return "...";
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        };

        // Fetch Template Data
        templateSelect.addEventListener('change', async function() {
            const id = this.value;
            if (!id) {
                previewContainer.classList.add('hidden');
                previewPlaceholder.classList.remove('hidden');
                return;
            }

            try {
                const response = await fetch(`/admin/letter-templates/${id}/data`);
                const data = await response.json();
                
                currentTemplateContent = data.content;
                previewContainer.innerHTML = currentTemplateContent;
                previewContainer.classList.remove('hidden');
                previewPlaceholder.classList.add('hidden');
                
                updatePreview(); // Trigger update with current form values
            } catch (error) {
                console.error('Error fetching template:', error);
                alert('Gagal memuat template');
            }
        });

        // Listen for Input Changes
        form.addEventListener('input', updatePreview);

        // Update Preview Function
        function updatePreview() {
            if (!currentTemplateContent) return;

            let content = currentTemplateContent;
            
            // Map inputs to placeholders
            const replacements = {
                '@{{letter_number}}': document.getElementById('letter_number').value,
                '@{{letter_date}}': formatDateIndo(document.getElementById('letter_date').value),
                '@{{recipient}}': document.getElementById('recipient_name').value.replace(/\n/g, '<br>'),
                '@{{reference_number}}': document.getElementById('reference_number').value,
                '@{{reference_date}}': formatDateIndo(document.getElementById('reference_date').value),
                '@{{purpose}}': document.getElementById('purpose').value,
                '@{{duration}}': document.getElementById('duration').value,
                '@{{start_date}}': formatDateIndo(document.getElementById('start_date').value),
                '@{{end_date}}': formatDateIndo(document.getElementById('end_date').value),
                '@{{pkl_start_date}}': formatDateIndo(document.getElementById('pkl_start_date').value),
                '@{{signatory_name}}': document.getElementById('signatory_name').value,
                '@{{signatory_position}}': document.getElementById('signatory_position').value,
                '@{{signatory_nik}}': document.getElementById('signatory_nik').value,
            };

            // Replace text placeholders
            for (const [placeholder, value] of Object.entries(replacements)) {
                content = content.replaceAll(placeholder, value || '...');
            }

            // Handle Student Table
            const studentTableHtml = generateStudentTableHtml();
            content = content.replace('@{{student_table}}', studentTableHtml);

            // Handle Signature (Preview only shows placeholder or uploaded image if we implemented file reading)
            // For now just show text placeholder
            content = content.replace('@{{signature}}', '<div class="border border-dashed border-gray-400 h-20 flex items-center justify-center text-gray-400 text-xs">(Tanda Tangan)</div>');

            previewContainer.innerHTML = content;
        }

        // Generate Student Table HTML for Preview
        function generateStudentTableHtml() {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            if (checkboxes.length === 0) {
                return '<p class="text-center italic text-gray-400 my-4">Belum ada peserta dipilih</p>';
            }

            let rows = '';
            checkboxes.forEach((cb, index) => {
                rows += `
                    <tr>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">${index + 1}.</td>
                        <td style="border: 1px solid #000; padding: 6px;">${cb.dataset.name}</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">${cb.dataset.nim}</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">${cb.dataset.major}</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">${cb.dataset.unit}</td>
                        <td style="border: 1px solid #000; padding: 6px;">${cb.dataset.supervisor}</td>
                    </tr>
                `;
            });

            return `
                <table style="width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 11pt;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">No.</th>
                            <th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0;">Nama</th>
                            <th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">NPM</th>
                            <th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">Jurusan</th>
                            <th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0; text-align: center;">Unit</th>
                            <th style="border: 1px solid #000; padding: 6px; background-color: #f0f0f0;">Pembimbing</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            `;
        }

        // Checkbox Logic
        function updateSelectedCount() {
            const count = document.querySelectorAll('.student-checkbox:checked').length;
            document.getElementById('selected-count').textContent = `${count} terpilih`;
            updatePreview();
        }

        function toggleSelectAll() {
            const isChecked = document.getElementById('selectAllCheckbox').checked;
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = isChecked);
            updateSelectedCount();
        }

        // Signature Image Preview
        document.getElementById('signature_file').addEventListener('change', function(e) {
            // Optional: Implement image preview if needed
        });
    </script>
@endsection
