<?php

class Members extends PDO
{
    private $dbh;
    private $host;
    private $username;
    private $password;
    private $db;
    function __construct()
    {

        $this->host       = "localhost";
        $this->username   = "loser";
        $this->password   = "$5k1dm4rk$";
        $this->db         = "grantsoffice";
		
		 try{
        	$this->dbh = new PDO("mysql:dbname=$this->db;host=$this->host", "$this->username", "$this->password" );
		 }catch(Exception $e){
			$this->dbh = ""; 
		 }

    }

    
    
    function getMemberInfo( $mci ) 
    {
        $sql = "select * from members where master_customer_id = '".$mci."';";
    
        if(empty($this->dbh)){
            return;	 
	 }
		 
        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function saveMemberInfo( $m, $k, $sec, $v, $uk, $t, $link,  $e, $fn, $ln, $p, $td ) 
    {
        
        $sql = "insert into members ( master_customer_id, gkey, secret, value, token, userkey, autologinlink, email, firstname,"
                . " lastname, password, date_created ) values ( '".$m."','".$k."','".$sec."','".$v."','".$t."','".$uk."','".$link."','".$e."','".$fn."','".
                $ln."','".$p."','".$td."' );";
        
        if(empty($this->dbh)){
            $this->dbh = new PDO("mysql:dbname=$$this->db;host=$$this->host", "$$this->username", "$this->password" );;	 
	 }
        
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->execute(); 
        }catch (Exception $e){
            print "Error!: " . $e->getMessage() . "</br>"; 
        }
        return $this->dbh->lastInsertId();         

    }

    function deleteMemberInfo( $mci ) 
    {
        
        $sql = "delete from members where master_customer_id = '".$mci."'";
                
        
        if(empty($this->dbh)){
            $this->dbh = new PDO("mysql:dbname=$$this->db;host=$$this->host", "$$this->username", "$this->password" );;	 
	 }
        
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->execute(); 
        }catch (Exception $e){
            print "Error!: " . $e->getMessage() . "</br>"; 
        }
        return $this->dbh->lastInsertId();         

    }

    function updateMemberInfo( $m, $v, $t, $link ) 
    {
        
        $sql = "update members set value = '".$v."', token = '".$t."', autologinlink = '".$link."' where master_customer_id = '".$m."'";
        
        if(empty($this->dbh)){
            $this->dbh = new PDO("mysql:dbname=$$this->db;host=$$this->host", "$$this->username", "$this->password" );;	 
	 }
        
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->execute(); 
        }catch (Exception $e){
            print "Error!: " . $e->getMessage() . "</br>"; 
        }
        return $this->dbh->lastInsertId();         

    }
    
}

?>
