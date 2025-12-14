@extends('layouts.admin')

@section('header', 'Preview Template Surat')

@section('content')
    <div class="bg-white p-6 rounded-xl border border-slate-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Preview: {{ $template->name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.letter-templates.edit', $template->id) }}"
                    class="inline-block px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 text-sm">
                    Edit Template
                </a>
                <a href="{{ route('admin.letter-templates.index') }}"
                    class="inline-block px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 text-sm">
                    Kembali
                </a>
            </div>
        </div>

        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-800">
                <strong>Info:</strong> Ini adalah preview template dengan data contoh. Data sebenarnya akan diisi saat
                membuat surat.
            </p>
        </div>

        <div class="p-6 border rounded-lg bg-white" style="max-height: 800px; overflow-y: auto;">
            {!! $content !!}
        </div>
    </div>
@endsection