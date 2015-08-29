 $layout = Mage::app()->getLayout();
 $layout->getUpdate()->addHandle('sales_email_order_items');
 $layout->getUpdate()->load();
 $layout->generateXml();
 Mage::log($layout->getXmlString());
 $layout->generateBlocks();
 Mage::log($layout->getBlock('items')->getTemplateFile());
