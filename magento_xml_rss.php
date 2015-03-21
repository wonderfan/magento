<?php
error_reporting(E_ALL | E_STRICT);
define('MAGENTO_ROOT', getcwd());
$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
require_once $mageFilename;
ini_set('display_errors', 1);
umask(0);
Mage::app();
$is_default = false;
if($is_default){
    header('Content-type:text/xml; charset=UTF-8');
    $rssObj = Mage::getModel('rss/rss');
    $data = array(
                'title'       => 'Datavideo Marketplace Promotions',
                'description' => 'These are the active promotions on Datavideo',
                'link'        => 'http://datavideovirtualset.com/',
                'charset'     => 'UTF-8'
            );
    $rssObj->_addHeader($data);
    $collection = Mage::getModel('catalogrule/rule')->getResourceCollection();
    if ($collection->getSize()) {    
        foreach ($collection as $rule) {
            if($rule->getIsActive()){
                  if(is_null($rule->getDescription())){
                      $description = $rule->getName();
                  }else{
                      $description = $rule->getDescription();
                  }
                  $item = array(
                     'title'       => $rule->getName(),
                     'description' => $description,
                     'content'     => '   Start Date:'.$rule->getFromDate().'  End Date:'.$rule->getToDate(),
                     'link'        =>  'http://datavideovirtualset.com/'
                 );
                $rssObj->_addEntry($item);
            }

        }
    }
    echo $rssObj->createRssXml();    
}else{
    header('Content-type:text/xml; charset=UTF-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<rss xmlns:promotion="http://datavideovirtualset.com/" version="2.0">';
    echo '<channel>';
    echo '<title>Datavideo Marketplace Promotions</title>';
    echo '<description>These are the active promotions on Datavideo</description>';
    echo '<link>http://datavideovirtualset.com/</link>';
    $collection = Mage::getModel('catalogrule/rule')->getResourceCollection();
    if ($collection->getSize()) {    
        foreach ($collection as $rule) {
            if($rule->getIsActive()){
                  if(is_null($rule->getDescription())){
                      $description = $rule->getName();
                  }else{
                      $description = $rule->getDescription();
                  }
                  echo '<item>';
                  echo '<promotion:start>'.$rule->getFromDate().'</promotion:start>';
                  echo '<promotion:end>'.$rule->getToDate().'</promotion:end>';                    
                  echo '<promotion:title>'.$rule->getName().'</promotion:title>';
                  echo '<promotion:description>'.$description.'</promotion:description>';                  
                  echo '</item>';
            }
        }
    }    
    echo '</channel>';
    echo '</rss>';    
}

