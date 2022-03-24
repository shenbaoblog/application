<?php

require 'core/ClassLoader.php';

$loader = new ClassLoader();
// オートロードの対象ディレクトリの設定
$loader->registerDir(dirname(__FILE__) . '/core');
$loader->registerDir(dirname(__FILE__) . '/models');
// オートロードに登録
$loader->register();
