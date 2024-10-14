<?php
    class Persona{
        // Connection
        private $conn;
        // Table
        private $db_table = "t_persona";
        // Columns
        public $persona_codigo;
        public $persona_primer_nombre;
        public $persona_segundo_nombre;   
        public $persona_primer_apellido;  
        public $persona_segundo_apellido; 
        public $persona_ci;
        public $titulo;
        public $p_fecha_nacimiento;
        public $p_user_oper;
        public $c_error_mess;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getAllPersonas($valor_busq,$valor_order_col,$valor_order_dir,$start,$lenght,$draw){
            //echo " pers in";
            $query = '';
            $saida = array();
            $query .= "SELECT * FROM v_persona ";            
            
            if(isset( $valor_busq ))
            {
                $query .= 'WHERE nombres LIKE "%'.$valor_busq.'%" ';
                $query .= 'OR ci LIKE "%'.$valor_busq.'%" ';
                $query .= 'OR fecha_nacimiento LIKE "%'.$valor_busq.'%" ';
                $query .= 'OR persona_codigo LIKE "%'.$valor_busq.'%" ';
            }
            if(isset($valor_order_col)){
                $query .= 'ORDER BY '.$valor_order_col.' '.$valor_order_dir.' ';
            }
            else{
                $query .= 'ORDER BY persona_codigo  ';
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
                $sub_array[] = $row["persona_codigo"];
                $sub_array[] = $row["nombres"];
                $sub_array[] = $row["ci"];
                $sub_array[] = $row["fecha_nacimiento"];
                $sub_array[] = '<button type="button" name="update" id="'.$row["persona_codigo"].'" class="btn btn-warning btn-xs update">Actualizar</button>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["persona_codigo"].'" class="btn btn-danger btn-xs delete">Eliminar</button>';
                $dados[] = $sub_array;
                
            }
        
            $query = "SELECT * FROM v_persona ";
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
        public function getOnePersona(){

            $sqlQuery = "SELECT  persona_primer_nombre primer_nombre,
            COALESCE(persona_segundo_nombre,'') segundo_nombre,
            persona_primer_apellido paterno,
            COALESCE(persona_segundo_apellido ,'') materno,
            COALESCE(persona_ci,'') ci,COALESCE(titulo,'') titulo,
            COALESCE(date_format(p_fecha_nacimiento,'%Y-%m-%d'),'') fech_nac             
            FROM ". $this->db_table ." WHERE persona_codigo= ".$this->persona_codigo;

            /*
            COALESCE(date_format(p_fecha_nacimiento,'%d-%m-%Y'),'') dte_persona_fecha_nacimiento ,
            COALESCE(date_format(p_fecha_nacimiento,'%d-%m-%Y'),'') txt_aux_fecha 
            */

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
    public function getCountPersonas($str_nombres,$str_ci){
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

        $sqlQuery = "SELECT count(*) count  FROM v_persona $str_where";

        //echo "cons: $sqlQuery"; 

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['count'];      

    }        
       
        // CREATE
        public function createPerson(){

            try {
               
                $sqlQuery = " INSERT INTO ". $this->db_table ." SET 
                persona_primer_nombre = :persona_primer_nombre,persona_segundo_nombre = :persona_segundo_nombre,
                persona_primer_apellido = :persona_primer_apellido,persona_segundo_apellido = :persona_segundo_apellido,
                persona_ci = :persona_ci,titulo = :titulo,p_fecha_nacimiento = :p_fecha_nacimiento,p_user_add=:uo, p_fecha_add=now() ";    

                $stmt = $this->conn->prepare($sqlQuery);
            
                // sanitize
                $this->persona_primer_nombre=htmlspecialchars(strip_tags($this->persona_primer_nombre));
                $this->persona_segundo_nombre=htmlspecialchars(strip_tags($this->persona_segundo_nombre));
                $this->persona_primer_apellido=htmlspecialchars(strip_tags($this->persona_primer_apellido));
                $this->persona_segundo_apellido=htmlspecialchars(strip_tags($this->persona_segundo_apellido));
                $this->persona_ci=htmlspecialchars(strip_tags($this->persona_ci));
                $this->titulo=htmlspecialchars(strip_tags($this->titulo));                
                $this->p_fecha_nacimiento = !empty($this->p_fecha_nacimiento) ? htmlspecialchars(strip_tags($this->p_fecha_nacimiento)) : null;
                $this->p_user_oper=htmlspecialchars(strip_tags($this->p_user_oper));

                //echo "q: $sqlQuery";
                // bind data
                $stmt->bindParam(":persona_primer_nombre", $this->persona_primer_nombre);
                $stmt->bindParam(":persona_segundo_nombre", $this->persona_segundo_nombre);
                $stmt->bindParam(":persona_primer_apellido", $this->persona_primer_apellido);
                $stmt->bindParam(":persona_segundo_apellido", $this->persona_segundo_apellido);
                $stmt->bindParam(":persona_ci", $this->persona_ci);
                $stmt->bindParam(":titulo",$this->titulo);
                $stmt->bindParam(":p_fecha_nacimiento", $this->p_fecha_nacimiento);                               
                $stmt->bindParam(":uo", $this->p_user_oper);
            
                //echo "sql bind: $sqlQuery";
                        
                if($stmt->execute()){                    
                    return true;
                }               
                else {
                    throw new Exception("Error ejecutando la consulta: " . implode(" ", $stmt->errorInfo()));
                    return false; 
                }
            }catch (Exception $e) {     
                    return $e->getMessage();
            }
        }
        
        // UPDATE
        public function updatePersona(){ 

            $sqlQuery = "UPDATE ". $this->db_table ."
                        SET persona_primer_nombre=:pn,persona_segundo_nombre=:sn,
                        persona_primer_apellido=:pa,persona_segundo_apellido=:sa,
                        persona_ci=:ci,titulo=:tit,p_fecha_nacimiento=:fn,
                        p_user_mod=:uo,p_fecha_mod=now()
                        WHERE persona_codigo=:id ";                        
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->persona_primer_nombre=htmlspecialchars(strip_tags($this->persona_primer_nombre));
            $this->persona_segundo_nombre=htmlspecialchars(strip_tags($this->persona_segundo_nombre));
            $this->persona_primer_apellido=htmlspecialchars(strip_tags($this->persona_primer_apellido));
            $this->persona_segundo_apellido=htmlspecialchars(strip_tags($this->persona_segundo_apellido));
            $this->persona_ci=htmlspecialchars(strip_tags($this->persona_ci));
            $this->p_fecha_nacimiento=htmlspecialchars(strip_tags($this->p_fecha_nacimiento));
            $this->persona_codigo=htmlspecialchars(strip_tags($this->persona_codigo));
            $this->titulo=htmlspecialchars(strip_tags($this->titulo));
            $this->p_user_oper=htmlspecialchars(strip_tags($this->p_user_oper));
            //echo " user op: ".$this->p_user_oper; 
        
            // bind data
            $stmt->bindParam(":pn", $this->persona_primer_nombre);
            $stmt->bindParam(":sn", $this->persona_segundo_nombre);
            $stmt->bindParam(":pa", $this->persona_primer_apellido);
            $stmt->bindParam(":sa", $this->persona_segundo_apellido);
            $stmt->bindParam(":ci", $this->persona_ci);
            $stmt->bindParam(":fn", $this->p_fecha_nacimiento);
            $stmt->bindParam(":tit",$this->titulo);
            $stmt->bindParam(":id", $this->persona_codigo);
            $stmt->bindParam(":uo", $this->p_user_oper);
        
            //echo "sql bind: $sqlQuery";

            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        function deletePersona(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE persona_codigo = ?";
            
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->persona_codigo=htmlspecialchars(strip_tags($this->persona_codigo));
        
            //echo " val: ".$this->persona_codigo;
            $stmt->bindParam(1, $this->persona_codigo);
        
            //echo " q: $sqlQuery ";

            try {
                if($stmt->execute()){
                return true;
                }else {
                    throw new Exception("Error ejecutando la consulta: " . implode(" ", $stmt->errorInfo()));
                    return false; 
                }
            }catch (Exception $e) {     
                $this->c_error_mess=$e->getMessage();
                return false;
            }
        }
        
        function combo_persona(){
            $sql = "SELECT persona_codigo,nombres FROM v_persona order by nombres";
            //echo " q $sql";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll();

            $contar_rows = $stmt->rowCount(); 
            
            // Generar las opciones del select
            $options = "";
            if ($contar_rows > 0) {

                foreach($resultado as $row){ 
                    $options .= '<option value="' . htmlspecialchars($row['persona_codigo']) . '">' . htmlspecialchars($row['nombres']) . '</option>';                                 
                }

            } else {
                $options .= '<option value="">No hay datos</option>';
            }

            return $options;
        }           
    }
?>