<?php
set_time_limit(0);
echo "start to unzip file \n";

$zip = new ZipArchive();
$file = dirname(__FILE__).DIRECTORY_SEPARATOR.'backup.magento.zip';
$zip->open($file);
$zip->extractTo(dirname(__FILE__));
$zip->close();

echo "successfully";
