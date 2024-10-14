<?php
class Usuario{
        // Connection
    private $conn;
    // Table
    private $db_table = "s_usuario";
    // Columns
    public $usuario_id;
    public $u_id_persona;
    public $u_nivel;
    public $u_login;
    public $u_contrasenia;
    public $u_user_oper;
    public $u_err_op;

        // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
        // GET ALL
    public function getAllUsers($valor_busq,$valor_order_col,$valor_order_dir,$start,$lenght,$draw){
        //echo " pers in";
        $query = '';
        $saida = array();
        $query .= "SELECT * FROM v_usuario ";            
        
        if(isset( $valor_busq ))
        {
            $query .= 'WHERE nombres LIKE "%'.$valor_busq.'%" ';
            $query .= 'OR ci LIKE "%'.$valor_busq.'%" ';
            $query .= 'OR usuario_id LIKE "%'.$valor_busq.'%" ';
            $query .= 'OR u_login LIKE "%'.$valor_busq.'%" ';
        }
        if(isset($valor_order_col)){
            $query .= 'ORDER BY '.$valor_order_col.' '.$valor_order_dir.' ';
        }
        else{
            $query .= 'ORDER BY usuario_id  ';
        }

        if($lenght != -1){
            $query .= 'LIMIT ' . $start . ', ' . $lenght;
        }            
        
        //echo " q: $query";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll();
        
        $dados = array();
        $contar_rows = $stmt->rowCount();                               
        
        foreach($resultado as $row){ 
            
            $sub_array = array();                
            $sub_array[] = $row["usuario_id"];
            $sub_array[] = $row["nombres"];
            $sub_array[] = $row["ci"];
            $sub_array[] = $row["u_login"];
            $sub_array[] = '<button type="button" name="update" id="'.$row["usuario_id"].'" class="btn btn-warning btn-xs update">Actualizar</button>';
            $sub_array[] = '<button type="button" name="delete" id="'.$row["usuario_id"].'" class="btn btn-danger btn-xs delete">Eliminar</button>';
            $dados[] = $sub_array;
            
        }

        $query = "SELECT * FROM v_usuario ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();                
        $resultado = $stmt->rowCount();

        $saida = array(
            "draw"				=>	intval($draw),
            "recordsTotal"		=> 	$contar_rows,
            "recordsFiltered"	=>	$resultado,
            "data"				=>	$dados
        );

        return $saida;
    }

    public function getOneUser(){

        $sqlQuery = "SELECT u_id_persona id_persona,
        u_login login,u_contrasenia pasw, u_contrasenia  paswv 
        FROM s_usuario 
        WHERE usuario_id=".$this->usuario_id;

        //echo "cons: $sqlQuery"; 

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        /*
        echo "array: <pre>";
        var_export($row);
        echo "</pre>";  
        */          

        return $row;
    }        

       // GET number of records 
    public function getCountUser($str_nombres,$str_ci){
        //echo "llega obj prop ";
        //echo "obj count nom: $str_nombres, ci: $str_ci";
        $str_where="";
	
        if(!empty($str_nombres ) ){
            $str_where = " WHERE nombres LIKE '%$str_nombres%' ";
        }
    
        if(!empty($str_ci ) and !empty($str_where) ){
            $str_where .= " AND  ci LIKE '%$str_ci%' ";
        }	
        
        if(!empty($str_ci ) and empty($str_where) ){
            $str_where = " WHERE ci LIKE '%$str_ci%' ";
        }

        $sqlQuery = "SELECT count(*) count  FROM v_usuario $str_where";

        //echo "cons: $sqlQuery"; 

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['count'];      

    }        
       
