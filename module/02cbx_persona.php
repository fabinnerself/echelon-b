<?php

include '../lib/php/database.php';
include '../lib/php/persona.php';

$database = new Database();
$db = $database->getConnection();
$items = new Persona($db);
echo " in" ;
$strCombo_pers=$items->combo_persona();

echo "$strCombo_pers";
 
?>
