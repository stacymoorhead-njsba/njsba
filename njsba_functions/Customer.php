<?php
include('GO_SqlServerdb.php');

class Customer 
{
    private $db;

    public function __construct()
    {
        $this->db = new SqlServerdb();
    }
    
    public function getUserDatabyMasterId( $id )
    {
        $sql = "select FIRST_NAME, LAST_NAME, PRIMARY_EMAIL_ADDRESS from dbo.customer where MASTER_CUSTOMER_ID = '$id'";
        return $this->db->doQuery(  $sql );
    }
}


?>
