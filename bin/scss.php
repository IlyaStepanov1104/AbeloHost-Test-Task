<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

$compiler = new Compiler();
$compiler->setImportPaths(dirname(__DIR__) . '/resources/scss');
$compiler->setOutputStyle(OutputStyle::COMPRESSED);

$src  = dirname(__DIR__) . '/resources/scss/app.scss';
$dest = dirname(__DIR__) . '/public/css/app.css';

$result = $compiler->compileFile($src);
file_put_contents($dest, $result->getCss());

echo "Successfully compiled: resources/scss/app.scss -> public/css/app.css\n";
