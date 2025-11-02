@extends('layouts.main')
@section('content')

    <div class="p-4 sm:ml-64 mt-16">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">
                Tracking Pengiriman Bahan Ajar
            </h2>

            <form id="trackingForm" class="flex flex-col sm:flex-row items-center gap-3 mb-6">
                <input type="text" id="nomorDO" name="nomorDO"
                    placeholder="Masukkan Nomor Delivery Order"
                    class="flex-1 w-full border border-gray-300 text-sm rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required />
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md px-5 py-2.5 focus:ring-4 focus:ring-blue-300">
                    Cari
                </button>
            </form>

            <!-- Hasil Tracking -->
            <div id="trackingResult" class="hidden">
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Detail Pengiriman</h3>

                    <div class="bg-gray-50 dark:bg-gray-700 shadow-md rounded-lg border border-gray-200 dark:border-gray-600 p-5">
                        <div id="trackingDetail" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-sm text-gray-700 dark:text-gray-200">
                            <!-- detail -->
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Riwayat Perjalanan</h3>
                    <div id="trackingTimeline" class="relative border-s border-gray-200 dark:border-gray-600 pl-4">
                    <!-- timeline perjalanan -->
                    </div>
                </div>
            </div>

            <!-- Notifikasi jika tidak ditemukan -->
            <div id="notFound" class="hidden text-center mt-6 text-red-600 font-medium">
                Nomor Delivery Order tidak ditemukan.
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="module">
        document.addEventListener('DOMContentLoaded', () => {
            const dataTracking = Store.getAllTracking();
            const form = document.getElementById('trackingForm');
            const input = document.getElementById('nomorDO');
            const result = document.getElementById('trackingResult');
            const notFound = document.getElementById('notFound');
            const detail = document.getElementById('trackingDetail');
            const timeline = document.getElementById('trackingTimeline');

            form.addEventListener('submit', (e) => {
            e.preventDefault();
            const nomorDO = input.value.trim();

            // Cek data
            const data = dataTracking[nomorDO];
            if (!data) {
                result.classList.add('hidden');
                notFound.classList.remove('hidden');
                return;
            }

            notFound.classList.add('hidden');
            result.classList.remove('hidden');

            detail.innerHTML = `
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Nomor DO</p>
                    <p class="font-semibold text-gray-900 dark:text-white">${data.nomorDO}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Nama Penerima</p>
                    <p class="font-semibold text-gray-900 dark:text-white">${data.nama}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Status</p>
                    <p class="font-semibold text-gray-900 dark:text-white">${data.status}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Ekspedisi</p>
                    <p class="font-semibold text-gray-900 dark:text-white">${data.ekspedisi}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Tanggal Kirim</p>
                    <p class="font-semibold text-gray-900 dark:text-white">${data.tanggalKirim}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Paket</p>
                    <p class="font-semibold text-gray-900 dark:text-white">${data.paket}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Total</p>
                    <p class="font-semibold text-gray-900 dark:text-white">${data.total}</p>
                </div>
            `;

            timeline.innerHTML = '';
            data.perjalanan.forEach((step, index) => {
                const item = `
                <div class="mb-6 ms-4">
                    <div class="absolute w-3 h-3 bg-blue-600 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900"></div>
                    <time class="block mb-1 text-xs text-gray-400">${step.waktu}</time>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">${step.keterangan}</p>
                </div>
                `;
                timeline.insertAdjacentHTML('beforeend', item);
            });
            });
        });
    </script>
@endpush
