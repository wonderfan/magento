$argv[0] = 'mage.php';
$argv[1] = 'install';
$argv[2] = 'http://connect20.magentocommerce.com/community';
$argv[3] = 'Mage_All_Latest';
$argv[4] = '--force';
__cli_Mage_Connect::instance()->init($argv)->run();
