@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div id="status-content" class="bg-white p-8 rounded-lg shadow-xl">
                <!-- Status content will be populated by JS -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const statusPageContent = document.getElementById('status-content');

        function updateRegistrationStatusPage() {
            // Determine status from Blade variable
            const applicationStatus = @json($application ? $application->status : null);
            const unitName = @json($application && $application->unit ? $application->unit->name : null);
            const userStatus = applicationStatus ? applicationStatus : 'kosong';

            let contentHTML = '';

            const statusMap = {
                pending: {
                    title: 'Pendaftaran Sedang Ditinjau',
                    color: 'yellow',
                    icon: `<svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
                    message: 'Tim kami sedang melakukan verifikasi terhadap data dan berkas yang Anda kirim. Mohon tunggu informasi selanjutnya. Anda akan menerima notifikasi jika ada pembaruan.'
                },
                approved: {
                    title: 'Selamat, Pendaftaran Anda Diterima!',
                    color: 'green',
                    icon: `<svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
                    message: unitName
                        ? `Anda telah diterima untuk program PKL di PT. Telkom Indonesia Witel Lampung. Anda ditempatkan pada unit **${unitName}**. Surat tugas resmi dan informasi lebih lanjut akan dikirimkan ke email Anda.`
                        : 'Anda telah diterima untuk program PKL di PT. Telkom Indonesia Witel Lampung. Surat tugas resmi dan informasi lebih lanjut akan dikirimkan ke email Anda.'
                },
                rejected: {
                    title: 'Mohon Maaf, Pendaftaran Ditolak',
                    color: 'red',
                    icon: `<svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
                    message: 'Setelah melakukan peninjauan, kami belum dapat menerima pengajuan Anda saat ini.'
                },
                kosong: {
                    title: 'Anda Belum Melakukan Pendaftaran',
                    color: 'gray',
                    icon: `<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>`,
                    message: 'Silakan menuju ke halaman Pendaftaran PKL untuk mengajukan permohonan Anda.'
                }
            };

            const s = statusMap[userStatus] || statusMap['kosong'];
            contentHTML = `
                            <div class="text-center">
                                <div class="flex justify-center mb-4">${s.icon}</div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">${s.title}</h2>
                                <p class="text-gray-600 max-w-lg mx-auto">${s.message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')}</p>
                                ${userStatus === 'kosong' || userStatus === 'rejected' ? `<a href="{{ route('pendaftaran.create') }}" class="mt-6 inline-block px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">Buka Formulir Pendaftaran</a>` : ''}
                            </div>
                        `;
            statusPageContent.innerHTML = contentHTML;
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateRegistrationStatusPage();
        });
    </script>
@endpush