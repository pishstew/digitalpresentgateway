/**
 * theme-mode.js — DPG Digital Presence Guard
 * Mengelola toggle Dark/Light mode dengan localStorage persistence
 */

(function () {
    'use strict';

    const STORAGE_KEY = 'dpg-theme';
    const LIGHT_CLASS = 'light-mode';

    /* ── Terapkan tema secepat mungkin (sebelum render) ── */
    function applyTheme(isLight) {
        if (isLight) {
            document.body.classList.add(LIGHT_CLASS);
        } else {
            document.body.classList.remove(LIGHT_CLASS);
        }
    }

    /* ── Baca preferensi tersimpan ── */
    function getSavedTheme() {
        try {
            return localStorage.getItem(STORAGE_KEY) === 'light';
        } catch (e) {
            return false;
        }
    }

    /* ── Simpan preferensi ── */
    function saveTheme(isLight) {
        try {
            localStorage.setItem(STORAGE_KEY, isLight ? 'light' : 'dark');
        } catch (e) { /* silent fail */ }
    }

    /* ── Update semua switch di halaman ── */
    function syncAllSwitches(isLight) {
        document.querySelectorAll('.dpg-theme-checkbox').forEach(function (cb) {
            cb.checked = isLight;
        });

        // Update label teks jika ada
        document.querySelectorAll('.theme-label').forEach(function (label) {
            label.textContent = isLight ? 'Light' : 'Dark';
        });
    }

    /* ── Toggle handler ── */
    function handleToggle(e) {
        var isLight = e.target.checked;
        applyTheme(isLight);
        saveTheme(isLight);
        syncAllSwitches(isLight);
    }

    /* ── Init: jalankan setelah DOM siap ── */
    function init() {
        var isLight = getSavedTheme();

        // Terapkan tema
        applyTheme(isLight);

        // Bind semua checkbox switch
        document.querySelectorAll('.dpg-theme-checkbox').forEach(function (cb) {
            cb.checked = isLight;
            cb.addEventListener('change', handleToggle);
        });

        // Sync label
        syncAllSwitches(isLight);

        // Backward compatibility: tombol lama (btn-theme-toggle)
        var oldBtn = document.getElementById('themeToggleBtn');
        if (oldBtn) {
            oldBtn.style.display = 'none'; // Sembunyikan tombol lama
        }
    }

    // Jalankan segera jika DOM sudah siap, atau tunggu DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Ekspos fungsi ke global jika diperlukan
    window.dpgTheme = {
        toggle: function () {
            var isLight = !document.body.classList.contains(LIGHT_CLASS);
            applyTheme(isLight);
            saveTheme(isLight);
            syncAllSwitches(isLight);
        },
        setLight: function () {
            applyTheme(true);
            saveTheme(true);
            syncAllSwitches(true);
        },
        setDark: function () {
            applyTheme(false);
            saveTheme(false);
            syncAllSwitches(false);
        }
    };

})();