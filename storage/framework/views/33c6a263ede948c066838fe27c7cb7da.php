<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">Convertir dólares a pesos</h1>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>⚠️ <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('cotizar.procesar')); ?>" class="space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label for="valor" class="block font-semibold">Valor en USD:</label>
            <input type="text" name="valor" id="valor"
                class="border rounded w-full p-2" value="<?php echo e(old('valor')); ?>">
        </div>

        <div>
            <label for="tipo" class="block font-semibold">Tipo de dólar:</label>
            <select name="tipo" id="tipo" class="border rounded w-full p-2">
                <option value="oficial">Oficial</option>
                <option value="blue">Blue</option>
                <option value="mep">MEP</option>
                <option value="tarjeta">Tarjeta</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Convertir
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dolar-api\resources\views/cotizar/cotizar.blade.php ENDPATH**/ ?>