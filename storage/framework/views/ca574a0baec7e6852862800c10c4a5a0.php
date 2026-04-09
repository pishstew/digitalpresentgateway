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

    /* Tombol Tambah Siswa */
    .btn-add {
        background: linear-gradient(135deg, #00cc66 0%, #00aa55 100%);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(0, 204, 102, 0.3);
    }

    .btn-add:hover {
        background: linear-gradient(135deg, #00aa55 0%, #008844 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 204, 102, 0.4);
    }

    /* Tombol Kembali ke Dashboard */
    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(108, 117, 125, 0.4);
        text-decoration: none;
        color: white;
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

    /* Badge Kelas */
    .badge-kelas {
        display: inline-block;
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 51, 102, 0.2);
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
        border: none;
        box-shadow: 0 3px 8px rgba(255, 68, 68, 0.3);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #cc0000 0%, #990000 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(255, 68, 68, 0.4);
    }

    /* Filter Buttons */
    .btn-filter {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: var(--primary-blue);
        padding: 8px 16px;
        border: 2px solid var(--primary-blue);
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(0, 51, 102, 0.1);
    }

    .btn-filter:hover {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.3);
    }

    .btn-filter.active {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.3);
    }
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

    /* Pagination Styling */
    .pagination-container {
        background: linear-gradient(90deg, #f5f9ff 0%, #e6f0ff 100%);
        border-top: 1px solid #cce6ff;
    }

    .pagination-container .pagination {
        justify-content: center;
        margin: 0;
    }

    .pagination-container .page-link {
        color: var(--primary-blue);
        background-color: white;
        border: 1px solid #cce6ff;
        padding: 8px 12px;
        margin: 0 2px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination-container .page-link:hover {
        background-color: var(--light-blue);
        color: var(--dark-blue);
        border-color: var(--secondary-blue);
    }

    .pagination-container .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        border-color: var(--primary-blue);
    }

    .pagination-container .page-item.disabled .page-link {
        color: #ccc;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
</style>

<div class="page-bg py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section with Gradient -->
        <div class="header-section mb-8 flex justify-between items-center">
            <div>
                <h1>👥 Manajemen Siswa</h1>
                <p>Kelola data siswa sekolah dengan mudah dan efisien</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn-back">
                    ⬅️ Kembali ke Dashboard
                </a>
                <a href="<?php echo e(route('siswa.create')); ?>" class="btn-add">
                    ➕ Tambah Siswa
                </a>
            </div>
        </div>

        <!-- Success Alert -->
        <?php if($message = Session::get('success')): ?>
            <div class="alert-success">
                <p>✅ <?php echo e($message); ?></p>
            </div>
        <?php endif; ?>

        <!-- Card Container -->
        <div class="card-container">
            <!-- Card Header -->
            <div class="card-header">
                <h2>📋 Daftar Siswa</h2>
                <div style="margin-top: 16px; display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="<?php echo e(route('siswa.index')); ?>" class="btn-filter <?php echo e(!request('kelas') ? 'active' : ''); ?>">
                        📚 Semua Kelas
                    </a>
                    <a href="<?php echo e(route('siswa.index', ['kelas' => 'XI SIJA 1'])); ?>" class="btn-filter <?php echo e(request('kelas') == 'XI SIJA 1' ? 'active' : ''); ?>">
                        🎓 XI SIJA 1
                    </a>
                    <a href="<?php echo e(route('siswa.index', ['kelas' => 'XI SIJA 2'])); ?>" class="btn-filter <?php echo e(request('kelas') == 'XI SIJA 2' ? 'active' : ''); ?>">
                        🎓 XI SIJA 2
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">NIS</th>
                            <th style="width: 30%;">Nama Siswa</th>
                            <th style="width: 20%;">Kelas</th>
                            <th style="width: 25%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td style="font-family: monospace; font-weight: 500;"><?php echo e($item->nis); ?></td>
                                <td style="font-weight: 500;"><?php echo e($item->nama_siswa); ?></td>
                                <td>
                                    <span class="badge-kelas"><?php echo e($item->kelas); ?></span>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo e(route('siswa.edit', $item->nis)); ?>" class="btn-action btn-edit">
                                        ✏️ Edit
                                    </a>
                                    <button type="button" onclick="deleteConfirm('<?php echo e(route('siswa.destroy', $item->nis)); ?>', '<?php echo e($item->nama_siswa); ?>')" class="btn-action btn-delete">
                                        🗑️ Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <p>📭 Belum ada data siswa</p>
                                        <p>Klik tombol "Tambah Siswa" untuk menambahkan data baru</p>
                                    </div>
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container" style="padding: 20px; text-align: center;">
                <?php echo e($siswa->appends(request()->query())->links()); ?>

            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                <span>📊 Total Siswa:</span>
                <span style="color: var(--secondary-blue); font-size: 1.2rem; margin-left: 8px;"><?php echo e($siswa->total()); ?></span>
                <span style="margin-left: 4px;">orang</span>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay hidden">
    <div class="modal-content">
        <div class="modal-header">⚠️ Konfirmasi Penghapusan</div>
        <div class="modal-text">
            Apakah Anda yakin ingin menghapus data siswa <strong id="studentName"></strong>? Tindakan ini tidak dapat dibatalkan.
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
function deleteConfirm(deleteUrl, studentName) {
    document.getElementById('deleteForm').action = deleteUrl;
    document.getElementById('studentName').textContent = studentName;
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\presensi\resources\views/admin/siswa/index.blade.php ENDPATH**/ ?>