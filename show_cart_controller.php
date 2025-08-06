<?php
// Show lines 60-85 of CartController.php
$file = file('app/Http/Controllers/CartController.php');
echo "Lines 60-85 of CartController.php:\n";
for ($i = 59; $i < min(85, count($file)); $i++) {
    echo ($i + 1) . ": " . $file[$i];
}
