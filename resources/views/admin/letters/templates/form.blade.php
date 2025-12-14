@extends('layouts.admin')

@section('header', $template ? 'Edit Template Surat' : 'Tambah Template Surat')

@section('content')
    <div class="bg-white p-6 rounded-xl border border-slate-200">
        <h2 class="text-xl font-bold text-slate-800 mb-6">{{ $template ? 'Edit' : 'Tambah' }} Template Surat</h2>

        <form action="{{ $template ? route('admin.letter-templates.update', $template->id) : route('admin.letter-templates.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if ($template)
                @method('PUT')
            @endif

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Nama Template <span
                            class="text-rose-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $template->name ?? '') }}"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500">{{ old('description', $template->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="template_file" class="block text-sm font-medium text-slate-700">Upload Template Word</label>
                    <input type="file" id="template_file" name="template_file" accept=".doc,.docx,.html"
                        class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                    <p class="mt-1 text-xs text-slate-500">Upload file Word (.doc, .docx) atau HTML. Maksimal 10MB.</p>
                    @if ($template && $template->template_file_path)
                        <p class="mt-2 text-sm text-slate-600">File saat ini: <span
                                class="font-medium">{{ basename($template->template_file_path) }}</span></p>
                    @endif
                    @error('template_file')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700">Konten Template (HTML)</label>
                    <p class="mt-1 mb-2 text-sm text-slate-500">Gunakan placeholder berikut dalam template:</p>
                    <div class="mb-2 p-3 bg-slate-50 rounded-md text-xs space-y-1">
                        @verbatim
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{letter_number}}</code> - Nomor Surat</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{recipient}}</code> - Kepada</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{reference_number}}</code> - Surat Saudara Nomor</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{reference_date}}</code> - Tanggal Surat Saudara</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{letter_date}}</code> - Tanggal</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{purpose}}</code> - Untuk Pelaksanaan</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{duration}}</code> - Selama</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{start_date}}</code> - Mulai Tanggal</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{end_date}}</code> - Sampai Tanggal</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{pkl_start_date}}</code> - Awal Mulai PKL</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{signatory_name}}</code> - Nama Penandatangan</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{signatory_position}}</code> - Jabatan Penandatangan</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{signatory_nik}}</code> - NIK Penandatangan</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{signature}}</code> - Gambar Tanda Tangan</p>
                        <p><code class="px-1 py-0.5 bg-slate-200 rounded">{{student_table}}</code> - Tabel Mahasiswa</p>
                        @endverbatim
                    </div>
                    <textarea id="content" name="content" rows="15"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500 font-mono text-sm">{{ old('content', $template->content ?? '') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', $template->is_active ?? true) ? 'checked' : '' }}
                        class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-slate-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-slate-700">Template Aktif</label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('admin.letter-templates.index') }}"
                    class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-md hover:bg-slate-50">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700">{{ $template ? 'Update' : 'Simpan' }}</button>
            </div>
        </form>
    </div>
@endsection
