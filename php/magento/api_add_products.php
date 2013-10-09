<?php
set_time_limit(0);
ini_set('memory_limit', '1024M');

function getPos($fname) {
    global $colnames;
    return array_search($fname, $colnames);
}

$data_file = __DIR__.DIRECTORY_SEPARATOR.'feed.csv';
$row = 0;
$colnames = array();
$simple_products = array();
$configurable_products = array();
if (($handle = fopen($data_file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 39000, ",")) !== FALSE) {
        $row++;
        if($row == 1) {
			foreach ($data as $d) {			
			   array_push($colnames, $d);
			 }
			continue;
		}
		if ( $data[3] == 'simple' ) {
			$simple_products[] = $data;  
        } 
        if ( $data[3] == 'configurable' ) {
			$configurable_products[] = $data;  
        } 		
    }
    fclose($handle);    
}

$api_url = 'http://127.0.0.1/magento/api/v2_soap/?wsdl';
$options = array(
    'trace' => true,
    'connection_timeout' => 12000,
    'wsdl_cache' => WSDL_CACHE_NONE,
);
$client = new SoapClient($api_url,$options);
$session = $client->login('api', 'api123');

$attributeSetId = 9;

foreach($simple_products as $data){
$product = array(
		'categories' => array(10),
		'websites' => array(1),
		'name' => $data[getPos('name')],
		'description' => $data[getPos('description')],
		'short_description' => $data[getPos('short_description')],		
		'status' => '1',
		'url_key' => $data[getPos('url_key')],
		'url_path' => $data[getPos('url_path')],
		'visibility' => $data[getPos('visibility')],
		'price'=> $data[getPos('price')],
		'tax_class_id' => 1,
		'additional_attributes' => array(
		  'single_data' => array(
		  array('key'=>'fabric','value'=>$data[getPos('fabric')]),
		  array('key'=>'jcode','value'=>$data[getPos('jcode')]),
		  array('key'=>'length','value'=>$data[getPos('length')]),
		  array('key'=>'size','value'=>$data[getPos('size')]),
		  array('key'=>'sleeve','value'=>$data[getPos('sleeve')]),
		  array('key'=>'style','value'=>$data[getPos('style')])
		  )
		 )		
	);
    $productId = $client->catalogProductCreate($session, 'simple', $attributeSetId, $data[getPos('sku')], $product);

	$product_image = $data[getPos('image_external_url')];
	if(empty($product_image)){ 
	   continue;
	}
	$image_name = substr($product_image, strrpos($product_image, '/')+1);
    $image_name = substr($image_name,0,  strlen($image_name)-4);
    $file = array(
        'content' => base64_encode(file_get_contents($product_image)),
        'mime' => 'image/jpeg',
        'name' =>  $image_name
    );
	$image_result = $client->catalogProductAttributeMediaCreate($session,$productId,
		array('file' => $file, 'label' => 'Label', 'position' => '10', 'types' => array('image', 'small_image', 'thumbnail' ), 'exclude' => 0)
	);	
}

foreach($configurable_products as $data){
$product = array(
		'categories' => array(10),
		'websites' => array(1),
		'name' => $data[getPos('name')],
		'description' => $data[getPos('description')],
		'short_description' => $data[getPos('short_description')],		
		'status' => '1',
		'url_key' => $data[getPos('url_key')],
		'url_path' => $data[getPos('url_path')],
		'visibility' => $data[getPos('visibility')],
		'price'=> $data[getPos('price')],
		'tax_class_id' => 1,
		
		'additional_attributes' => array(
		'single_data' => array(
		  array('key'=>'fabric','value'=>$data[getPos('fabric')]),
		  array('key'=>'jcode','value'=>$data[getPos('jcode')]),
		  array('key'=>'length','value'=>$data[getPos('length')]),
		  array('key'=>'size','value'=>$data[getPos('size')]),
		  array('key'=>'sleeve','value'=>$data[getPos('sleeve')]),
		  array('key'=>'style','value'=>$data[getPos('style')])
		  )
		 )
		/*	 
		'associated_skus' => array($data[getPos('_super_products_sku')]),
		'price_changes'=>array(
		 array($data[getPos('_super_attribute_code')]=>array($data[getPos('_super_attribute_option')]=>0))
		)
		*/
	);
	
	if ($data[getPos('sku')] != 'SA306WA07DIQINDFAS'){
		continue;
	}
	var_export($product);
	$custom_sku = 'JD' .substr($data[getPos('sku')],0,  strlen($data[getPos('sku')])-9); 
    $productId = $client->catalogProductCreate($session, 'configurable', $attributeSetId, $custom_sku, $product);

	$product_image = $data[getPos('image_external_url')];
	if(empty($product_image)){ 
	   continue;
	}
	$image_name = substr($product_image, strrpos($product_image, '/')+1);
    $image_name = substr($image_name,0,  strlen($image_name)-4);
    $file = array(
        'content' => base64_encode(file_get_contents($product_image)),
        'mime' => 'image/jpeg',
        'name' =>  $image_name
    );
	$image_result = $client->catalogProductAttributeMediaCreate($session,$productId,
		array('file' => $file, 'label' => 'Label', 'position' => '10', 'types' => array('image', 'small_image', 'thumbnail' ), 'exclude' => 0)
	);

}

$client->endSession($session);
