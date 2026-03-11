
<div class="container mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">Import Agreements CSV</h1>

  <?php if(session('status')): ?>
    <div class="mb-6 p-5 bg-green-50 border-l-4 border-green-400 rounded">
      <p class="font-semibold text-green-800"><?php echo e(session('status')); ?></p>
      <div class="mt-3 space-y-1 text-green-700">
        <p><span class="font-medium">Agreements created:</span> <?php echo e(session('agreements_created', 0)); ?></p>
        <p><span class="font-medium">Installments created:</span> <?php echo e(session('installments_created', 0)); ?></p>
        <p><span class="font-medium">Contracts created:</span> <?php echo e(session('contracts_created', 0)); ?></p>
        <p><span class="font-medium">Row errors:</span> <?php echo e(session('row_failures_count', 0)); ?></p>
      </div>
      <?php if(session('rowErrors')): ?>
        <details class="mt-4">
          <summary class="cursor-pointer text-blue-600 font-medium">View row-level errors</summary>
          <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-gray-700">
            <?php $__currentLoopData = session('rowErrors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li>Row <?php echo e($err['row']); ?>: <?php echo e($err['error']); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </details>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="mb-6 p-5 bg-red-50 border-l-4 border-red-400 rounded">
      <ul class="list-disc list-inside space-y-1 text-red-700">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e(route('agreements.import')); ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
    <?php echo csrf_field(); ?>
    <div>
      <label for="file" class="block mb-1 font-medium text-gray-700">CSV File</label>
      <input
        type="file"
        name="file"
        id="file"
        accept=".csv"
        required
        class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
      >
    </div>
    <button
      type="submit"
      class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded"
    >
      Upload & Import
    </button>
  </form>
</div>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agreements/import.blade.php ENDPATH**/ ?>