<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">Resultado de la conversión</h1>

    <div class="mb-4">
        <p><strong>Valor ingresado:</strong> <?php echo e($valor_dolar); ?> USD</p>
        <p><strong>Tipo de dólar:</strong> <?php echo e(ucfirst($tipo)); ?></p>
        <p><strong>Cotización:</strong> $<?php echo e(number_format($cotizacion, 2)); ?></p>
        <p class="mt-2 text-xl font-bold">
            Resultado en pesos: $<?php echo e(number_format($resultado_en_pesos, 2)); ?>

        </p>
    </div>

    <a href="<?php echo e(route('cotizar.form')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded">
        Volver
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dolar-api\resources\views\cotizar\resultado.blade.php ENDPATH**/ ?>