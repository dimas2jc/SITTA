<template>
    <div class="flex justify-end mb-4">
        <button
            @click="showModal = true"
            class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md px-4 py-2">
            + Tambah DO
        </button>
    </div>

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">

        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">
            Tracking Pengiriman Bahan Ajar
        </h2>

        <!-- Form -->
        <form @submit.prevent="cariDO" class="flex flex-col sm:flex-row items-center gap-3 mb-6">
            <input
                v-model="nomorDO"
                type="text"
                placeholder="Masukkan Nomor Delivery Order"
                class="flex-1 w-full border border-gray-300 text-sm rounded-md px-4 py-2
                       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                required
            />

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md px-5 py-2.5
                       focus:ring-4 focus:ring-blue-300">
                Cari
            </button>
        </form>

        <!-- Hasil Tracking -->
        <div v-if="dataDO" class="border-t border-gray-200 dark:border-gray-700 pt-4">

            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">
                Detail Pengiriman
            </h3>

            <div class="bg-gray-50 dark:bg-gray-700 shadow-md rounded-lg border border-gray-200 dark:border-gray-600 p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-sm text-gray-700 dark:text-gray-200">

                    <div v-for="(value, label) in detailList" :key="label">
                        <p class="text-gray-500 dark:text-gray-400">{{ label }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ value }}</p>
                    </div>

                </div>
            </div>

            <!-- Timeline -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Riwayat Perjalanan</h3>

                <div class="relative border-s border-gray-200 dark:border-gray-600 pl-4">

                    <div
                        v-for="(step, index) in dataDO.perjalanan"
                        :key="index"
                        class="mb-6 ms-4">

                        <div class="absolute w-3 h-3 bg-blue-600 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900"></div>

                        <time class="block mb-1 text-xs text-gray-400">
                            {{ step.waktu }}
                        </time>

                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ step.keterangan }}
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <!-- Jika tidak ditemukan -->
        <div v-if="notFound" class="text-center mt-6 text-red-600 font-medium">
            Nomor Delivery Order tidak ditemukan.
        </div>

    </div>

    <!-- Modal Insert DO -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">

            <!-- Tombol Close -->
            <button
                @click="showModal = false"
                class="absolute top-3 right-3 text-gray-600 hover:text-red-600"
            >
                ✕
            </button>

            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
                Tambah Delivery Order Baru
            </h2>

            <form @submit.prevent="submitDO" class="space-y-4">

                <!-- NIM -->
                <div>
                    <label class="text-sm font-medium">NIM</label>
                    <input
                        v-model="form.nim"
                        class="w-full border rounded px-3 py-2"
                        required
                    />
                </div>

                <!-- Nama -->
                <div>
                    <label class="text-sm font-medium">Nama</label>
                    <input
                        v-model="form.nama"
                        class="w-full border rounded px-3 py-2"
                        required
                    />
                </div>

                <!-- Ekspedisi -->
                <div>
                    <label class="text-sm font-medium">Ekspedisi</label>
                    <select
                        v-model="form.ekspedisi"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                        <option value="">-- Pilih --</option>
                        <option v-for="item in pengirimanList" :value="item.nama" :key="item.kode">
                            {{ item.nama }}
                        </option>
                    </select>
                </div>

                <!-- Paket -->
                <div>
                    <label class="text-sm font-medium">Paket Bahan Ajar</label>
                    <select
                        v-model="form.paket"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                        <option value="">-- Pilih Paket --</option>
                        <option v-for="p in paketList" :value="p.kode" :key="p.kode">
                            {{ p.kode }} — {{ p.nama }}
                        </option>
                    </select>

                    <div v-if="selectedPaket" class="bg-gray-50 p-3 rounded border mt-2 text-sm">
                        <p class="font-semibold">Isi Paket:</p>
                        <ul class="list-disc pl-4">
                            <li v-for="isi in selectedPaket.isi" :key="isi">{{ isi }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Tanggal Kirim -->
                <div>
                    <label class="text-sm font-medium">Tanggal Kirim</label>
                    <input
                        type="date"
                        v-model="form.tanggalKirim"
                        class="w-full border rounded px-3 py-2"
                        required
                    />
                </div>

                <!-- Total Harga -->
                <div>
                    <label class="text-sm font-medium">Total Harga</label>
                    <input
                        v-model="totalHarga"
                        readonly
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                    />
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded"
                >
                    Simpan Data
                </button>
            </form>

        </div>
    </div>

</template>

<script>
    export default {
        name: "TrackingPage",

        props: {
            Store: { type: Object, required: true }
        },

        data() {
            return {
                nomorDO: "",
                dataDO: null,
                notFound: false,

                showModal: false,

                form: {
                    nim: "",
                    nama: "",
                    ekspedisi: "",
                    paket: "",
                    tanggalKirim: "",
                },

                paketList: [],
                pengirimanList: [],

                localTracking: {},
            };
        },

        computed: {
            detailList() {
                if (!this.dataDO) return {};

                return {
                    "Nomor DO": this.dataDO.nomorDO,
                    "Nama Penerima": this.dataDO.nama,
                    "Status": this.dataDO.status,
                    "Ekspedisi": this.dataDO.ekspedisi,
                    "Tanggal Kirim": this.dataDO.tanggalKirim,
                    "Paket": this.dataDO.paket,
                    "Total": `Rp ${this.dataDO.total.toLocaleString("id-ID")}`,
                };
            },

            selectedPaket() {
                return this.paketList.find(p => p.kode === this.form.paket);
            },

            totalHarga() {
                return this.selectedPaket
                    ? `Rp ${this.selectedPaket.harga.toLocaleString("id-ID")}`
                    : "";
            }
        },

        methods: {
            cariDO() {
                const storeList = this.Store.getAllTracking();
                const key = this.nomorDO.trim();

                const data =
                    storeList[key] ||
                    this.localTracking[key] ||
                    null;

                if (!data) {
                    this.dataDO = null;
                    this.notFound = true;
                    return;
                }

                this.notFound = false;
                this.dataDO = data;
            },

            submitDO() {
                const nomorBaru = this.Store.generateNextDO();

                const newData = {
                    nomorDO: nomorBaru,
                    nim: this.form.nim,
                    nama: this.form.nama,
                    ekspedisi: this.form.ekspedisi,
                    paket: this.form.paket,
                    tanggalKirim: this.form.tanggalKirim,
                    total: this.selectedPaket.harga,
                    status: "Dalam Proses",
                    perjalanan: [
                        {
                            waktu: new Date().toLocaleString("id-ID"),
                            keterangan: "Paket diterima jasa ekspedisi dan diproses"
                        }
                    ]
                };

                this.Store.insertTracking(nomorBaru, newData);

                this.showModal = false;

                this.form = {
                    nim: "",
                    nama: "",
                    ekspedisi: "",
                    paket: "",
                    tanggalKirim: "",
                };

                alert("Delivery Order berhasil ditambahkan!");
            }
        },

        mounted() {
            this.paketList = this.Store.getPaketList();
            this.pengirimanList = this.Store.getPengirimanList();

            // tracking lokal default kosong
            this.localTracking = {};
        }
    };
</script>


