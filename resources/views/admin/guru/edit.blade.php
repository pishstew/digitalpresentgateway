@extends('layouts.app')

@section('content')
<div class="page-bg">

    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">✏️ Edit Data Guru</h1>
        <p class="hero-sub">Ubah informasi guru sesuai kebutuhan</p>
    </div>

    <div class="dash-body">

        <div class="form-page-wrapper">

            @if ($errors->any())
                <div class="alert-error">
                    <h3>❌ Terjadi Kesalahan</h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-page-card">
                <form action="{{ route('admin.guru.update', $guru->nip) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">🆔 NIP (Nomor Induk Pegawai)</label>
                        <input type="text" class="form-input" value="{{ $guru->nip }}" disabled>
                        <p class="field-hint">⚠️ NIP tidak dapat diubah</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">👤 Nama Guru</label>
                        <input type="text" name="nama_guru"
                            class="form-input @error('nama_guru') error @enderror"
                            placeholder="Contoh: Budi Santoso"
                            value="{{ old('nama_guru', $guru->nama_guru) }}" required>
                        @error('nama_guru')
                            <p class="form-error">❌ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">📚 Mata Pelajaran</label>
                        <select name="kode_mapel" class="form-input @error('kode_mapel') error @enderror" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapel as $m)
                                <option value="{{ $m->kode_mapel }}"
                                    {{ old('kode_mapel', $guru->kode_mapel) === $m->kode_mapel ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_mapel')
                            <p class="form-error">❌ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">🔘 Status Akun</label>
                        <div class="toggle-wrapper">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ ($user && $user->is_active) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">
                                {{ ($user && $user->is_active) ? '✅ Aktif — Guru dapat login' : '🚫 Nonaktif — Guru tidak dapat login' }}
                            </span>
                        </div>
                        @if(!$user)
                            <p class="field-hint">⚠️ Akun login belum ditemukan untuk guru ini</p>
                        @endif
                    </div>

                    <div class="form-page-btns">
                        <button type="submit" class="btn btn-teal btn-full">✅ Perbarui</button>
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-slate btn-full">❌ Batal</a>
                    </div>
                </form>
            </div>

            <div class="form-page-info">
                <h3>ℹ️ Informasi</h3>
                <ul>
                    <li>Hanya nama guru dan mata pelajaran yang dapat diubah</li>
                    <li>NIP bersifat permanen dan tidak dapat dimodifikasi</li>
                    <li>Nonaktifkan akun untuk mencegah guru login ke sistem</li>
                    <li>Pastikan data sudah benar sebelum menyimpan</li>
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
    const toggle = document.querySelector('input[name="is_active"]');
    const label  = document.getElementById('toggleLabel');
    toggle.addEventListener('change', function () {
        label.textContent = this.checked
            ? '✅ Aktif — Guru dapat login'
            : '🚫 Nonaktif — Guru tidak dapat login';
    });
</script>
@endsection