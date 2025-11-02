import './bootstrap';
import 'flowbite';
import '../css/app.css';
import * as Store from './store.js';

// Inisialisasi saat aplikasi mulai

window.Store = Store;

Store.initStore();

const currentPath = window.location.pathname;

if (!Store.isAuthenticated() && currentPath !== '/login') {
    window.location.href = '/login';
}

if (Store.isAuthenticated() && currentPath === '/login') {
    window.location.href = '/dashboard';
}