$file = __DIR__.'/country.txt';
$content = file_get_contents($file);
$country = preg_split("/\n/",trim($content));
$c = "";
foreach($country as $key=>$v){
$v = preg_split("/\s/",trim($v));
$c=$c.'"'.$v[0].'",';

}
echo $c;
