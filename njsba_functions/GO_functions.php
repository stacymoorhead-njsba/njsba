<?php

function GetAuthKey( $s) {

    $authkey_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'secret' => $s 
        ),
    );
    
    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl", array('trace' => 1));
    
    $authkey_response = $client->__soapCall("GetAuthenticationKey", $authkey_options );

    $response = $client->__getLastResponse();
    
    preg_match("/HTTP\/1.1 (\d+)/", $response, $matches );
    
    return  $authkey_response->GetAuthenticationKeyResult;
    
}

function GetAuth( $k, $v) {

    $authenticate_options = array(  
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'key' => $k,
            'value' => $v 
        )
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");
    $authenticate_response = $client->__soapCall("Authenticate", $authenticate_options );

   # error_log( print_r($authenticate_response), 0 );	

    $t = $authenticate_response->AuthenticateResult; 

    return  $t;

}

function CreateUserAccount( $k, $t, $e, $tst, $fn, $ln,$p ) {
    
    $createuser_options = array(  
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'key' => $k,
            'token' => $t,
            'email' => $e,
            'test' => $tst,
            'firstname' => $fn,
            'lastname' => $ln,
            'password' => $p
        )
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");
    $createuser_response = $client->__soapCall("CreateUser", $createuser_options );

    $response = $client->__getLastResponse();
    
    $uk = $createuser_response->CreateUserResult;

    return $uk;
}

function GetAutoLoginLink($k, $s, $u ) {
        $autologinlink_options = array(  
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'key' => $k,
                'secret' => $s,
                'userkey' => $u
            )
        );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $autologinlink_response = $client->__soapCall("GetAutoLoginLink", $autologinlink_options );

    //error_log( var_dump($autologinlink_response), 0 );
    
    $link = $autologinlink_response->GetAutoLoginLinkResult;

    return $link;

}

function DisableUser( $k, $t, $uk, $tst ) {
    $disableuser_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'key' => $k,
            'token' => $t,
            'userKey' => $uk,
            'test' => $tst 
        ),
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $disable_response = $client->__soapCall("DisableUser", $disableuser_options );
  
    //error_log( var_dump($disable_response), 0 );
 
    $response = $client->__getLastResponseHeaders();

    //error_log( var_dump($response), 0 );

    $res = $disable_response->DisableUserResult;

    return $res;

    
}

function GetGoUserInformation( $mci ) {
    $getuserinfo_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $mci  
        ),
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $getuserinfo_response = $client->__soapCall("GetGoUserInfo", $getuserinfo_options );
    #var_dump( $getuserinfo_response, 0 );

    return $getuserinfo_response;
    
}

function GetBasicUserInfo( $mci ) {
    $getbasicuserinfo_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $mci  
        ),
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $getbasicuserinfo_response = $client->__soapCall("GetBasicUserInfo", $getbasicuserinfo_options );

    return $getbasicuserinfo_response;
    
}

function IsLinkValid( $link ) {
    $link_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'link' => $link
            ),
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $link_response = $client->__soapCall("IsLinkStillValid", $link_options );
  
    
 
    $response = $client->__getLastResponseHeaders();

    error_log( "IsLinkValid RESPONSE ".$response, 0, '/var/log/php-errors.log' );
    
    $res = $link_response->IsLinkStillValidResult;

    return $res;
}

function IsMemberSubscribed( $mci ) {
    $member_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $mci
            ),
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
 #   var_dump($client->__getFunctions());
    $member_response = $client->__soapCall("IsMemberSubscribed", $member_options );
  
  //  $response = $client->__getLastResponseHeaders();

    return $member_response->IsMemberSubscribedResult;
}

function IsMemberRecorded( $mci ) {
    $member_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $mci
            ),
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $member_response = $client->__soapCall("IsMemberRecorded", $member_options );
  
    $response = $client->__getLastResponseHeaders();

    return $member_response->IsMemberRecordedResult;
}

function SaveMemberInfo( $master_customer_id,  $value,  $userkey,  $token,  $autologinlink,  $email,  $firstname,  $lastname,  $password,  $date_created) {

    $savememberinfo_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $master_customer_id,
            'value' => $value,
            'userkey' => $userkey,
            'token' => $token,
            'autologinlink' => $autologinlink,
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'password' => $password,
            'date_created' => $date_created
            ),
    );
    
    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $savememberinfo_response = $client->__soapCall("SaveMemberInfo", $savememberinfo_options );

    return $savememberinfo_response;
}

