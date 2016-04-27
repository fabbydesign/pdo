<?php
class db{
    protected static $_instance;//use inside
    protected $conn;
    
    public static function instance($conn=null){
        
        if(self::$_instance instanceof  db){
            return self::$_instance;
        }
        else{
            return self::$_instance = new db($conn);
        }
    }
    
    public function __construct($conn) {
        try{
            $this->conn =  new PDO('mysql:host='.$conn['host'].';dbname='.$conn['db_name'], $conn['user'], $conn['password']);
        }
        catch(PDOException $e){
            echo "Error database connect: ".$e->getMessage();
        }
        
    }
    
    public function __destruct() {
       $this->conn = NULL;
    }
    
    public function __clone() {
        throw new Exception("Can't clone DB - singleton pattern");
    }
    
    public function fetch1($sql){
        try {
            $db = $this->conn;
            $rs = $db->prepare($sql);
            $rs->execute();
            $foo = $rs->fetchAll();
            return $foo;
            

        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }
    }
    public function fetch($sql){
        try{
            $query = $this->conn->query($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $return = $query->fetchAll();
        }
        catch(PDOException $e){
            echo $e->showMessage();
        }
        return $return;
    }
    
    /**EXECUTE A QUERY
     * lastID - null or true | if true, then return last id inserted
     */
    public function query($sql,$lastID=null){
        
        $sth = $this->conn->prepare($sql);
        $sth->execute();
        $arr = $sth->errorInfo();
        if(is_array($arr) and isset($arr[3])) die($arr[3]);
        
        if($lastID) return $this->conn->lastInsertId();
        else return $sth->rowCount();
    }
}
?>