        // CREATE
    public function createUser(){

        try {
            
            $sqlQuery = " INSERT INTO ". $this->db_table ." SET 
             u_id_persona=:ip,u_nivel=1,u_login=:log,u_contrasenia=:con,u_id_usuario=:iu, u_fecha_add=now() ";    

            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->u_id_persona=htmlspecialchars(strip_tags($this->u_id_persona));
            $this->u_login=htmlspecialchars(strip_tags($this->u_login));
            $this->u_contrasenia=htmlspecialchars(strip_tags($this->u_contrasenia));
            $this->u_user_oper=htmlspecialchars(strip_tags($this->u_user_oper));

            //echo "q: $sqlQuery";
            // bind data
            $stmt->bindParam(":ip", $this->u_id_persona);
            $stmt->bindParam(":log", $this->u_login);
            $stmt->bindParam(":con", $this->u_contrasenia);                               
            $stmt->bindParam(":iu", $this->u_user_oper);    
        
            //echo "sql bind: $sqlQuery";
                    
            if($stmt->execute()){                    
                return true;
            }               
            else {
                throw new Exception("Error ejecutando la consulta: " . implode(" ", $stmt->errorInfo()));
                return false; 
            }
        }catch (Exception $e) {  
            $this->u_err_op=$e->getMessage();               
            return false;
        }
    }
        
    // UPDATE
    public function updateUser(){ 

        $sqlQuery = "UPDATE ". $this->db_table ." SET u_id_persona= :ip,
        u_nivel= 1, u_login=:log, u_contrasenia=:con, u_id_usuario_mod=:io,u_fecha_mod=now()
        WHERE usuario_id=:iu ";        
    
        $stmt = $this->conn->prepare($sqlQuery);        
    
        $this->u_id_persona=htmlspecialchars(strip_tags($this->u_id_persona));
        $this->u_login=htmlspecialchars(strip_tags($this->u_login));
        $this->u_contrasenia=htmlspecialchars(strip_tags($this->u_contrasenia));
        $this->usuario_id=htmlspecialchars(strip_tags($this->usuario_id));
        $this->u_user_oper=htmlspecialchars(strip_tags($this->u_user_oper));
    
        // bind data
        $stmt->bindParam(":ip", $this->u_id_persona);
        $stmt->bindParam(":log", $this->u_login);
        $stmt->bindParam(":con", $this->u_contrasenia);
        $stmt->bindParam(":iu", $this->usuario_id);
        $stmt->bindParam(":io", $this->u_user_oper);

        /*
        echo " <br>user id ".$this->usuario_id;
        echo " <br>persona ".$this->u_id_persona;
        echo " <br>login ".$this->u_login;
        echo " <br>pwd ".$this->u_contrasenia;
        */

        //echo " <br>q: $sqlQuery";
    
        if($stmt->execute()){
            return true;
        }
        return false;
    }
        // DELETE
    function deleteUser(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE usuario_id = ?";
        //echo "q: $sqlQuery";
        $stmt = $this->conn->prepare($sqlQuery);
    
        $this->usuario_id=htmlspecialchars(strip_tags($this->usuario_id));
    
        //echo "val: ".$this->persona_codigo;
        $stmt->bindParam(1, $this->usuario_id);
    
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
    public function verifyLoginUser($str_login,$str_pwd){
        $sqlQuery = "select fn_login('$str_login','$str_pwd') result";       

        //echo "cons: $sqlQuery"; 

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['result'];
    }  
    public function getLoginUser($intUser){

        $sqlQuery = "
            SELECT  CONCAT_WS(\" \",\"Bienvenido usuario\",u_login,\" con nombres\",nombres,\"y ci\",ci) mens
            FROM v_usuario
            WHERE  usuario_id = $intUser
        ";
        

        //echo "cons: $sqlQuery"; 

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['mens'];
    }           

    public function getComboPersona(){   

        $sqlQuery = "SELECT persona_codigo,nombres FROM v_persona order by nombres ";

        //echo "cons: $sqlQuery"; 

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
            
        $ClienteArr = array();

        while ($row = $stmt->fetch(PDO:: FETCH_OBJ)){
            array_push($ClienteArr, $row);
             
        }

        $result = json_encode($ClienteArr);
        return $result;
    }    
}
?>