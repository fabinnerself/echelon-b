<?php

include '../lib/php/database.php';
include '../lib/php/persona.php';
include('../lib/php/funcoes.php');

if(isset($_POST["usuario_id"]))
{
    $database = new Database();
    $db = $database->getConnection();
    $items = new Persona($db);

    $items->persona_codigo = $_POST["usuario_id"];

    $arrRes=$items->getOnePersona();
 
	echo json_encode($arrRes);
}
?>