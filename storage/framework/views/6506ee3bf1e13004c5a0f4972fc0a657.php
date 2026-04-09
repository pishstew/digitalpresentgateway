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
    .page-bg {
        background: linear-gradient(135deg, #f0f4f8 0%, #e6f0ff 100%);
        min-height: 100vh;
    }

    /* Header Styling */
    .header-section {
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        padding: 30px;
        border-radius: 12px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 8px 16px rgba(0, 51, 102, 0.3);
    }

    .header-section h1 {
        color: white;
        margin-bottom: 8px;
        font-size: 2.5rem;
        margin-top: 0;
    }

    .header-section p {
        color: #e6f0ff;
        font-size: 1.1rem;
        margin: 0;
    }

    /* Form Section */
    .form-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 51, 102, 0.15);
        padding: 30px;
        margin-bottom: 30px;
    }

    .form-section h2 {
        color: var(--primary-blue);
        font-size: 1.5rem;
        margin-top: 0;
        margin-bottom: 20px;
        border-bottom: 3px solid var(--light-blue);
        padding-bottom: 12px;
    }

    .form-horizontal {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: flex-end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 180px;
    }

    .form-group label {
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select {
        padding: 12px 16px;
        border: 2px solid #cce6ff;
        border-radius: 8px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--secondary-blue);
        outline: none;
        box-shadow: 0 0 8px rgba(0, 85, 204, 0.2);
    }

    .btn-submit {
        padding: 12px 28px;
        background: linear-gradient(135deg, #00cc66 0%, #00aa55 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 204, 102, 0.3);
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #00aa55 0%, #008844 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 204, 102, 0.4);
    }

    /* Search Form */
    .search-section {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .search-section input {
        flex: 1;
        padding: 10px 16px;
        border: 2px solid #cce6ff;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-section input:focus {
        border-color: var(--secondary-blue);
        outline: none;
        box-shadow: 0 0 8px rgba(0, 85, 204, 0.2);
    }

    .search-section button {
        padding: 10px 20px;
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 51, 102, 0.3);
    }

    .search-section button:hover {
        background: linear-gradient(135deg, #0055cc 0%, #003366 100%);
        transform: translateY(-2px);
    }

    /* Card Container */
    .card-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 51, 102, 0.15);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #003366 0%, #0055cc 50%, #0077ff 100%);
        padding: 20px 30px;
        color: white;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }

    /* Table Styling */
    .table-container {
        overflow-x: auto;
    }

    .table-wrapper {
        width: 100%;
        border-collapse: collapse;
    }

    .table-wrapper thead {
        background: linear-gradient(90deg, #e6f0ff 0%, #cce6ff 100%);
    }

    .table-wrapper th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--primary-blue);
        border-bottom: 2px solid var(--primary-blue);
        font-size: 0.9rem;
    }

    .table-wrapper td {
        padding: 14px 20px;
        border-bottom: 1px solid #e0e7ff;
        color: #333;
    }

    .table-wrapper tbody tr {
        transition: all 0.3s ease;
    }

    .table-wrapper tbody tr:hover {
        background-color: #fffacd;
        box-shadow: inset 0 0 8px rgba(255, 204, 0, 0.2);
    }

    .table-wrapper tbody tr:nth-child(even) {
        background-color: #f5f9ff;
    }

    /* Badge Styles */
    .badge-hari {
        display: inline-block;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
    }

    .badge-mapel {
        display: inline-block;
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 51, 102, 0.2);
    }

    .badge-kelas {
        display: inline-block;
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);
    }

    /* Action Buttons */
    .btn-action {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin: 0 4px;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ff9500 0%, #ff8800 100%);
        color: white;
        box-shadow: 0 3px 8px rgba(255, 149, 0, 0.3);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #ff8800 0%, #ff7700 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(255, 149, 0, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
        color: white;
        box-shadow: 0 3px 8px rgba(255, 68, 68, 0.3);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #cc0000 0%, #990000 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(255, 68, 68, 0.4);
    }

    /* Card Footer */
    .card-footer {
        background: linear-gradient(90deg, #f5f9ff 0%, #e6f0ff 100%);
        padding: 16px 30px;
        border-top: 2px solid #cce6ff;
        color: var(--primary-blue);
        font-weight: 600;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.hidden {
        display: none;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        box-shadow: 0 12px 40px rgba(0, 51, 102, 0.3);
        padding: 30px;
        width: 90%;
        max-width: 420px;
    }

    .modal-header {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--primary-blue);
        margin-bottom: 16px;
    }

    .modal-text {
        color: #555;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .modal-buttons {
        display: flex;
        gap: 12px;
    }

    .btn-modal {
        flex: 1;
        padding: 12px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-cancel {
        background: linear-gradient(135deg, #999999 0%, #777777 100%);
        color: white;
    }

    .btn-modal-cancel:hover {
        background: linear-gradient(135deg, #777777 0%, #555555 100%);
        transform: translateY(-2px);
    }

    .btn-modal-confirm {
        background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
        color: white;
    }

    .btn-modal-confirm:hover {
        background: linear-gradient(135deg, #cc0000 0%, #990000 100%);
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state p:first-child {
        font-size: 1.3rem;
        font-weight: bold;
        color: #666;
        margin-bottom: 8px;
    }

    .empty-state p:last-child {
        color: #999;
        font-size: 0.95rem;
    }

    /* Success Alert */
    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-left: 4px solid #28a745;
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .alert-success p {
        color: #155724;
        margin: 0;
        font-weight: 500;
    }

    /* Tombol Kembali ke Dashboard */
    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 3px 8px rgba(108, 117, 125, 0.3);
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(108, 117, 125, 0.4);
        text-decoration: none;
        color: white;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .form-group {
            min-width: 150px;
        }
    }

    @media (max-width: 768px) {
        .form-horizontal {
            flex-direction: column;
        }

        .form-group {
            min-width: 100%;
        }

        .header-section {
            flex-direction: column;
            text-align: center;
        }

        .header-section h1 {
            font-size: 1.8rem;
        }

        .table-wrapper th,
        .table-wrapper td {
            padding: 10px 12px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="page-bg py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section with Gradient -->
        <div class="header-section mb-8" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>🕐 Manajemen Jadwal Pelajaran</h1>
                <p>Kelola jadwal pelajaran sekolah dengan mudah dan efisien</p>
            </div>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn-back">
                ⬅️ Kembali ke Dashboard
            </a>
        </div>

        <!-- Success Alert -->
        <?php if($message = Session::get('success')): ?>
            <div class="alert-success">
                <p>✅ <?php echo e($message); ?></p>
            </div>
        <?php endif; ?>

        <!-- Form Section -->
        <div class="form-section">
            <h2>➕ Tambah Jadwal Pelajaran</h2>
            <form action="<?php echo e(route('jadwal.store')); ?>" method="POST" class="form-horizontal">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="hari">📅 Hari</label>
                    <select id="hari" name="hari" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jam_ke">⏰ Jam Ke</label>
                    <input type="text" id="jam_ke" name="jam_ke" placeholder="1-2" required>
                </div>

                <div class="form-group">
                    <label for="kode_mapel">📚 Mata Pelajaran</label>
                    <select id="kode_mapel" name="kode_mapel" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->kode_mapel); ?>"><?php echo e($m->nama_mapel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nip">🧑‍🏫 Guru</label>
                    <select id="nip" name="nip" required>
                        <option value="">-- Pilih Guru --</option>
                        <?php $__currentLoopData = $guru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($g->nip); ?>"><?php echo e($g->nama_guru); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group" style="flex: none; display: flex; align-items: center; gap: 20px; padding: 12px 0;">
                    <label style="margin-bottom: 0;">👥 Kelas</label>
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <label style="margin: 0; display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal;">
                            <input type="radio" name="kelas" value="XI SIJA 1" required>
                            XI SIJA 1
                        </label>
                        <label style="margin: 0; display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal;">
                            <input type="radio" name="kelas" value="XI SIJA 2" required>
                            XI SIJA 2
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Tambah Jadwal</button>
            </form>
        </div>

        <!-- Search Section -->
        <div class="card-container mb-8">
            <div class="card-header">
                <h2>🔍 Cari Jadwal</h2>
            </div>
            <div style="padding: 20px 30px;">
                <form method="GET" class="search-section">
                    <input type="text" name="search" placeholder="Cari berdasarkan kelas..." value="<?php echo e(request('search')); ?>">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </div>

        <!-- Card Container -->
        <div class="card-container">
            <!-- Card Header -->
            <div class="card-header">
                <h2>📋 Daftar Jadwal Pelajaran</h2>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 12%;">Hari</th>
                            <th style="width: 8%;">Jam Ke</th>
                            <th style="width: 20%;">Mata Pelajaran</th>
                            <th style="width: 22%;">Guru</th>
                            <th style="width: 15%;">Kelas</th>
                            <th style="width: 18%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $jadwal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($jadwal->firstItem() + $index); ?></td>
                                <td>
                                    <span class="badge-hari"><?php echo e($item->hari); ?></span>
                                </td>
                                <td style="font-weight: 500;"><?php echo e($item->jam_ke); ?></td>
                                <td>
                                    <span class="badge-mapel"><?php echo e($item->mapel->nama_mapel ?? '-'); ?></span>
                                </td>
                                <td style="font-weight: 500;"><?php echo e($item->guru->nama_guru ?? '-'); ?></td>
                                <td>
                                    <span class="badge-kelas"><?php echo e($item->kelas); ?></span>
                                </td>
                                <td style="text-align: center;">                                    <a href="<?php echo e(route('jadwal.edit', $item->kode_jam_pelajaran)); ?>" class="btn-action btn-edit">
                                        ✏️ Edit
                                    </a>                                    <button type="button" onclick="deleteConfirm('<?php echo e(route('jadwal.destroy', $item->kode_jam_pelajaran)); ?>')" class="btn-action btn-delete">
                                        🗑️ Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <p>📭 Belum ada data jadwal pelajaran</p>
                                        <p>Gunakan form di atas untuk menambahkan data baru</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                <span>📊 Total Jadwal:</span>
                <span style="color: var(--secondary-blue); font-size: 1.2rem; margin-left: 8px;"><?php echo e($jadwal->total()); ?></span>
                <span style="margin-left: 4px;">item</span>
            </div>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            <?php echo e($jadwal->links()); ?>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay hidden">
    <div class="modal-content">
        <div class="modal-header">⚠️ Konfirmasi Penghapusan</div>
        <div class="modal-text">
            Apakah Anda yakin ingin menghapus jadwal pelajaran ini? Tindakan ini tidak dapat dibatalkan.
        </div>
        <div class="modal-buttons">
            <button type="button" onclick="cancelDelete()" class="btn-modal btn-modal-cancel">
                ❌ Batal
            </button>
            <form id="deleteForm" method="POST" style="flex: 1;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" style="width: 100%;" class="btn-modal btn-modal-confirm">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function deleteConfirm(deleteUrl) {
    document.getElementById('deleteForm').action = deleteUrl;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function cancelDelete() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        cancelDelete();
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\presensi\resources\views/admin/jadwal/index.blade.php ENDPATH**/ ?>