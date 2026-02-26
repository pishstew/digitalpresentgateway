@extends('layouts.app')

@section('content')
<div class="form-page-container">
    <div class="form-wrapper">
        <!-- Header -->
        <div class="form-header">
            <h1>➕ Tambah Siswa Baru</h1>
            <p>Isikan data siswa baru dengan lengkap</p>
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

            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf

                <!-- NIS Field -->
                <div class="form-group">
                    <label for="nis">🆔 NIS (Nomor Induk Siswa)</label>
                    <input type="text" id="nis" name="nis" 
                        class="form-input @error('nis') error @enderror" 
                        placeholder="Contoh: 12345678901" 
                        value="{{ old('nis') }}" 
                        required>
                    @error('nis')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Siswa Field -->
                <div class="form-group">
                    <label for="nama_siswa">👤 Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" 
                        class="form-input @error('nama_siswa') error @enderror" 
                        placeholder="Contoh: Ahmad Reza Pratama" 
                        value="{{ old('nama_siswa') }}" 
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
                        value="{{ old('kelas') }}" 
                        required>
                    @error('kelas')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">
                        ✅ Simpan
                    </button>
                    <a href="{{ route('siswa.index') }}" class="btn-cancel">
                        ❌ Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="info-box">
            <h3>💡 Tips</h3>
            <ul>
                <li>• NIS harus unik dan tidak boleh duplikat</li>
                <li>• Pastikan data nama dan kelas sudah benar sebelum menyimpan</li>
                <li>• Format kelas contoh: X TKJ 1, XI RPL 2, XII DPIB 3</li>
            </ul>
        </div>
    </div>
</div>
@endsection