function UpdateMemberInfo( $master_customer_id,  $value,  $userkey,  $token,  $autologinlink,  $email ) {

    $updatememberinfo_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $master_customer_id,
            'value' => $value,
            'userkey' => $userkey,
            'token' => $token,
            'autologinlink' => $autologinlink,
            'email' => $email
            
            ),
    );
    
    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $updatememberinfo_response = $client->__soapCall("UpdateMemberInfo", $updatememberinfo_options );

    return $updatememberinfo_response;
}

function IsMemberLogged( $master_customer_id  ) {

    $ismemberlogged_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $master_customer_id
            ),
    );
    
    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $ismemberlogged_response = $client->__soapCall("IsMemberLogged", $ismemberlogged_options );
   
    return $ismemberlogged_response->IsMemberLoggedResult;

}

/*
function IsMemberSubscribed( $master_customer_id )
{
    $ismembersubscribed_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $master_customer_id
            ),
    );
    
    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $ismembersubscribed_response = $client->__soapCall("IsMemberSubscribed", $IsMemberLogged_options );
   
    return $ismembersubscribed_response->IsMemberSubscribedResult;
    
    
}*/

function LogMemberLogin( $master_customer_id ) {

    $logmemberinformation_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'master_customer_id' => $master_customer_id
            ),
    );
    
    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");    
    $logmemberinformation_response = $client->__soapCall("LogMemberInformation", $logmemberinformation_options );
}

function GetGoAccountList( $key, $token ) {

    $goal_options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'GET',
            'key' => $key,
	    'token' => $token	
            ),
    );

    $client = new SoapClient("http://ws.njsba.org/Go/WebService.asmx?wsdl");
    $goal_response = $client->__soapCall("GetAccountList", $goal_options );
    return $goal_response;	
}

function isGOMember ( $key, $token, $master_customer_id ) {
    
    $list_url = 'http://upstream.grantsoffice.com/desktopmodules/grantsoffice/grantsoffice/api/User/List?key=' . $key . '&token=' . $token;
    $number_of_pages = 1;
    $json = GetBasicUserInfo( $master_customer_id );
    $member = json_decode($json->GetBasicUserInfoResult);
    $check_email = $member->Email;
    
    for ($i = 0; $i <= $number_of_pages; $i++) {
        $check_url = $list_url . '&pageIndex=' . $i;
        $read_obj = json_decode(file_get_contents($check_url), true);
        for ($j = 0; $j < 200; $j++) {
            if ($read_obj['Users'][$j]['Email'] == $check_email) {
                $result = true;
            }
        }
    }    
    return $result;
}

function enableGOMember ($key, $token, $test, $userkey) {
    $enable_url = "http://upstream.grantsoffice.com/desktopmodules/grantsoffice/grantsoffice/api/User/Enable";
    $enable_array = array('Key' => $key, 'Token' => $token, 'Test' => $test, 'UserKey' => $userkey);
    $enable_content = json_encode($enable_array);

    $enable_curl = curl_init($enable_url);
    curl_setopt($enable_curl, CURLOPT_HEADER, false);
    curl_setopt($enable_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($enable_curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
    curl_setopt($enable_curl, CURLOPT_POST, true);
    curl_setopt($enable_curl, CURLOPT_POSTFIELDS, $enable_content);

    $json_response = curl_exec($enable_curl);
    $status = curl_getinfo($enable_curl, CURLINFO_HTTP_CODE);
    curl_close($enable_curl);
    $enable_response = json_decode($json_response);

    $Message = $enable_response->Message;

    return $Message;
}

function disableGOMember ($key, $token, $test, $userkey) {
    $disable_url = "http://upstream.grantsoffice.com/desktopmodules/grantsoffice/grantsoffice/api/User/Disable";
    $disable_array = array('Key' => $key, 'Token' => $token, 'Test' => $test, 'UserKey' => $userkey);
    $disable_content = json_encode($disable_array);

    $disable_curl = curl_init($disable_url);
    curl_setopt($disable_curl, CURLOPT_HEADER, false);
    curl_setopt($disable_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($disable_curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
    curl_setopt($disable_curl, CURLOPT_POST, true);
    curl_setopt($disable_curl, CURLOPT_POSTFIELDS, $disable_content);

    $json_response = curl_exec($disable_curl);
    $status = curl_getinfo($disable_curl, CURLINFO_HTTP_CODE);
    curl_close($disable_curl);
    $disable_response = json_decode($json_response);

    $Message = $disable_response->Message;

    return $Message;
}
?>
