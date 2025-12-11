@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Formulir Pendaftaran PKL</h2>
            <p class="text-gray-500 mb-6">Lengkapi data dan unggah berkas yang diperlukan untuk mengajukan
                permohonan PKL.</p>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data"
                id="form-pendaftaran">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="education_level" class="block text-sm font-medium text-gray-700">Jenjang
                            Pendidikan Anda</label>
                        <select id="education_level" name="education_level"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                            <option value="Perguruan Tinggi (S1/D3)">Perguruan Tinggi (S1/D3)</option>
                            <option value="SMK">SMK/SMA Sederajat</option>
                        </select>
                        <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
                    </div>
                    <div>
                        <label id="label-instansi" for="institution_name"
                            class="block text-sm font-medium text-gray-700">Nama Perguruan Tinggi</label>
                        <input type="text" id="institution_name" name="institution_name"
                            placeholder="Contoh: Institut Teknologi Sumatera"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                            required>
                        <x-input-error :messages="$errors->get('institution_name')" class="mt-2" />
                    </div>
                    <div>
                        <label id="label-jurusan" for="major"
                            class="block text-sm font-medium text-gray-700">Jurusan</label>
                        <input type="text" id="major" name="major" placeholder="Contoh: Teknik Informatika"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                            required>
                        <x-input-error :messages="$errors->get('major')" class="mt-2" />
                    </div>
                    <div>
                        <label id="label-nim" for="nim" class="block text-sm font-medium text-gray-700">NIM (Nomor
                            Induk Mahasiswa)</label>
                        <input type="text" id="nim" name="nim" value="{{ Auth::user()->nim }}"
                            placeholder="Contoh: 121140132"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                            required>
                        <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Usulan Tanggal
                                Mulai</label>
                            <input type="date" id="start_date" name="start_date"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                required>
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Usulan Tanggal
                                Selesai</label>
                            <input type="date" id="end_date" name="end_date"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                required>
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Berkas
                            Persyaratan</label>
                        <p class="text-xs text-gray-500 mb-2">Unggah semua berkas yang diperlukan (misal: Surat
                            Permohonan, CV, Transkrip/Rapor).</p>
                        <div id="drop-zone"
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-red-600 hover:text-red-500">
                                        <span>Pilih file untuk diunggah</span>
                                        <input id="file" name="file" type="file" class="sr-only"
                                            onchange="updateFileName(this)">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOCX, JPG, PNG</p>
                            </div>
                        </div>
                        <div id="file-name-display" class="mt-2 text-sm text-gray-600"></div>
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">Kirim
                        Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const pendidikanSelect = document.getElementById('education_level');
        const labelInstansi = document.getElementById('label-instansi');
        const labelNim = document.getElementById('label-nim');
        const dropZone = document.getElementById('drop-zone');

        pendidikanSelect.addEventListener('change', (e) => {
            const jurusanInput = document.getElementById('major');
            if (e.target.value === 'Perguruan Tinggi (S1/D3)') {
                labelInstansi.textContent = 'Nama Perguruan Tinggi';
                document.getElementById('institution_name').placeholder = 'Contoh: Institut Teknologi Sumatera';
                jurusanInput.placeholder = 'Contoh: Teknik Informatika';
                labelNim.textContent = 'NIM (Nomor Induk Mahasiswa)';
                document.getElementById('nim').placeholder = 'Contoh: 121140132';
            } else {
                labelInstansi.textContent = 'Nama Instansi Sekolah';
                document.getElementById('institution_name').placeholder = 'Contoh: SMK Negeri 2 Bandar Lampung';
                jurusanInput.placeholder = 'Contoh: Teknik Komputer dan Jaringan';
                labelNim.textContent = 'NISN (Nomor Induk Siswa Nasional)';
                document.getElementById('nim').placeholder = 'Contoh: 0012345678';
            }
        });

        function updateFileName(input) {
            const display = document.getElementById('file-name-display');
            if (input.files && input.files.length > 0) {
                display.textContent = 'File terpilih: ' + input.files[0].name;
            } else {
                display.textContent = '';
            }
        }
    </script>
@endpush