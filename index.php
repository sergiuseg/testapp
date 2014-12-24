<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once(__DIR__ . '/vendor/autoload.php');

//use Cordial\Cordial;
$apiKey = '5488e48b367df16e6a8b4567-qtUn8CmpNm4toy6lkwp3Lt7gNMOvn48I';

$cordial = new Cordial($apiKey);
$res = get_included_files();
print_r($res);
$page = "1";
$per_page = "25";

$queryParameters = ["fields"=>"email,first"];

//$contacts = $cordial -> getContacts($queryParameters, $page, $per_page);
//print_r($contacts);


$queryParameters = [];
//$products = $cordial->getProducts ($queryParameters, $page, $per_page); 
//echo '<pre>';
//print_r($products);
//echo '</pre>';

$id = time();
$insert = array(
    'productID' => $id,
    'productType' => 'digital',
    'productName' => 'Black Guitar',
	'variants' => array(
		array(
			"sku" => "sf00480ss",
			"color" => "black",
			"size" => "S", 
			"qty" => 20
		)
	)
);
//$result = $cordial ->createProducts($insert);
//print_r($result);


//$products = $cordial->getoneProducts($id);
//print_r($products);


$id = '549a4a09367df1e7728b4568';
$job = $cordial->getJobs('sdfsdf','sdfsdf','sdfsdf','sdfsdf');

print_r($job);

$orders = $cordial -> putOrders();



?>
