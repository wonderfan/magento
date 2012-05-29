<?php
set_time_limit(0);

$mageFilename = 'app/Mage.php';

require_once $mageFilename;

Mage::app();

/**
 * @This is the first approach
 */


$installer = Mage::getSingleton('core/resource')->getConnection("default_setup");

$installer->startSetup();

$installer->multiQuery("
ALTER TABLE {$installer->getTableName('newsletter_subscriber')}
ADD source varchar(255) DEFAULT '';
");

$installer->endSetup();


/**
 * @This is the second approach
 */

$installer = new Mage_Core_Model_Resource_Setup('core_setup');

$installer->startSetup();

$installer->run("
ALTER TABLE {$installer->getTable('newsletter_subscriber')}
ADD source varchar(255) DEFAULT '';
");

$installer->endSetup();
