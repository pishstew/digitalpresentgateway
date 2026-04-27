@extends('layouts.app')

@section('content')
<div class="page-bg">

    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">✏️ Edit Data Siswa</h1>
        <p class="hero-sub">Ubah informasi siswa sesuai kebutuhan</p>
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
                <form action="{{ route('admin.siswa.update', $siswa->nis) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">🆔 NIS (Nomor Induk Siswa)</label>
                        <input type="text" class="form-input" value="{{ $siswa->nis }}" disabled>
                        <p class="field-hint">⚠️ NIS tidak dapat diubah</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">👤 Nama Siswa</label>
                        <input type="text" name="nama_siswa"
                            class="form-input @error('nama_siswa') error @enderror"
                            placeholder="Contoh: Ahmad Reza Pratama"
                            value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                            required>
                        @error('nama_siswa')
                            <p class="form-error">❌ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">📚 Kelas</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="kelas" value="XI SIJA 1"
                                    {{ old('kelas', $siswa->kelas) == 'XI SIJA 1' ? 'checked' : '' }} required>
                                XI SIJA 1
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="kelas" value="XI SIJA 2"
                                    {{ old('kelas', $siswa->kelas) == 'XI SIJA 2' ? 'checked' : '' }} required>
                                XI SIJA 2
                            </label>
                        </div>
                        @error('kelas')
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
                                {{ ($user && $user->is_active) ? '✅ Aktif — Siswa dapat login' : '🚫 Nonaktif — Siswa tidak dapat login' }}
                            </span>
                        </div>
                        @if(!$user)
                            <p class="field-hint">⚠️ Akun login belum ditemukan untuk siswa ini</p>
                        @endif
                    </div>

                    <div class="form-page-btns">
                        <button type="submit" class="btn btn-teal btn-full">✅ Perbarui</button>
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-slate btn-full">❌ Batal</a>
                    </div>
                </form>
            </div>

            <div class="form-page-info">
                <h3>ℹ️ Informasi</h3>
                <ul>
                    <li>Hanya nama siswa dan kelas yang dapat diubah</li>
                    <li>NIS bersifat permanen dan tidak dapat dimodifikasi</li>
                    <li>Nonaktifkan akun untuk mencegah siswa login ke sistem</li>
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
            ? '✅ Aktif — Siswa dapat login'
            : '🚫 Nonaktif — Siswa tidak dapat login';
    });
</script>
@endsection