<?php $__env->startSection('content'); ?>
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
            <?php if($errors->any()): ?>
                <div class="error-alert">
                    <h3>❌ Terjadi Kesalahan</h3>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('siswa.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- NIS Field -->
                <div class="form-group">
                    <label for="nis">🆔 NIS (Nomor Induk Siswa)</label>
                    <input type="text" id="nis" name="nis" 
                        class="form-input <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        placeholder="Contoh: 12345678901" 
                        value="<?php echo e(old('nis')); ?>" 
                        required>
                    <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="form-error-message">❌ <?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Nama Siswa Field -->
                <div class="form-group">
                    <label for="nama_siswa">👤 Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" 
                        class="form-input <?php $__errorArgs = ['nama_siswa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        placeholder="Contoh: Ahmad Reza Pratama" 
                        value="<?php echo e(old('nama_siswa')); ?>" 
                        required>
                    <?php $__errorArgs = ['nama_siswa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="form-error-message">❌ <?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Kelas Field -->
                <div class="form-group">
                    <label>📚 Kelas</label>
                    <div class="radio-group" <?php $__errorArgs = ['kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> style="border: 1px solid #dc3545; padding: 10px; border-radius: 4px;" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                        <label class="radio-label">
                            <input type="radio" name="kelas" value="XI SIJA 1" 
                                <?php if(old('kelas') == 'XI SIJA 1'): ?> checked <?php endif; ?>
                                required>
                            XI SIJA 1
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="kelas" value="XI SIJA 2" 
                                <?php if(old('kelas') == 'XI SIJA 2'): ?> checked <?php endif; ?>
                                required>
                            XI SIJA 2
                        </label>
                    </div>
                    <?php $__errorArgs = ['kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="form-error-message">❌ <?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Buttons -->
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">
                        ✅ Simpan
                    </button>
                    <a href="<?php echo e(route('siswa.index')); ?>" class="btn-cancel">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\presensi\resources\views/admin/siswa/create.blade.php ENDPATH**/ ?>