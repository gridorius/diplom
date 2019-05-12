<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../../vendor/autoload.php';

$genered = new \App\Custom\CssGenerer();

$genered->addColorsAndBackgrounds([
    'white' => [
      '#FFFFFF'
    ],
]);

$genered->addFonts([
    16, 18, 24, 36
]);

$genered->addWidths([
    311,
]);

$genered->addHeights([
    311,
]);

$genered->addPaddings([
   [83, 0, 0, 0]
]);


// output
header('Content-Type: text/css');
echo $genered->build();