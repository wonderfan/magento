<?php
$layout = Mage::getSingleton('core/layout');
$update = $layout->getUpdate();
$update->load('checkout_onepage_shippingmethod');
$layout->generateXml();
$layout->generateBlocks();
$output = $layout->getOutput();
return $output;
