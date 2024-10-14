<?php

include '../lib/php/database.php';
include '../lib/php/persona.php';
include('../lib/php/funcoes.php');

$database = new Database();
$db = $database->getConnection();
$items = new Persona($db);
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


$arrlistado = $items->getAllPersonas($valor_busq,$valor_order_col,$valor_order_dir,$start,$lenght,$draw);

echo json_encode($arrlistado);
 
?>