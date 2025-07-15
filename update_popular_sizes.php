<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// تحديث بعض الأحجام لتكون موصى بها (الأكثر شعبية)
$popularSizes = ['42', '43', '41']; // الأحجام الأكثر شعبية

foreach ($popularSizes as $size) {
    $sizesToUpdate = \App\Models\ProductSize::where('size', $size)->get();
    foreach ($sizesToUpdate as $productSize) {
        $productSize->update(['is_popular' => true]);
    }
}

echo "تم تحديث الأحجام الشعبية: " . implode(', ', $popularSizes) . "\n";
echo "عدد الأحجام المحدثة: " . \App\Models\ProductSize::whereIn('size', $popularSizes)->count() . "\n";
