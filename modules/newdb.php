<?php 
//wrap mysqli classes in php?

class access_db{
function Connect() {
     $this->con= new mysqli("localhost","accoladets","accolad3TS", "accoladets") or die;
}
    function eClose(){
        mysqli_close($this->con);
    } 
    /**Insert data
    * @param string $table  name of the table
    * @param string $field  table field eg. "field1,field2,field3"
    * @param string $param  field parameters subtitute eg. "(?,?,?)"
    * @param array $valarr  array of field values eg. array("string1",2,"string3") or array(array(),array())
    * @param string $option  (optional)
    * Available option: <b>get_id</b> - (for single insert only)get the last auto generated id after query.
    * @param string $option2  (optional). multi or NULL
    * @return boolean true, error message or the expected value of the given option
    */
    function insert_data($table,$field,$param,$valarr,$option = NULL,$option2 = NULL){
        $this->Connect();
        $sql = "INSERT INTO ".$table." (".$field.") VALUES ".$param;
        if($stmt = $this->con->prepare($sql)){
            if($option2 == 'multi'){
                $idarr = array();
                foreach($valarr as $v){
                    $this->dynamic_bind_param($stmt, $v);
                    if($stmt->execute()){
                        if(is_null($option) == true){
                            $idarr = true;
                        }else{
                            if($option == 'get_id'){
                                $idarr[] = $stmt->insert_id;
                            }
                        }
                    }else{
                        return '<b>(INSERT Error)</b> Error in executing the prepared statement: '.htmlspecialchars($stmt->error);
                        exit();
                    }
                }
                return $idarr;
                exit();
            }else{
                $this->dynamic_bind_param($stmt, $valarr);
                if($stmt->execute()){
                    if(is_null($option) == true){
                        return true;
                    }else{
                        if($option == 'get_id'){
                            return $stmt->insert_id;
                        }
                    }
                }else{
                    return '<b>(INSERT Error)</b> Error in executing the prepared statement: '.htmlspecialchars($stmt->error);
                    exit();
                }
            }
        }else{
            return '<b>(INSERT Error)</b> Error in initializing the prepared statement: '.htmlspecialchars($stmt->error).'SQL: '.$sql.' VALUES: '.json_encode($valarr);
            exit();
        }
        $stmt->close();
        $this->eClose();
    }
    /**Update data
    * @param string $table  name of the table
    * @param string $field  table field eg. "field1 = ?, field2 = ?, field3 = ?"
    * @param string $where  database filter eg. "filter1 = ? AND filter2 = ?" or ""
    * @param array $valarr  array of field values eg. array("string1",2,"string3")
    * @return boolean true or error message
    */
    function update_data($table,$field,$where,$valarr){
        $this->Connect();
        $where = ($where == '')? '' : 'WHERE '.$where;
        $sql = "UPDATE ".$table." SET ".$field." ".$where;
        if($stmt = $this->con->prepare($sql)){
            $this->dynamic_bind_param($stmt, $valarr);
            if($stmt->execute()){
                return true;
            }else{
                return '<b>(UPDATE Error)</b> Error in executing the prepared statement: '.htmlspecialchars($stmt->error).'SQL: '.$sql.' Values: '.json_encode($valarr);
                exit();
            }
        }else{
            return '<b>(UPDATE Error)</b> Error in initializing the prepared statement: '.htmlspecialchars($stmt->error).'SQL: '.$sql;
            exit();
        }
        $stmt->close();
        $this->eClose();
    }
    /**Delete data
    * @param string $table  name of the table
    * @param string $where  database filter eg. "filter1 IN (1,2,3) AND filter = 4"
    * @return boolean true or error message
    */
    function delete_data($table,$where = NULL){
        $this->Connect();
        $where = (is_null($where) == true)? '' : 'WHERE '.$where;
        $sql = "DELETE FROM ".$table." ".$where;
        $qry = $this->con->query($sql);
        if($qry){
            return true;
        }else{
            return '<b>(Delete Error)</b> Error executing the delete query: '.htmlspecialchars($this->con->error);
        }
        $this->eClose();
    }
    /**Get table data
    * @param string $table  name of the table
    * @param string $field  table field eg. "field1, field2, field3"
    * @param string $orderby  database filter eg. "field1 ASC" or NULL
    * @param string $where  database filter eg. "filter1 = ? AND filter2 = ?" or NULL
    * @param array $valarr  array of field values eg. array("string1",2,"string3") or NULL
    * @return array Multidimensional_Arrays  Two-dimensional Arrays
    *
    * Array([0] => Array([field1] => string1,[field2] => 2,[field3] => string3))
    */
    function get_table_data($table,$field,$orderby = NULL,$where = NULL,$valarr = NULL){
        $this->Connect();
        $fields = array();
        $results = array();
        $orderby = (is_null($orderby) == true)? '' : 'ORDER BY '.$orderby;
        $where = (is_null($where) == true)? '' : 'WHERE '.$where;
        $sql = "SELECT ".$field." FROM ".$table." ".$where." ".$orderby;
        if($stmt = $this->con->prepare($sql)){
            if(is_null($valarr) == false){
                $this->dynamic_bind_param($stmt, $valarr);
            }
            if($stmt->execute()){
                $meta = $stmt->result_metadata();
                while ($field = $meta->fetch_field()) { 
                    $var = $field->name; 
                    $$var = null; 
                    $fields[$var] = &$$var;
                }
                call_user_func_array(array($stmt,'bind_result'),$fields);
                $i = 0;
                while ($stmt->fetch()) {
                    $results[$i] = array();
                    foreach($fields as $k => $v){
                        $results[$i][$k] = $v;
                    }
                    $i++;
                }
                return $results;
            }else{
                return '<b>(SELECT Error)</b> Error in executing the prepared statement: '.htmlspecialchars($stmt->error).'SQL: '.$sql;
            }
        }else{
            return '<b>(SELECT Error)</b> Error in initializing the prepared statement: '.htmlspecialchars($stmt->error).'SQL: '.$sql;
        }
        $stmt->close();
        $this->eClose();
    }
    private function dynamic_bind_param($stmt,$values){   
        if(is_array($values) == true){
            $types = '';
            foreach($values as $param) {
                // set param type
                if (is_string($param)) {
                    $types .= 's';  // strings
                } else if (is_int($param)) {
                    $types .= 'i';  // integer
                } else if (is_float($param)) {
                    $types .= 'd';  // double
                } else {
                    $types .= 'b';  // default: blob and unknown types
                }
            }
            $paramArr[] = &$types;
            for ($i=0; $i<count($values);$i++){
                $paramArr[] = &$values[$i];
            }
            call_user_func_array(array($stmt,'bind_param'), $paramArr);
        }else{
            $types = '';
            if (is_string($values)) {
                $types .= 's';  // strings
            } else if (is_int($values)) {
                $types .= 'i';  // integer
            } else if (is_float($values)) {
                $types .= 'd';  // double
            } else {
                $types .= 'b';  // default: blob and unknown types
            }
            $stmt->bind_param($types,$values);
        }
        return $stmt;
    }
}
?>


$data = $access_db->get_table_data("users","field1,field2",NULL,"id = ? AND active = ?",array($id, $active));


foreach($data as $val){
$f1 = $val["field2"]; // use the name of every table field you put on the get_table_data as the array id of the $val. $val is user_define and so as $data
$f2 = $val["field2"]
}


