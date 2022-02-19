<?php 
    class db
    {
        function __construct($dbhost, $dbport, $dbuser, $dbpass)
        {
            $this->dbhost = $dbhost;
            $this->dbport = $dbport;
            $this->dbuser = $dbuser;
            $this->dbpass = $dbpass;
            $this->dbname = 'mysql';
        }

        // Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbConnection->exec("set names utf8");
            return $dbConnection;
        }
    }

?>