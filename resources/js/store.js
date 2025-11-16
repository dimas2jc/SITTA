import { dataPengguna, dataBahanAjar, dataTracking, upbjjList, kategoriList, pengirimanList, paketList, stokDetail } from "./data.js";

const STORAGE_KEYS = {
    pengguna: "dataPengguna",
    bahanAjar: "dataBahanAjar",
    tracking: "dataTracking",
    upbjjList: "dataUpbjjList",
    kategoriList: "dataKategoriList",
    pengirimanList: "dataPengirimanList",
    paketList: "dataPaketList",
    stokDetail: "dataStokDetail",
    session: "userSession",
};

// Inisialisasi data dari data.js ke localStorage
export function initStore() {
    if (!localStorage.getItem(STORAGE_KEYS.pengguna)) {
        localStorage.setItem(STORAGE_KEYS.pengguna, JSON.stringify(dataPengguna));
    }
    if (!localStorage.getItem(STORAGE_KEYS.bahanAjar)) {
        localStorage.setItem(STORAGE_KEYS.bahanAjar, JSON.stringify(dataBahanAjar));
    }
    if (!localStorage.getItem(STORAGE_KEYS.tracking)) {
        localStorage.setItem(STORAGE_KEYS.tracking, JSON.stringify(dataTracking));
    }
    if (!localStorage.getItem(STORAGE_KEYS.upbjjList)) {
        localStorage.setItem(STORAGE_KEYS.upbjjList, JSON.stringify(upbjjList));
    }
    if (!localStorage.getItem(STORAGE_KEYS.kategoriList)) {
        localStorage.setItem(STORAGE_KEYS.kategoriList, JSON.stringify(kategoriList));
    }
    if (!localStorage.getItem(STORAGE_KEYS.pengirimanList)) {
        localStorage.setItem(STORAGE_KEYS.pengirimanList, JSON.stringify(pengirimanList));
    }
    if (!localStorage.getItem(STORAGE_KEYS.paketList)) {
        localStorage.setItem(STORAGE_KEYS.paketList, JSON.stringify(paketList));
    }
    if (!localStorage.getItem(STORAGE_KEYS.stokDetail)) {
        localStorage.setItem(STORAGE_KEYS.stokDetail, JSON.stringify(stokDetail));
    }

    console.log("Data berhasil diinisialisasi ke localStorage");
}

// ======================
// HELPER
// ======================
function getAll(key) {
    const raw = localStorage.getItem(key);
    return raw ? JSON.parse(raw) : [];
}

function saveAll(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}

// =====================
// AUTENTIKASI
// =====================

// Login: cek email dan password di localStorage
export function login(email, password) {
  const users = getAllPengguna();
  const user = users.find(u => u.email === email && u.password === password);
  if (user) {
    localStorage.setItem(STORAGE_KEYS.session, JSON.stringify(user));
    console.log(`Login berhasil sebagai ${user.nama}`);
    return user;
  } else {
    console.warn("Login gagal. Email atau password salah.");
    return null;
  }
}

// Logout: hapus session
export function logout() {
  localStorage.removeItem(STORAGE_KEYS.session);
  console.log("Logout berhasil");
}

// Cek apakah user sedang login
export function getCurrentUser() {
  return JSON.parse(localStorage.getItem(STORAGE_KEYS.session)) || null;
}

// Cek status login
export function isAuthenticated() {
  return !!localStorage.getItem(STORAGE_KEYS.session);
}

// =======================
// DATA PENGGUNA
// =======================
export function getAllPengguna() {
    return getAll(STORAGE_KEYS.pengguna);
}

export function insertPengguna(newItem) {
    const data = getAllPengguna();
    const newId = data.length ? Math.max(...data.map((d) => d.id)) + 1 : 1;
    const newData = { id: newId, ...newItem };
    data.push(newData);
    saveAll(STORAGE_KEYS.pengguna, data);
    return newData;
}

export function updatePengguna(id, fields) {
    const data = getAllPengguna();
    const index = data.findIndex((d) => d.id === id);
    if (index === -1) return null;
    data[index] = { ...data[index], ...fields };
    saveAll(STORAGE_KEYS.pengguna, data);
    return data[index];
}

export function deletePengguna(id) {
    const data = getAllPengguna().filter((d) => d.id !== id);
    saveAll(STORAGE_KEYS.pengguna, data);
    return true;
}

// =======================
// DATA BAHAN AJAR
// =======================
export function getAllBahanAjar() {
    return getAll(STORAGE_KEYS.bahanAjar);
}

export function insertBahanAjar(newItem) {
    const data = getAllBahanAjar();
    data.push(newItem);
    saveAll(STORAGE_KEYS.bahanAjar, data);
    return newItem;
}

export function updateBahanAjar(kodeBarang, fields) {
    const data = getAllBahanAjar();
    const index = data.findIndex((d) => d.kode === kodeBarang);
    if (index === -1) return null;
    data[index] = { ...data[index], ...fields };
    saveAll(STORAGE_KEYS.bahanAjar, data);
    return data[index];
}

export function deleteBahanAjar(kodeBarang) {
    const data = getAllBahanAjar().filter((d) => d.kode !== kodeBarang);
    saveAll(STORAGE_KEYS.bahanAjar, data);
    return true;
}

// =======================
// DATA TRACKING
// =======================
export function getAllTracking() {
    return JSON.parse(localStorage.getItem(STORAGE_KEYS.tracking)) || {};
}

export function insertTracking(noDO, newItem) {
    const data = getAllTracking(); 
    data[noDO] = newItem;
    saveAll(STORAGE_KEYS.tracking, data);
    return newItem;
}

export function updateTracking(noDO, fields) {
    const data = getAllTracking();
    if (!data[noDO]) return null;
    data[noDO] = { ...data[noDO], ...fields };
    saveAll(STORAGE_KEYS.tracking, data);
    return data[noDO];
}

export function deleteTracking(noDO) {
    const data = getAllTracking();
    delete data[noDO];
    saveAll(STORAGE_KEYS.tracking, data);
    return true;
}

/* ===================================================
   MASTER DATA
=================================================== */

// OLD: getPaketList() return this.paket → undefined
// NEW:
export function getPaketList() {
    return getAll(STORAGE_KEYS.paketList);
}

export function getPengirimanList() {
    return getAll(STORAGE_KEYS.pengirimanList);
}

export function getUpbjjList() {
    return getAll(STORAGE_KEYS.upbjjList);
}

export function getKategoriList() {
    return getAll(STORAGE_KEYS.kategoriList);
}

export function getStokDetail() {
    return getAll(STORAGE_KEYS.stokDetail);
}

// ===========================
// AUTO NUMBER DO
// ===========================
export function generateNextDO() {
    const trackingData = getAllTracking();
    const tahun = new Date().getFullYear();
    const prefix = `DO${tahun}-`;

    const listDO = Object.keys(trackingData).filter(k => k.startsWith(prefix));

    if (listDO.length === 0) {
        return `${prefix}001`;
    }

    const last = listDO[listDO.length - 1];
    const seq = parseInt(last.split("-")[1]) + 1;

    return `${prefix}${String(seq).padStart(3, "0")}`;
}


