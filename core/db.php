<?php
class db{
    private $db_pdo;

    function __construct(){
        global $config;
        try {
            $this->db_pdo = new PDO('mysql:host='.$config['db']['localhost'].';dbname='.$config['db']['name'], $config['db']['username'], $config['db']['password'],
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
        } catch (PDOException $e) {
            error('Database Connection Error',$e->getMessage());
            exit;
        }
    }

    function single($query_string){
        
        $query=$this->db_pdo->query($query_string);
        if($this->db_pdo->errorCode() == 0) {
            return $query->fetch();
        }else{
            error('Database Query Run Failure','['.$this->db_pdo->errorCode().'] - '.$this->db_pdo->errorInfo()[2]);
        }
    }
    function multi($query_string){
        $ret=array();
        $i=0;
        $query=$this->db_pdo->query($query_string);
        if($this->db_pdo->errorCode() == 0) {
            foreach($query as $row) {
                $ret[$i]=$row;
                $i++;
            }
            return $ret;
        }else{
            error('Database Query Run Failure','['.$this->db_pdo->errorCode().'] - '.$this->db_pdo->errorInfo()[2]);
        }
    }

    function exec($query_string){
        $stmt = $this->db_pdo->prepare($query_string);
        if($this->db_pdo->errorCode() == 0) {
            return $stmt->execute();
        }else{
            error('Database Query Run Failure','['.$this->db_pdo->errorCode().'] - '.$this->db_pdo->errorInfo()[2]);
        }
    }
    function rowCount($query_string){
        $query=$this->db_pdo->query($query_string);
        if($this->db_pdo->errorCode() == 0) {
            return $query->rowCount();
        }else{
            error('Database Query Run Failure','['.$this->db_pdo->errorCode().'] - '.$this->db_pdo->errorInfo()[2]);
        }
    }

    function transaction($queries=[]){
        try {
            $this->db_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db_pdo->beginTransaction();
            foreach($queries as $query){
                $this->db_pdo->exec($query);
            }
            $this->db_pdo->commit();
            return true;

        }catch (Exception $e) {
            $this->db_pdo->rollBack();
            error('Database Query Run Failure','['.$this->db_pdo->errorCode().'] - '.$this->db_pdo->errorInfo()[2]);
        }
    }
	function lastInsertId(){
		return $this->db_pdo->lastInsertId();
	}

}
?>