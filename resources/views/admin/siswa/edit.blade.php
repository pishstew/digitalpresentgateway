@extends('layouts.app')

@section('content')
<div class="form-page-container">
    <div class="form-wrapper">
        <!-- Header -->
        <div class="form-header">
            <h1>✏️ Edit Data Siswa</h1>
            <p>Ubah informasi siswa sesuai kebutuhan</p>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-alert">
                    <h3>❌ Terjadi Kesalahan</h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswa.update', $siswa->nis) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- NIS Field (Disabled) -->
                <div class="form-group">
                    <label for="nis">🆔 NIS (Nomor Induk Siswa)</label>
                    <input type="text" id="nis" name="nis" 
                        class="form-input" 
                        value="{{ $siswa->nis }}" 
                        disabled>
                    <p class="field-warning">⚠️ NIS tidak dapat diubah</p>
                </div>

                <!-- Nama Siswa Field -->
                <div class="form-group">
                    <label for="nama_siswa">👤 Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" 
                        class="form-input @error('nama_siswa') error @enderror" 
                        placeholder="Contoh: Ahmad Reza Pratama" 
                        value="{{ old('nama_siswa', $siswa->nama_siswa) }}" 
                        required>
                    @error('nama_siswa')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelas Field -->
                <div class="form-group">
                    <label for="kelas">📚 Kelas</label>
                    <input type="text" id="kelas" name="kelas" 
                        class="form-input @error('kelas') error @enderror" 
                        placeholder="Contoh: XI RPL 1" 
                        value="{{ old('kelas', $siswa->kelas) }}" 
                        required>
                    @error('kelas')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">
                        ✅ Perbarui
                    </button>
                    <a href="{{ route('siswa.index') }}" class="btn-cancel">
                        ❌ Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info -->
        <div class="info-box">
            <h3>ℹ️ Informasi</h3>
            <ul>
                <li>• Hanya nama siswa dan kelas yang dapat diubah</li>
                <li>• NIS bersifat permanen dan tidak dapat dimodifikasi</li>
                <li>• Pastikan data sudah benar sebelum menyimpan</li>
            </ul>
        </div>
    </div>
</div>
@endsection
