<?php if($paginator->hasPages()): ?>
    <nav class="flex flex-col items-center justify-center space-y-3 sm:space-y-4" dir="ltr">
        <!-- Results Info -->
        <div class="text-center">
            <p class="text-xs sm:text-sm text-gray-600">
                عرض <?php echo e($paginator->firstItem()); ?> إلى <?php echo e($paginator->lastItem()); ?> من <?php echo e($paginator->total()); ?> النتائج
            </p>
        </div>
        
        <div class="flex items-center space-x-1 sm:space-x-1.5 overflow-x-auto px-2 sm:px-0 max-w-full">
            
            <?php if($paginator->onFirstPage()): ?>
                <span class="flex items-center px-2 py-1.5 sm:px-3 sm:py-2 text-xs sm:text-sm font-medium text-gray-300 bg-white border border-gray-300 cursor-not-allowed rounded-lg flex-shrink-0" aria-disabled="true">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" 
                   class="flex items-center px-2 py-1.5 sm:px-3 sm:py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-orange-600 transition-colors duration-200 flex-shrink-0">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <span class="flex items-center px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-gray-700 cursor-default flex-shrink-0"><?php echo e($element); ?></span>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span class="flex items-center px-2.5 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 border border-orange-500 rounded-lg shadow-md cursor-default flex-shrink-0">
                                <?php echo e($page); ?>

                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" 
                               class="flex items-center px-2.5 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-orange-600 hover:border-orange-300 transition-colors duration-200 flex-shrink-0">
                                <?php echo e($page); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" 
                   class="flex items-center px-2 py-1.5 sm:px-3 sm:py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-orange-600 transition-colors duration-200 flex-shrink-0">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            <?php else: ?>
                <span class="flex items-center px-2 py-1.5 sm:px-3 sm:py-2 text-xs sm:text-sm font-medium text-gray-300 bg-white border border-gray-300 cursor-not-allowed rounded-lg flex-shrink-0" aria-disabled="true">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/custom/pagination.blade.php ENDPATH**/ ?>