<?php

include '../lib/php/database.php';
include '../lib/php/user.php';

if(isset($_POST["usuario_id"])){

    $database = new Database();
    $db = $database->getConnection();
    $items = new Usuario($db);

    $items->usuario_id = $_POST["usuario_id"];

    //echo " in "; 
    $arrRes=$items->getOneUser();
 
	echo json_encode($arrRes);
}
?>