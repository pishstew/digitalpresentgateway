<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary-blue: #003366;
        --secondary-blue: #0055cc;
        --light-blue: #e6f0ff;
        --dark-blue: #001f44;
        --gold-accent: #ffcc00;
    }

    /* Background Gradient */
    .dashboard-bg {
        background: linear-gradient(135deg, #f0f4f8 0%, #e6f0ff 100%);
        min-height: 100vh;
        padding: 30px;
    }

    /* Header Styling */
    .dashboard-header {
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        padding: 40px;
        border-radius: 12px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 8px 16px rgba(0, 51, 102, 0.3);
    }

    .dashboard-header h1 {
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0;
    }

    .dashboard-header p {
        color: #cce5ff;
        margin: 10px 0 0 0;
        font-size: 1.1rem;
    }

    /* Grid Layout */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    /* Card Styling */
    .dashboard-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-left: 5px solid #0055cc;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 51, 102, 0.2);
        text-decoration: none;
    }

    .dashboard-card.siswa {
        border-left-color: #0055cc;
    }

    .dashboard-card.guru {
        border-left-color: #28a745;
    }

    .dashboard-card.mapel {
        border-left-color: #ff9800;
    }

    .dashboard-card.jadwal {
        border-left-color: #9c27b0;
    }

    .dashboard-card.presensi {
        border-left-color: #e91e63;
    }

    .card-icon {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--primary-blue);
        margin-bottom: 15px;
    }

    .card-count {
        font-size: 2.5rem;
        font-weight: bold;
        color: #0055cc;
        margin-bottom: 15px;
    }

    .card-count.guru {
        color: #28a745;
    }

    .card-count.mapel {
        color: #ff9800;
    }

    .card-count.jadwal {
        color: #9c27b0;
    }

    .card-count.presensi {
        color: #e91e63;
    }

    .card-link {
        display: inline-block;
        padding: 10px 20px;
        background: #0055cc;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s ease;
        margin-top: auto;
    }

    .dashboard-card.guru .card-link {
        background: #28a745;
    }

    .dashboard-card.mapel .card-link {
        background: #ff9800;
    }

    .dashboard-card.jadwal .card-link {
        background: #9c27b0;
    }

    .dashboard-card.presensi .card-link {
        background: #e91e63;
    }

    .card-link:hover {
        opacity: 0.9;
        text-decoration: none;
    }

    .stats-text {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header h1 {
            font-size: 1.8rem;
        }

        .card-icon {
            font-size: 3rem;
        }
    }
</style>

<div class="dashboard-bg">
    <div class="dashboard-header">
        <h1>Dashboard Admin</h1>
        <p>Kelola sistem presensi sekolah</p>
    </div>

    <div class="dashboard-grid">
        <!-- Siswa Card -->
        <a href="<?php echo e(route('siswa.index')); ?>" class="dashboard-card siswa" style="text-decoration: none;">
            <div class="card-icon">👥</div>
            <div class="card-title">Siswa</div>
            <div class="card-count"><?php echo e($siswaCount); ?></div>
            <div class="stats-text">Total data siswa</div>
            <div class="card-link">Kelola Siswa</div>
        </a>

        <!-- Guru Card -->
        <a href="<?php echo e(route('guru.index')); ?>" class="dashboard-card guru" style="text-decoration: none;">
            <div class="card-icon">👨‍🏫</div>
            <div class="card-title">Guru</div>
            <div class="card-count guru"><?php echo e($guruCount); ?></div>
            <div class="stats-text">Total data guru</div>
            <div class="card-link">Kelola Guru</div>
        </a>

        <!-- Mapel Card -->
        <a href="<?php echo e(route('mapel.index')); ?>" class="dashboard-card mapel" style="text-decoration: none;">
            <div class="card-icon">📚</div>
            <div class="card-title">Mata Pelajaran</div>
            <div class="card-count mapel"><?php echo e($mapelCount); ?></div>
            <div class="stats-text">Total mata pelajaran</div>
            <div class="card-link">Kelola Mapel</div>
        </a>

        <!-- Jadwal Pelajaran Card -->
        <a href="<?php echo e(route('jadwal.index')); ?>" class="dashboard-card jadwal" style="text-decoration: none;">
            <div class="card-icon">📅</div>
            <div class="card-title">Jadwal Pelajaran</div>
            <div class="card-count jadwal"><?php echo e($jadwalCount); ?></div>
            <div class="stats-text">Total jadwal pelajaran</div>
            <div class="card-link">Kelola Jadwal</div>
        </a>

        <!-- Presensi Card -->
        <a href="<?php echo e(route('presensi.index')); ?>" class="dashboard-card presensi" style="text-decoration: none;">
            <div class="card-icon">✅</div>
            <div class="card-title">Presensi</div>
            <div class="card-count presensi"><?php echo e($presensiCount); ?></div>
            <div class="stats-text">Total data presensi</div>
            <div class="card-link">Kelola Presensi</div>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\presensi\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>