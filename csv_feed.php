<?php
set_time_limit(0);
ini_set('memory_limit', '1024M');
include_once "../app/Mage.php";
include_once "../downloader/Maged/Controller.php";

Mage::init();

$app = Mage::app('default');

//The category names should be exactly the same name from the csv file where the id is the corresponding category id in magento. This is done when the csv file doesn't contain ids for categories but the name of categories.
$categories = array(
    'Category 1' => 3,
    'Category 2' => 4,
    'Category 3' =>5,
    'Category 4'=>6,
);

$row = 0;

$colnames = array();

function getPos($fname) {
    global $colnames;
    return array_search($fname, $colnames);
}

function getXsltCategory($category) {
    $newcat = '';
    switch($category) {
        case 'WOMEN/SAREES':
             $newcat = 'Saree/Partywear Saree';
             break;
        case 'WOMEN/SALWAR KAMEEZ':
             $newcat = 'Salwar Kameez/Party Wear Suits';
             break;
        default:
             echo 'Undefined category found :' . $category;
             exit();
    }
    return $newcat;
}

function getSkuCode($psku, $type, $category) {
    switch($category) {
        case 'WOMEN/SAREES':
             $newcat = 'Saree/Partywear Saree';
             break;
        case 'WOMEN/SALWAR KAMEEZ':
             $newcat = 'Salwar Kameez/Party Wear Suits';
             break;
    } 
    if ( $type == 'simple' ) {
        $s = explode("-", $psku);
        $newsku = 'JD' . 
    } else {
    }
}

if (($handle = fopen("feed.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 39000, ",")) !== FALSE) {
        $row++;

        if($row == 1) {
	    foreach ($data as $d) {
	       array_push($colnames, $d);
            }
	    continue;
	}

	if ( $data[3] == 'configurable' )
	    continue;

	if ( $data[3] == 'simple' ) {
	    echo '<b>SKU:</b> '.$data[getPos('sku')].'<br/>';
	    echo '<b>Name:</b> '.$data[getPos('name')].'<br/>';
	    echo '<b>Type:</b> '.$data[getPos('_type')].'<br/>';
	    echo '<b>Category:</b> '.$data[getPos('_category')].'<br/>';
	    echo '<b>Description:</b> '.$data[getPos('description')].'<br/>';
	    echo '<b>Short Description:</b> '.$data[getPos('short_description')].'<br/>';
	    echo '<b>Color:</b> '.$data[getPos('color')].'<br/>';
	    echo '<b>Image:</b> '.$data[getPos('external_gallery')].'<br/>';
	    echo '<b>Price:</b> '.$data[getPos('price')].'<br/>';
	    echo '<b>Fabric:</b> '.$data[getPos('fabric')].'<br/>';
	    echo '<b>JCode:</b> '.$data[getPos('jcode')].'<br/>';
	    echo '<b>Length:</b> '.$data[getPos('length')].'<br/>';
	    echo '<b>Brand:</b> '.$data[getPos('manufacturer')].'<br/>';
	    echo '<b>Occasion:</b> '.$data[getPos('occasion')].'<br/>';
	    echo '<b>Shipment Type:</b> '.$data[getPos('shipmenttype')].'<br/>';
	    echo '<b>Size:</b> '.$data[getPos('size')].'<br/>';
	    echo '<b>Sleeve:</b> '.$data[getPos('sleeve')].'<br/>';
	    echo '<b>Style:</b> '.$data[getPos('style')].'<br/>';
	    echo '<b>Url Key:</b> '.$data[getPos('url_key')].'<br/>';
	    echo '<b>Super products sku:</b> '.$data[getPos('_super_products_sku')].'<br/>';
	    exit();
        }

        continue;
        
        $product = Mage::getModel('catalog/product');
 
        $product->setSku($data[0]);
        $product->setName($data[3]);
        $product->setDescription($data[4]);
        $product->setShortDescription('');
        $product->setManufacturer($data[20]);
        $product->setPrice($data[9]);
        $product->setTypeId('simple');
        
        $fullpath = 'media/catalog/product/thumb/';
        $ch = curl_init ($data[14]);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
        $fullpath = $fullpath.$data[13].'.gif';
        if(file_exists($fullpath)) {
            unlink($fullpath);
        }
        $fp = fopen($fullpath,'x');
        fwrite($fp, $rawdata);
        fclose($fp);
        $product->addImageToMediaGallery($fullpath, 'thumbnail', false);
        
        $fullpath = 'media/catalog/product/small/';
        $ch = curl_init ($data[15]);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
        $fullpath = $fullpath.$data[13].'.jpg';
        if(file_exists($fullpath)) {
            unlink($fullpath);
        }
        $fp = fopen($fullpath,'x');
        fwrite($fp, $rawdata);
        fclose($fp);
        $product->addImageToMediaGallery($fullpath, 'small-image', false);
        
        $fullpath = 'media/catalog/product/high/';
        $ch = curl_init ($data[16]);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
        $fullpath = $fullpath.$data[13].'.jpg';
        if(file_exists($fullpath)) {
            unlink($fullpath);
        }
        $fp = fopen($fullpath,'x');
        fwrite($fp, $rawdata);
        fclose($fp);
        $product->addImageToMediaGallery($fullpath, 'image', false);
        
        
        
        $product->setAttributeSetId(4); // need to look this up
        $product->setCategoryIds(array($categories[$data[11]])); // need to look these up
        $product->setWeight(0);
        $product->setTaxClassId(2); // taxable goods
        $product->setVisibility(4); // catalog, search
        $product->setStatus(1); // enabled
        
        // assign product to the default website
        $product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));
         
        
        $stockData = $product->getStockData();
        $stockData['qty'] = $data[18]; //18
        $stockData['is_in_stock'] = $data[17]=="In Stock"?1:0; //17
        $stockData['manage_stock'] = 1;
        $stockData['use_config_manage_stock'] = 0;
        $product->setStockData($stockData);


        $product->save();    
       
        
    }
    fclose($handle);
    
}


?>
