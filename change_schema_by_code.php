<?php

set_time_limit(0);

if (version_compare(phpversion(), '5.2.0', '<') === true) {
    echo '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
<h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">
Whoops, it looks like you have an invalid PHP version.</h3></div><p>Magento supports PHP 5.2.0 or newer.
<a href="http://www.magentocommerce.com/install" target="">Find out</a> how to install</a>
 Magento using PHP-CGI as a work-around.</p></div>';
    exit;
}

/**
 * Error reporting
 */
error_reporting(E_ALL | E_STRICT);

/**
 * Compilation includes configuration file
 */
define('MAGENTO_ROOT', getcwd());

$compilerConfig = MAGENTO_ROOT . '/includes/config.php';
if (file_exists($compilerConfig)) {
    include $compilerConfig;
}

$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
$maintenanceFile = 'maintenance.flag';

if (!file_exists($mageFilename)) {
    if (is_dir('downloader')) {
        header("Location: downloader");
    } else {
        echo $mageFilename . " was not found";
    }
    exit;
}

if (file_exists($maintenanceFile)) {
    include_once dirname(__FILE__) . '/errors/503.php';
    exit;
}

require_once $mageFilename;

#Varien_Profiler::enable();

if (isset($_SERVER['MAGE_IS_DEVELOPER_MODE'])) {
    Mage::setIsDeveloperMode(true);
}

#ini_set('display_errors', 1);

umask(0);

Mage::app();
$installer = new Mage_Core_Model_Resource_Setup('core_setup');
$installer->startSetup();
$tableCataloginventoryStockItem = $installer->getTable('cataloginventory_stock_item');
$connection = $installer->getConnection();
$connection->addColumn($tableCataloginventoryStockItem, 'use_config_ideal_stock_level', "tinyint(1) unsigned NOT NULL default '1'");
$connection->addColumn($tableCataloginventoryStockItem, 'ideal_stock_level', "decimal(12,4) NOT NULL DEFAULT '0.0000'");
$installer->endSetup();

echo 'Alter the table schema successfully.';
