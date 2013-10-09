<?php
set_time_limit(0);
ini_set('memory_limit', '1024M');

$api_url = 'http://127.0.0.1/magento/api/v2_soap/?wsdl';
$options = array(
    'trace' => true,
    'connection_timeout' => 12000,
    'wsdl_cache' => WSDL_CACHE_NONE,
);
$client = new SoapClient($api_url,$options);
$session = $client->login('api', 'api123');

$attributeSetId = 9;
$attributes = $client->catalogProductAttributeList($session, $attributeSetId);
$set = array();
foreach($attributes as $value){
$set[$value->code] = $value->code;
}

$new_attributes = array('fabric','jcode','length','size','sleeve','style');

foreach($new_attributes as $value){
//$result = $client->catalogProductAttributeRemove($session, $value);

if(!array_key_exists($value, $set)){
$data = array(
   "attribute_code" => $value,
   "frontend_input" => "text",
   "scope" => "global",
   "default_value" => "",
   "is_unique" => 0,
   "is_required" => 0,
   "apply_to" => array("simple","configurable"),
   "is_configurable" => 1,
   "is_searchable" => 1,
   "is_visible_in_advanced_search" => 1,
   "is_comparable" => 0,
   "is_used_for_promo_rules" => 0,
   "is_visible_on_front" => 1,
   "used_in_product_listing" => 1,
   "additional_fields" => array(),
   "frontend_label" => array(array("store_id" => "0", "label" => $value))
  );
  $attributeId = $client->catalogProductAttributeCreate($session, $data);
  $result = $client->catalogProductAttributeSetAttributeAdd($session,$attributeId,$attributeSetId,4);
  //echo $result.'<br>';
}

}


$client->endSession($session);
