<template>
    <!-- Filter -->
    <transition name="slide">
        <div
            v-if="showFilter"
            class="bg-white rounded-lg shadow-sm p-6 m-4">

            <h3 class="text-lg font-semibold mb-4">Filter Data</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div>
                    <label class="text-sm font-semibold">UT Daerah</label>
                    <select v-model="filter.upbjj" class="w-full border rounded px-2 py-1">
                        <option value="">Semua</option>
                        <option v-for="u in upbjjList" :key="u">{{ u }}</option>
                    </select>
                </div>

                <div v-if="filter.upbjj">
                    <label class="text-sm font-semibold">Kategori</label>
                    <select v-model="filter.kategori" class="w-full border rounded px-2 py-1">
                        <option value="">Semua</option>
                        <option v-for="k in kategoriList" :key="k">{{ k }}</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold">Status Stok</label>
                    <select v-model="filter.status" class="w-full border rounded px-2 py-1">
                        <option value="">Semua</option>
                        <option value="menipis">Menipis</option>
                        <option value="kosong">Kosong</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold">Sort</label>
                    <select v-model="sortBy" class="w-full border rounded px-2 py-1">
                        <option value="">Default</option>
                        <option value="judul">Judul</option>
                        <option value="qty">Stok</option>
                        <option value="harga">Harga</option>
                    </select>
                </div>
            </div>

            <!-- Reset Button -->
            <div class="text-right mt-4">
                <button
                    @click="resetFilter"
                    class="bg-gray-100 text-black font-semibold text-sm px-3 py-2 rounded-lg hover:bg-gray-300 transition">
                    Reset Filter
                </button>
            </div>

        </div>
    </transition>

    <!-- Card -->
    <div class="m-4 p-6 bg-white rounded-lg shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Bahan Ajar</h2>

            <div class="flex items-center gap-2">
                <button
                    @click="toggleFilter"
                    class="flex items-center font-semibold text-sm bg-yellow-200 px-3 py-2 rounded-lg hover:bg-yellow-500 transition">
                    Filter
                </button>
                <button
                    @click="showAddModal = true"
                    class="bg-blue-600 text-white text-sm px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                    + Bahan Ajar
                </button>
            </div>
        </div>    

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm border rounded-lg overflow-hidden shadow-sm">
                <thead class="bg-blue-100 border-b">
                    <tr class="text-left">
                        <th class="p-3 border-r">Kode</th>
                        <th class="p-3 border-r">Judul</th>
                        <th class="p-3 border-r">Kategori</th>
                        <th class="p-3 border-r">UT Daerah</th>
                        <th class="p-3 border-r">Rak</th>
                        <th class="p-3 border-r">Qty</th>
                        <th class="p-3 border-r">Safety</th>
                        <th class="p-3 border-r">Status</th>
                        <th class="p-3 border-r">Catatan</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="item in filteredData"
                        :key="item.kode"
                        class="hover:bg-gray-50 transition border-b">

                        <td class="p-3 border-r">{{ item.kode }}</td>
                        <td class="p-3 border-r">{{ item.judul }}</td>
                        <td class="p-3 border-r">{{ item.kategori }}</td>
                        <td class="p-3 border-r">{{ item.upbjj }}</td>
                        <td class="p-3 border-r">{{ item.lokasiRak }}</td>
                        <td class="p-3 border-r">{{ item.qty }}</td>
                        <td class="p-3 border-r">{{ item.safety }}</td>
                        <td class="p-3 border-r font-semibold" :class="statusColor(item)">
                            {{ statusText(item) }}
                        </td>
                        <td class="p-3 border-r" v-html="item.catatanHTML"></td>
                        <td class="p-3 flex gap-2">
                            <button
                                @click="editItem(item)"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                Edit
                            </button>

                            <button
                                @click="deleteItem(item.kode)"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- MODAL EDIT -->
        <div
            v-if="showEditModal"
            tabindex="-1"
            aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

            <div class="relative w-full max-w-md bg-white rounded-lg shadow-lg border">

                <!-- Header -->
                <div class="flex items-center justify-between border-b p-4">
                    <h3 class="text-lg font-medium">Edit Stok Bahan Ajar</h3>

                    <button
                        @click="showEditModal = false"
                        class="w-9 h-9 flex items-center justify-center hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none">
                            <path stroke="currentColor" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-4 space-y-4">

                    <div>
                        <label class="text-sm font-medium">Qty</label>
                        <input
                            type="number"
                            v-model="editForm.qty"
                            class="w-full border rounded px-2 py-1">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Safety</label>
                        <input
                            type="number"
                            v-model="editForm.safety"
                            class="w-full border rounded px-2 py-1">
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end border-t p-4 space-x-3">

                    <button
                        @click="showEditModal = false"
                        class="px-3 py-2 text-sm rounded bg-gray-100 hover:bg-gray-200">
                        Batal
                    </button>

                    <button
                        @click="saveEdit"
                        class="px-3 py-2 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">
                        Simpan
                    </button>

                </div>

            </div>
        </div>

        <!-- MODAL ADD BAHAN AJAR -->
        <div
            v-if="showAddModal"
            tabindex="-1"
            aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

            <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-lg border">

                <!-- Header -->
                <div class="flex items-center justify-between border-b p-4">
                    <h3 class="text-lg font-medium">Tambah Bahan Ajar</h3>

                    <button
                        @click="showAddModal = false"
                        class="w-9 h-9 flex items-center justify-center hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none">
                            <path stroke="currentColor" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-4 space-y-4 max-h-[70vh] overflow-y-auto">

                    <div>
                        <label class="font-medium text-sm">Kode</label>
                        <input v-model="addForm.kode" class="w-full border rounded px-2 py-1" />
                    </div>

                    <div>
                        <label class="font-medium text-sm">Judul</label>
                        <input v-model="addForm.judul" class="w-full border rounded px-2 py-1" />
                    </div>

                    <div>
                        <label class="font-medium text-sm">Kategori</label>
                        <select v-model="addForm.kategori" class="w-full border rounded px-2 py-1">
                            <option v-for="k in kategoriList" :key="k">{{ k }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-medium text-sm">UT Daerah</label>
                        <select v-model="addForm.upbjj" class="w-full border rounded px-2 py-1">
                            <option v-for="u in upbjjList" :key="u">{{ u }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-medium text-sm">Lokasi Rak</label>
                        <input v-model="addForm.lokasiRak" class="w-full border rounded px-2 py-1" />
                    </div>

                    <div>
                        <label class="font-medium text-sm">Qty</label>
                        <input type="number" v-model="addForm.qty" class="w-full border rounded px-2 py-1" />
                    </div>

                    <div>
                        <label class="font-medium text-sm">Safety</label>
                        <input type="number" v-model="addForm.safety" class="w-full border rounded px-2 py-1" />
                    </div>

                    <div>
                        <label class="font-medium text-sm">Catatan</label>
                        <textarea v-model="addForm.catatanHTML" class="w-full border rounded px-2 py-1"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end border-t p-4 space-x-3">

                    <button
                        @click="showAddModal = false"
                        class="px-3 py-2 text-sm rounded bg-gray-100 hover:bg-gray-200">
                        Batal
                    </button>

                    <button
                        @click="saveAdd"
                        class="px-3 py-2 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">
                        Simpan
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StokPage",

        props: {
            Store: { type: Object, required: true }
        },

        data() {
            return {
                stok: [],
                upbjjList: [],
                kategoriList: [],

                filter: {
                    upbjj: "",
                    kategori: "",
                    status: "",
                },

                sortBy: "",

                showEditModal: false,
                showAddModal: false,

                editForm: {
                    kode: "",
                    qty: 0,
                    safety: 0,
                },

                addForm: {
                    kode: "",
                    judul: "",
                    kategori: "",
                    upbjj: "",
                    lokasiRak: "",
                    qty: 0,
                    safety: 0,
                    catatanHTML: "",
                },

                showFilter: false
            };
        },

        watch: {
            "filter.upbjj"(newVal) {
                if (!newVal) {
                    this.filter.kategori = "";
                }
            },

            "editForm.qty"(val) {
                if (val < 0) this.editForm.qty = 0;
            }
        },

        computed: {
            filteredData() {
                let data = [...this.stok];

                if (this.filter.upbjj) {
                    data = data.filter(d => d.upbjj === this.filter.upbjj);
                }

                if (this.filter.upbjj && this.filter.kategori) {
                    data = data.filter(d => d.kategori === this.filter.kategori);
                }

                if (this.filter.status === "menipis") {
                    data = data.filter(d => d.qty < d.safety && d.qty > 0);
                }

                if (this.filter.status === "kosong") {
                    data = data.filter(d => d.qty === 0);
                }

                if (this.sortBy === "judul") {
                    data.sort((a, b) => a.judul.localeCompare(b.judul));
                }
                if (this.sortBy === "qty") {
                    data.sort((a, b) => a.qty - b.qty);
                }
                if (this.sortBy === "harga") {
                    data.sort((a, b) => a.harga - b.harga);
                }

                return data;
            }
        },

        methods: {
            toggleFilter() {
                this.showFilter = !this.showFilter;
            },

            statusColor(item) {
                if (item.qty === 0) return "text-red-600";
                if (item.qty < item.safety) return "text-orange-500";
                return "text-green-600";
            },

            statusText(item) {
                if (item.qty === 0) return "Kosong";
                if (item.qty < item.safety) return "Menipis";
                return "Aman";
            },

            resetFilter() {
                this.filter = {
                    upbjj: "",
                    kategori: "",
                    status: "",
                };
                this.sortBy = "";
            },

            editItem(item) {
                this.showEditModal = true;
                this.editForm = { ...item };
            },

            saveEdit() {
                this.Store.updateBahanAjar(this.editForm.kode, {
                    qty: Number(this.editForm.qty),
                    safety: Number(this.editForm.safety),
                });

                const idx = this.stok.findIndex(s => s.kode === this.editForm.kode);
                if (idx !== -1) {
                    this.stok[idx].qty = Number(this.editForm.qty);
                    this.stok[idx].safety = Number(this.editForm.safety);
                }

                this.showEditModal = false;
                alert("Data berhasil diperbarui!");
            },

            deleteItem(kode) {
                if (!confirm("Yakin ingin menghapus data ini?")) return;

                this.Store.deleteBahanAjar(kode);
                this.stok = this.stok.filter(item => item.kode !== kode);
            },

            saveAdd() {
                if (!this.addForm.kode || !this.addForm.judul) {
                    alert("Kode dan Judul wajib diisi!");
                    return;
                }

                this.Store.insertBahanAjar(this.addForm);

                this.stok.push({ ...this.addForm });

                this.showAddModal = false;
                alert("Data berhasil ditambahkan!");

                this.addForm = {
                    kode: "",
                    judul: "",
                    kategori: "",
                    upbjj: "",
                    lokasiRak: "",
                    qty: 0,
                    safety: 0,
                    catatanHTML: "",
                };
            }
        },

        mounted() {
            this.stok = this.Store.getAllBahanAjar();
            this.upbjjList = this.Store.getUpbjjList() || [];
            this.kategoriList = this.Store.getKategoriList() || [];
        }
    };
</script>

<style>
    .slide-enter-active,
    .slide-leave-active {
        transition: all 0.3s ease;
    }
    .slide-enter-from,
    .slide-leave-to {
        opacity: 0;
        transform: translateY(-10px);
    }

    .animate-fadeIn {
        animation: fadeIn 0.25s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

