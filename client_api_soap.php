<?php
//$client = new SoapClient('soap.xml');
//$session = $client->login('wonder', 'wonder123');
//$result = $client->call($session, 'order.list');
//var_dump ($result);
 

$proxy = new SoapClient("https://www.vedaromausa.gostorego.com/index.php/api/soap/?wsdl");
$sessionId = $proxy->login('wonder', 'wonder123');

function time_local_to_utc($date) {
    $dt = new DateTime($date, new DateTimeZone("America/Chicago"));
    $dt->
            setTimezone(new DateTimeZone("UTC"));
    return( $dt->format("Y-m-d H:i:s") );
}

$day = new DateTime();
$day->modify("-1 day");

$fromDate = $day->format("Y-m-d 00:00:00");
$toDate = $day->format("Y-m-d 23:59:59");
$utc_from = time_local_to_utc($fromDate);
$utc_to = time_local_to_utc($toDate);
$filter = array(array('created_at' => array('from' => $utc_from, 'to' => $utc_to)));

$orders = $proxy->call($sessionId, 'sales_order.list', $filter);
var_dump($orders);
exit(0);


$mageFilename = getcwd() . '/app/Mage.php';
if (!file_exists($mageFilename)) {
    echo 'Mage file not found';
    exit;
}
require $mageFilename;

Mage::app();
$url = 'http://api.asicentral.com/v1/products/';
$restClient = new Zend_Rest_Client($url);

Zend_Debug::dump($restClient);
