<?php

/**
 * @file
 * Include this file only and only if you don't have a autoloading system
 * capable of loading the library. This will include all the necessary files
 */

$dirName = realpath(dirname(__FILE__));

require_once $dirName . '/oliverde8/fixedWidthFile/HeaderDefinition.php';
require_once $dirName . '/oliverde8/fixedWidthFile/Exceptions/Open.php';
require_once $dirName . '/oliverde8/fixedWidthFile/Writer.php';
require_once $dirName . '/oliverde8/fixedWidthFile/Exceptions/Width.php';
