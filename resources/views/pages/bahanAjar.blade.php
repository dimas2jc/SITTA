@extends('layouts.main')

@section('content')
    <div class="p-4 sm:ml-64 mt-16">
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Daftar Bahan Ajar</h5>
                <input type="text" id="searchInput" placeholder="Cari..."
                    class="border border-gray-300 text-sm rounded-md px-3 py-1 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>

            <div class="overflow-x-auto">
                <table id="bahanAjarTable"
                    class="w-full text-sm text-left text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                    <thead class="bg-blue-500 dark:bg-gray-700 text-white dark:text-gray-200 uppercase text-xs">
                        <tr>
                            <th scope="col" class="px-6 py-3">Kode</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Jenis</th>
                            <th scope="col" class="px-6 py-3">Edisi</th>
                            <th scope="col" class="px-6 py-3">Stok</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bahanAjarBody" class="divide-y divide-gray-200 dark:divide-gray-700"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail modal -->
    <div id="detail-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="flex items-center justify-between py-2 px-4 md:px-5 md:py-3 border-b rounded-t bg-blue-50 dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Detail Bahan Ajar
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4" id="content-detail">

                </div>
            </div>
        </div>
    </div> 

    <!-- Update modal -->
    <div id="update-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="flex items-center justify-between py-2 px-4 md:px-5 md:py-3 border-b rounded-t bg-blue-50 dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Bahan Ajar
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="update-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5" id="formUpdate">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode</label>
                            <input type="text" name="kode" id="updateKodeBarang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Kode barang" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="name" id="updateNamaBarang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama barang" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="jenis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis</label>
                            <input type="text" name="jenis" id="updateJenisBarang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="BPM" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="edisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edisi</label>
                            <input type="number" name="edisi" id="updateEdisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="stok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                            <input type="number" name="stok" id="updateStok" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1" required="">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" class="text-gray-700 inline-flex items-center bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" data-modal-hide="update-modal" id="btnCloseUpdate">
                            Batal
                        </button>
                        <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

@endsection

@push('js')
    <script type="module">
        document.addEventListener('DOMContentLoaded', () => {
            const tableBody = document.getElementById('bahanAjarBody');
            const searchInput = document.getElementById('searchInput');
            const formUpdate = document.getElementById('formUpdate');
            const dataBahanAjar = Store.getAllBahanAjar();

            function renderTable(data) {
                tableBody.innerHTML = '';
                data.forEach(item => {
                    const row = `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-3">${item.kodeBarang}</td>
                            <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100">${item.namaBarang}</td>
                            <td class="px-6 py-3">${item.jenisBarang}</td>
                            <td class="px-6 py-3">${item.edisi}</td>
                            <td class="px-6 py-3">${item.stok}</td>
                            <td class="px-6 py-3 text-center">
                                <button data-id="${item.kodeBarang}" class="detail-btn text-blue-600 hover:underline mr-3" data-modal-target="detail-modal" data-modal-toggle="detail-modal">Detail</button>
                                <button data-id="${item.kodeBarang}" class="update-btn text-blue-600 hover:underline mr-3" data-modal-target="update-modal" data-modal-toggle="update-modal">Edit</button>
                                <button data-id="${item.kodeBarang}" class="delete-btn text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

                addListeners();
            }

            function addListeners() {
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const kode = e.target.dataset.id;
                        if (confirm('Yakin ingin menghapus data ini?')) {
                            Store.deleteBahanAjar(kode);
                            const updated = Store.getAllBahanAjar();
                            renderTable(updated);
                            addListeners(); // rebind lagi setelah render baru
                        }
                    });
                });

                document.querySelectorAll('.update-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const kode = e.target.dataset.id;
                        const item = Store.getAllBahanAjar().find(i => i.kodeBarang === kode);
                        showUpdate(item);
                    });
                });

                document.querySelectorAll('.detail-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const kode = e.target.dataset.id;
                        const item = Store.getAllBahanAjar().find(i => i.kodeBarang === kode);
                        showDetail(item);
                    });
                });
            }

            renderTable(dataBahanAjar);

            searchInput.addEventListener('keyup', (e) => {
                const keyword = e.target.value.toLowerCase();
                const filtered = dataBahanAjar.filter(item =>
                    item.namaBarang.toLowerCase().includes(keyword) ||
                    item.jenisBarang.toLowerCase().includes(keyword) ||
                    item.kodeBarang.toLowerCase().includes(keyword)
                );
                renderTable(filtered);
            });

            // Fungsi tampil modal detail
            function showDetail(item) {
                const detailContent = document.getElementById('content-detail');
                detailContent.innerHTML = `
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"">
                        <img class="rounded-t-lg" src="{{ asset('assets/${item.cover}') }}" />
                        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Kode Lokasi</p>
                                <p class="font-semibold text-gray-800 dark:text-white">${item.kodeLokasi ?? '-'}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Kode Barang</p>
                                <p class="font-semibold text-gray-800 dark:text-white">${item.kodeBarang}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Nama Barang</p>
                                <p class="font-semibold text-gray-800 dark:text-white">${item.namaBarang}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Jenis Barang</p>
                                <p class="font-semibold text-gray-800 dark:text-white">${item.jenisBarang}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Edisi</p>
                                <p class="font-semibold text-gray-800 dark:text-white">${item.edisi}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Stok</p>
                                <p class="font-semibold text-gray-800 dark:text-white">${item.stok}</p>
                            </div>
                        </div>
                    </div>
                `;

                // const modalEl = document.getElementById('detail-modal');
                // const modal = new Modal(modalEl);
                // modal.show();
            }

            // Fungsi tampil modal update
            function showUpdate(item) {
                document.getElementById('updateKodeBarang').value = item.kodeBarang;
                document.getElementById('updateNamaBarang').value = item.namaBarang;
                document.getElementById('updateJenisBarang').value = item.jenisBarang;
                document.getElementById('updateEdisi').value = item.edisi;
                document.getElementById('updateStok').value = item.stok;

                // const modalEl = document.getElementById('update-modal');
                // const modal = new Modal(modalEl);
                // modal.show();
            }

            // Event submit form update
            formUpdate.addEventListener('submit', (e) => {
                e.preventDefault();

                const kode = document.getElementById('updateKodeBarang').value;
                const nama = document.getElementById('updateNamaBarang').value;
                const jenis = document.getElementById('updateJenisBarang').value;
                const edisi = document.getElementById('updateEdisi').value;
                const stok = document.getElementById('updateStok').value;

                Store.updateBahanAjar(kode, {
                    kodeBarang: kode,
                    namaBarang: nama,
                    jenisBarang: jenis,
                    edisi: edisi,
                    stok: stok
                });
                
                document.getElementById('btnCloseUpdate').click();
                
                alert('Data berhasil diperbarui!');

                // Refresh tabel
                const updated = Store.getAllBahanAjar();
                renderTable(updated);
            });
        });
    </script>
@endpush
