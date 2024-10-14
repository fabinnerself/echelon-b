<?php

include '../lib/php/database.php';
include '../lib/php/user.php';


if(isset($_POST["operacao"])){

    $database = new Database();
    $db = $database->getConnection();
    $items = new Usuario($db);

    $str_pwd 		= $_POST['pasw'];
    $str_login 		= $_POST['login'];
    $str_id_persona	= $_POST['id_persona'];
    $str_id_user	= $_POST['usuario_id'];
   

    $items->u_id_persona = $str_id_persona;
    $items->u_login = $str_login;
    $items->u_contrasenia = $str_pwd;
    $items->usuario_id = $str_id_user;    
    $items->u_user_oper = 1;

	if($_POST["operacao"] == "Add"){

        //echo " in add";

        if($items->createUser()){
            echo 'Registro de usuario insertado con exito !';
        }
        else{
            echo "Ocurrio el error:".$items->u_err_op;
        }
 
	}

	if($_POST["operacao"] == "Edit"){	 
 
		if($items->updateUser()){
			echo 'Registro de usuario actualizado con exito !';
		}
	}
}

?>