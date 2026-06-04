{{--
    =====================================================
    PARTIAL: layouts/theme-switch.blade.php
    
    Cara pakai: @include('layouts.theme-switch')
    
    Taruh di dalam navbar/topbar masing-masing halaman.
    =====================================================
--}}

<label class="theme-switch" title="Ganti tema">
    <input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode">
    <span class="track"></span>
    <span class="thumb"></span>
</label>
<span class="theme-label">Dark</span>