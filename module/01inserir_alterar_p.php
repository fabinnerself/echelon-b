<?php

include '../lib/php/database.php';
include '../lib/php/persona.php';
include('../lib/php/funcoes.php');

if(isset($_POST["operacao"])){

    $database = new Database();
    $db = $database->getConnection();
    $items = new Persona($db);

    $str_prim_nomb 		= $_POST['primer_nombre'];
    $str_seg_nomb 		= $_POST['segundo_nombre'];
    $str_paterno 		= $_POST['paterno'];
    $str_materno 		= $_POST['materno'];
    $str_ci	 			= $_POST['ci'];
    $dte_fecha_nacim	= date( 'Y-m-d',strtotime($_POST['fech_nac'])); 
    $str_titulo			= $_POST['titulo']; 
     
    if(  $dte_fecha_nacim=="1970-01-01")
        $dte_fecha_nacim=""; 

    $items->persona_primer_nombre = $str_prim_nomb;
    $items->persona_segundo_nombre = $str_seg_nomb;
    $items->persona_primer_apellido = $str_paterno;
    $items->persona_segundo_apellido = $str_materno;
    $items->persona_ci = $str_ci;
    $items->titulo = $str_titulo;
    $items->p_fecha_nacimiento = $dte_fecha_nacim;
    $items->persona_codigo = $_POST['usuario_id'];
    //$items->p_user_oper = $_SESSION['id_usuario'];
    $items->p_user_oper = 10;    

	if($_POST["operacao"] == "Add"){

        if($items->createPerson()){
            echo 'Registro de persona insertada con exito !';
        }
 
	}

	if($_POST["operacao"] == "Edit"){	 
 
		if($items->updatePersona()){
			echo 'Registro de persona actualizado con exito !';
		}
	}
}

?>