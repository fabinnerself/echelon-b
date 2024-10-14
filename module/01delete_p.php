<?php

include '../lib/php/database.php';
include '../lib/php/persona.php';
include('../lib/php/funcoes.php');

if(isset($_POST["persona_codigo"]))
{
		
    $database = new Database();
    $db = $database->getConnection();
    $items = new Persona($db);
    
    $items->persona_codigo = $_POST["persona_codigo"]; 

    //echo " pc: ".$items->persona_codigo;
	
	if($items->deletePersona()){
		echo 'Registro de Persona eliminado';
	} 
    else{
        if($items->c_error_mess!=""){
            $err=$items->c_error_mess;
            $_err_exption="Error ejecutando la consulta: 23000 1451 Cannot delete or update a parent row: a foreign key constraint fails (`db_sisec`.`s_usuario`, CONSTRAINT `s_usuario_ibfk_1` FOREIGN KEY (`u_id_persona`) REFERENCES `t_persona` (`persona_codigo`) ON UPDATE CASCADE)";

            if($_err_exption!=$err){
                echo "Error al tratar de eliminar por que ocurrio el error ".$items->c_error_mess ;
            }
            else{
                echo "No se puede eliminar el registro de esta persona pues tiene asociado un un usuario, primero eliminar el registro del usuario luego puede eliminar el registro de esta persona";
            }
        }
        else{
            echo "error super extraño ";
        }
    }
}



?>