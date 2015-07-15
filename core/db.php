<?php
class db{
    private $db_pdo;

    function __construct(){
        global $config;
        $this->db_pdo = new PDO('mysql:host='.$config['db']['localhost'].';dbname='.$config['db']['name'], $config['db']['username'], $config['db']['password'],
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    function single($query_string){
        $query=$this->db_pdo->query($query_string);
        if($this->db_pdo->errorCode() == 0) {
            return $query->fetch();
        }else{
            return $this->db_pdo->errorCode();
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
            return $this->db_pdo->errorCode();
        }
    }

    function exec($query_string){
        $stmt = $this->db_pdo->prepare($query_string);
        if($this->db_pdo->errorCode() == 0) {
            return $stmt->execute();
        }else{
            return $this->db_pdo->errorCode();
        }
    }
    function rowCount($query_string){
        $query=$this->db_pdo->query($query_string);
        if($this->db_pdo->errorCode() == 0) {
            return $query->rowCount();
        }else{
            return $this->db_pdo->errorCode();
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
            return "Failed: " . $e->getMessage();
        }
    }
	function lastInsertId(){
		return $this->db_pdo->lastInsertId();
	}

}
?>