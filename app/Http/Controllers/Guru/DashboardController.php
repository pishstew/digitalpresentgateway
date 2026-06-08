<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $guru  = $user->guru;

        $jadwals = $guru
            ? JadwalPelajaran::with('mapel')
                ->where('nip', $guru->nip)
                ->orderBy('hari')
                ->orderBy('jam_ke')
                ->get()
            : collect();

        $tokenAktif   = session('presensi_token');
        $tokenExpiry  = session('presensi_token_expiry');
        $jadwalAktif  = session('presensi_jadwal_id');
        $tokenExpired = $tokenExpiry ? Carbon::now()->isAfter(Carbon::parse($tokenExpiry)) : true;

        if ($tokenExpired && $tokenAktif) {
            session()->forget(['presensi_token', 'presensi_token_expiry', 'presensi_jadwal_id']);
            $tokenAktif  = null;
            $tokenExpiry = null;
            $jadwalAktif = null;
        }

        return view('guru.dashboard', compact(
            'guru', 'jadwals', 'tokenAktif', 'tokenExpiry', 'jadwalAktif', 'tokenExpired'
        ));
    }

    public function generateToken(Request $request)
    {
        $request->validate([
            // PRIMARY KEY tabel adalah kode_jam_pelajaran (string), bukan id integer
            'jadwal_id' => 'required|exists:jadwal_pelajaran,kode_jam_pelajaran',
            'guru_lat'  => 'required|numeric',
            'guru_lng'  => 'required|numeric',
        ], [
            'guru_lat.required' => 'Lokasi GPS guru tidak terdeteksi. Pastikan izin lokasi diaktifkan.',
            'guru_lng.required' => 'Lokasi GPS guru tidak terdeteksi. Pastikan izin lokasi diaktifkan.',
        ]);

        $token  = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $expiry = Carbon::now()->addMinutes(5);

        session([
            'presensi_token'        => $token,
            'presensi_token_expiry' => $expiry->toDateTimeString(),
            'presensi_jadwal_id'    => $request->jadwal_id,
            'guru_lat'              => (float) $request->guru_lat,
            'guru_lng'              => (float) $request->guru_lng,
        ]);

        return redirect()->route('guru.dashboard')
            ->with('success', 'Kode presensi berhasil di-generate!');
    }

    public function selesaikan()
    {
        $jadwalId = session('presensi_jadwal_id');
        session()->forget(['presensi_token', 'presensi_token_expiry', 'presensi_jadwal_id', 'guru_lat', 'guru_lng']);

        return redirect()->route('guru.presensi.index', ['jadwal_id' => $jadwalId])
            ->with('success', 'Sesi presensi telah diselesaikan.');
    }
}