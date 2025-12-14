@extends('layouts.admin')

@section('header', 'Edit Surat')

@section('content')
    <div class="bg-white p-6 rounded-xl border border-slate-200">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Edit Surat Penugasan PKL</h2>

        <form action="{{ route('admin.letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Template Selection -->
                <div>
                    <label for="letter_template_id" class="block text-sm font-medium text-slate-700">Template Surat <span
                            class="text-rose-600">*</span></label>
                    <select id="letter_template_id" name="letter_template_id"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                        required>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}" {{ old('letter_template_id', $letter->letter_template_id) == $template->id ? 'selected' : '' }}>
                                {{ $template->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('letter_template_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Letter Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="letter_number" class="block text-sm font-medium text-slate-700">Nomor Surat <span
                                class="text-rose-600">*</span></label>
                        <input type="text" id="letter_number" name="letter_number"
                            value="{{ old('letter_number', $letter->letter_number) }}"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                            required>
                        @error('letter_number')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="letter_date" class="block text-sm font-medium text-slate-700">Tanggal Surat <span
                                class="text-rose-600">*</span></label>
                        <input type="date" id="letter_date" name="letter_date"
                            value="{{ old('letter_date', $letter->letter_date->format('Y-m-d')) }}"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                            required>
                        @error('letter_date')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="recipient_name" class="block text-sm font-medium text-slate-700">Kepada <span
                            class="text-rose-600">*</span></label>
                    <input type="text" id="recipient_name" name="recipient_name"
                        value="{{ old('recipient_name', $letter->recipient_name) }}"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                        required>
                    @error('recipient_name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reference_number" class="block text-sm font-medium text-slate-700">Surat Saudara
                        Nomor</label>
                    <input type="text" id="reference_number" name="reference_number"
                        value="{{ old('reference_number', $letter->reference_number) }}"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">
                    @error('reference_number')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="purpose" class="block text-sm font-medium text-slate-700">Untuk Pelaksanaan</label>
                    <textarea id="purpose" name="purpose" rows="2"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">{{ old('purpose', $letter->purpose) }}</textarea>
                    @error('purpose')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="duration" class="block text-sm font-medium text-slate-700">Selama</label>
                        <input type="text" id="duration" name="duration" value="{{ old('duration', $letter->duration) }}"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">
                        @error('duration')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-700">Mulai Tanggal</label>
                        <input type="date" id="start_date" name="start_date"
                            value="{{ old('start_date', $letter->start_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">
                        @error('start_date')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-slate-700">Sampai Tanggal</label>
                        <input type="date" id="end_date" name="end_date"
                            value="{{ old('end_date', $letter->end_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">
                        @error('end_date')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="pkl_start_date" class="block text-sm font-medium text-slate-700">Awal Mulai PKL</label>
                    <input type="date" id="pkl_start_date" name="pkl_start_date"
                        value="{{ old('pkl_start_date', $letter->pkl_start_date?->format('Y-m-d')) }}"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">
                    @error('pkl_start_date')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Signatory Information -->
                <div class="border-t pt-4">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Penandatangan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="signatory_name" class="block text-sm font-medium text-slate-700">Nama Penandatangan
                                <span class="text-rose-600">*</span></label>
                            <input type="text" id="signatory_name" name="signatory_name"
                                value="{{ old('signatory_name', $letter->signatory_name) }}"
                                class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                                required>
                            @error('signatory_name')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="signatory_position" class="block text-sm font-medium text-slate-700">Jabatan</label>
                            <input type="text" id="signatory_position" name="signatory_position"
                                value="{{ old('signatory_position', $letter->signatory_position) }}"
                                class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">
                            @error('signatory_position')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="signatory_nik" class="block text-sm font-medium text-slate-700">NIK</label>
                        <input type="text" id="signatory_nik" name="signatory_nik"
                            value="{{ old('signatory_nik', $letter->signatory_nik) }}"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">
                        @error('signatory_nik')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="signature_file" class="block text-sm font-medium text-slate-700">Upload Tanda Tangan
                            Baru</label>
                        <input type="file" id="signature_file" name="signature_file" accept="image/*"
                            class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                        @if ($letter->signature_path)
                            <p class="mt-2 text-sm text-slate-600">Tanda tangan saat ini:</p>
                            <img src="{{ asset('storage/' . $letter->signature_path) }}" alt="Current Signature"
                                class="mt-1 h-16 border rounded">
                        @endif
                        @error('signature_file')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Student Selection -->
                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Pilih Peserta PKL <span
                                class="text-rose-600">*</span></h3>
                        <div class="space-x-2">
                            <button type="button" onclick="selectAll()"
                                class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">Pilih
                                Semua</button>
                            <button type="button" onclick="deselectAll()"
                                class="px-3 py-1 text-xs bg-slate-100 text-slate-700 rounded-md hover:bg-slate-200">Hapus
                                Semua</button>
                        </div>
                    </div>

                    @error('student_ids')
                        <p class="mb-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    @php
                        $selectedIds = old('student_ids', $letter->participants->pluck('id')->toArray());
                    @endphp

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full text-sm">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll()"
                                            class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-slate-300 rounded">
                                    </th>
                                    <th scope="col" class="px-4 py-3 font-medium">Nama</th>
                                    <th scope="col" class="px-4 py-3 font-medium">NPM/NIM</th>
                                    <th scope="col" class="px-4 py-3 font-medium">Jurusan</th>
                                    <th scope="col" class="px-4 py-3 font-medium">Unit</th>
                                    <th scope="col" class="px-4 py-3 font-medium">Pembimbing</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedStudents as $student)
                                    <tr class="bg-white border-b border-slate-200 hover:bg-slate-50">
                                        <td class="px-4 py-3 text-center">
                                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                class="student-checkbox h-4 w-4 text-rose-600 focus:ring-rose-500 border-slate-300 rounded"
                                                {{ in_array($student->id, $selectedIds) ? 'checked' : '' }}>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-slate-900">{{ $student->user->name ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $student->nim ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $student->major ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $student->unit->name ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $student->supervisor->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                            Tidak ada peserta PKL yang disetujui.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-2 text-sm text-slate-500">
                        <span id="selected-count">0</span> peserta dipilih
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('admin.letters.show', $letter->id) }}"
                    class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-md hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700">Update
                    Surat</button>
            </div>
        </form>
    </div>

    <script>
        // Update selected count
        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            document.getElementById('selected-count').textContent = checkedBoxes.length;
        }

        // Select all checkboxes
        function selectAll() {
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = true);
            document.getElementById('selectAllCheckbox').checked = true;
            updateSelectedCount();
        }

        // Deselect all checkboxes
        function deselectAll() {
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAllCheckbox').checked = false;
            updateSelectedCount();
        }

        // Toggle all checkboxes
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            document.querySelectorAll('.student-checkbox').forEach(cb => {
                cb.checked = selectAllCheckbox.checked;
            });
            updateSelectedCount();
        }

        // Update count when individual checkbox is clicked
        document.querySelectorAll('.student-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedCount);
        });

        // Initialize count
        updateSelectedCount();
    </script>
@endsection