<?php

error_reporting(E_ALL | E_STRICT);
define('MAGENTO_ROOT', getcwd());
$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
require_once $mageFilename;
ini_set('display_errors', 1);
umask(0);
Mage::app();
$resource = Mage::getSingleton('core/resource');
$readConnection = $resource->getConnection('core_read');
$readConnection->delete('core_resource',"code='cs_setup'");

echo "it is sucessfully";
