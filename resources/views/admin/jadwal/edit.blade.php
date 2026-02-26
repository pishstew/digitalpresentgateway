@extends('layouts.app')

@section('content')
<div class="form-page-container">
    <div class="form-wrapper">
        <!-- Header -->
        <div class="form-header">
            <h1>✏️ Edit Jadwal Pelajaran</h1>
            <p>Ubah informasi jadwal pelajaran sesuai kebutuhan</p>
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

            <form action="{{ route('jadwal.update', $jadwal->kode_jam_pelajaran) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Kode Jadwal Field (Disabled) -->
                <div class="form-group">
                    <label for="kode_jam_pelajaran">🔑 Kode Jadwal</label>
                    <input type="text" id="kode_jam_pelajaran" name="kode_jam_pelajaran" 
                        class="form-input" 
                        value="{{ $jadwal->kode_jam_pelajaran }}" 
                        disabled>
                    <p class="field-warning">⚠️ Kode jadwal tidak dapat diubah</p>
                </div>

                <!-- Hari Field -->
                <div class="form-group">
                    <label for="hari">📅 Hari</label>
                    <select id="hari" name="hari" 
                        class="form-input @error('hari') error @enderror" 
                        required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin" {{ old('hari', $jadwal->hari) === 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari', $jadwal->hari) === 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari', $jadwal->hari) === 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari', $jadwal->hari) === 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari', $jadwal->hari) === 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    </select>
                    @error('hari')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Ke Field -->
                <div class="form-group">
                    <label for="jam_ke">⏰ Jam Ke</label>
                    <input type="text" id="jam_ke" name="jam_ke" 
                        class="form-input @error('jam_ke') error @enderror" 
                        placeholder="Contoh: 1, 2, 3..." 
                        value="{{ old('jam_ke', $jadwal->jam_ke) }}" 
                        required>
                    @error('jam_ke')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Mata Pelajaran Field -->
                <div class="form-group">
                    <label for="kode_mapel">📚 Mata Pelajaran</label>
                    <select id="kode_mapel" name="kode_mapel" 
                        class="form-input @error('kode_mapel') error @enderror" 
                        required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapel as $m)
                            <option value="{{ $m->kode_mapel }}" 
                                {{ old('kode_mapel', $jadwal->kode_mapel) === $m->kode_mapel ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_mapel')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Guru Field -->
                <div class="form-group">
                    <label for="nip">🧑‍🏫 Guru</label>
                    <select id="nip" name="nip" 
                        class="form-input @error('nip') error @enderror" 
                        required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->nip }}" 
                                {{ old('nip', $jadwal->nip) === $g->nip ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                    @error('nip')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelas Field -->
                <div class="form-group">
                    <label for="kelas">👥 Kelas</label>
                    <input type="text" id="kelas" name="kelas" 
                        class="form-input @error('kelas') error @enderror" 
                        placeholder="Contoh: XI RPL 1" 
                        value="{{ old('kelas', $jadwal->kelas) }}" 
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
                    <a href="{{ route('jadwal.index') }}" class="btn-cancel">
                        ❌ Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info -->
        <div class="info-box">
            <h3>ℹ️ Informasi</h3>
            <ul>
                <li>• Semua field dapat diubah kecuali kode jadwal</li>
                <li>• Kode jadwal bersifat permanen dan tidak dapat dimodifikasi</li>
                <li>• Pastikan data sudah benar sebelum menyimpan</li>
            </ul>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-blue: #003366;
        --secondary-blue: #0055cc;
        --light-blue: #e6f0ff;
        --dark-blue: #001f44;
        --gold-accent: #ffcc00;
    }

    .form-page-container {
        background: linear-gradient(135deg, #f0f4f8 0%, #e6f0ff 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    .form-wrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        padding: 30px;
        border-radius: 12px;
        color: white;
        box-shadow: 0 8px 16px rgba(0, 51, 102, 0.3);
    }

    .form-header h1 {
        margin: 0 0 8px 0;
        font-size: 2rem;
        color: white;
    }

    .form-header p {
        margin: 0;
        color: #e6f0ff;
        font-size: 1rem;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 8px 24px rgba(0, 51, 102, 0.15);
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #cce6ff;
        border-radius: 8px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-input:focus {
        border-color: var(--secondary-blue);
        outline: none;
        box-shadow: 0 0 8px rgba(0, 85, 204, 0.2);
    }

    .form-input:disabled {
        background-color: #f0f4f8;
        color: #999;
        cursor: not-allowed;
    }

    .form-input.error {
        border-color: #ff4444;
    }

    .field-warning {
        color: #ff9500;
        font-size: 0.85rem;
        margin-top: 6px;
        margin-bottom: 0;
    }

    .form-error-message {
        color: #cc0000;
        font-size: 0.85rem;
        margin-top: 6px;
        margin-bottom: 0;
    }

    .error-alert {
        background: #fff2f2;
        border-left: 4px solid #ff4444;
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .error-alert h3 {
        color: #cc0000;
        margin: 0 0 12px 0;
        font-size: 1rem;
    }

    .error-alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .error-alert li {
        color: #cc0000;
        margin-bottom: 6px;
    }

    .form-buttons {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        justify-content: center;
    }

    .btn-submit {
        flex: 1;
        padding: 12px 28px;
        background: linear-gradient(135deg, #00cc66 0%, #00aa55 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 204, 102, 0.3);
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #00aa55 0%, #008844 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 204, 102, 0.4);
    }

    .btn-cancel {
        flex: 1;
        padding: 12px 28px;
        background: linear-gradient(135deg, #999999 0%, #777777 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(100, 100, 100, 0.3);
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #777777 0%, #555555 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(100, 100, 100, 0.4);
    }

    .info-box {
        background: linear-gradient(135deg, #e6f0ff 0%, #cce6ff 100%);
        border-left: 4px solid var(--primary-blue);
        padding: 20px;
        border-radius: 8px;
        color: var(--primary-blue);
    }

    .info-box h3 {
        margin-top: 0;
        margin-bottom: 12px;
        font-size: 1rem;
    }

    .info-box ul {
        margin: 0;
        padding-left: 20px;
    }

    .info-box li {
        margin-bottom: 6px;
        line-height: 1.5;
    }

    @media (max-width: 600px) {
        .form-page-container {
            padding: 20px 16px;
        }

        .form-card {
            padding: 20px;
        }

        .form-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection
