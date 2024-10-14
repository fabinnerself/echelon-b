<?php

include '../lib/php/database.php';
include '../lib/php/user.php';


$database = new Database();
$db = $database->getConnection();
$items = new Usuario($db);
//echo " ff ";

$valor_busq=$_POST["search"]["value"];
$valor_order_col=$_POST['order']['0']['column'];
$valor_order_dir=$_POST['order']['0']['dir'];
$start=$_POST['start'];
$lenght=$_POST['length'];
$draw=$_POST["draw"];

IF($valor_order_col==0){
    $valor_order_col=1;
}

$arrlistado = $items->getAllUsers($valor_busq,$valor_order_col,$valor_order_dir,$start,$lenght,$draw);

echo json_encode($arrlistado);
 
?>