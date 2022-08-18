<?
class DB {
    private $dbname = "bunqchatt";

    public function connect(){
        return $db = new PDO("sqlite:".__DIR__."/".$this->dbname.".sql");
    }

    public function init(){
        if (file_exists($this->dbname)) {
            unlink($this->dbname);
        }        
        $db = new PDO("sqlite:".__DIR__."/".$this->dbname.".sql");
        $db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $db -> exec('create table users (uid number,username varchar2, token varchar2)');
            $db -> exec('INSERT INTO users(uid,username,token) VALUES(1,"john","xyzqwert")');
            $db -> exec('INSERT INTO users(uid,username,token) VALUES(2,"paul","bnmkjhgf")');
            $db -> exec('INSERT INTO users(uid,username,token) VALUES(3,"david","ghfgghhj")');           
            $db -> exec('create table messages (sender number,toid number, msg varchar2)');
            $db -> exec('INSERT INTO messages(sender,toid,msg) VALUES(1,2,"Why")');
            $db -> exec('INSERT INTO messages(sender,toid,msg) VALUES(2,1,"Why not")'); 
            $db -> exec('INSERT INTO messages(sender,toid,msg) VALUES(1,2,"Bye")');
          
            return  "Ok";
        }
        catch(PDOException $e) {
            return $e;
        }
    }
}
?>