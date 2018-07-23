<?php

class SqlServerdb {
    
    private $dbh;
    private $db;
    private $host;
    private $username;
    private $password;
    
    public function __construct($server = 'optimus-prime\sql2008hq', $db = "pprod", $user = "sa", $pass = "njsba" )
    {
        $this->host = $server;
        $this->db = $db;
        $this->username = $user; 
        $this->password = $pass;        

        // Connect to MSSQL
        $this->createConnection();
        
    }
    
    private function createConnection()
    {
        $this->dbh = mssql_connect( $this->host, $this->username, $this->password );
        
        if (!$this->dbh || !mssql_select_db($this->db, $this->dbh)) {
            die('Unable to connect or select database!');
        }
        
        if (!$this->dbh) {
            die('Something went wrong while connecting to MSSQL');
        }
        else
        {
            print("worked we made a connection...\n");
        }
        
        return $this->dbh;
    }
    
    public function doQuery( $sql )
    {
        
        if(empty($this->dbh)){
            createConnection();	 
	}
        
        $results = array();
        
        $qhandle = mssql_query( $sql, $this->dbh );

        
        // Iterate through returned records
        do 
        {
            while ($row = mssql_fetch_assoc($qhandle)) 
            {
                array_push( $results, $row );
            }
        } while (mssql_next_result($qhandle));

        if( count($results) < 2  ) 
        {
            return array_pop($results); 
        }
        
        mssql_free_result($qhandle);
        
        return $results;
        
    }
    
    public function doInsert( $sql )
    {
        if(empty($this->dbh)){
            createConnection();	 
	}

        $qhandle = mssql_query( $sql, $this->dbh );
               
        mssql_free_result($qhandle);
        
        return mssql_num_rows($qhandle);
        
    }

    
    
    
}




?>
