<?php 
session_start();

include('njsba_functions/Customer.php');
include('njsba_functions/Members.php');
include('njsba_functions/GO_functions.php');

ini_set("error_log", "/var/log/php_errors.log");
ini_set('display_errors', 0);
ini_set("soap.wsdl_cache_enabled", "0");

$key = '03526052-9662-447b-97b9-eed2f58e7c1b';
$secret = '6b2d6dc641544e9ebac5d69ad7a25a25';

$today = date("Y-m-d");
$init = array("/Mr/i","/jr/i","/phd/i","/Mrs/i","/Ms/i","/dr/i", "/\./");

# We do not make any changes on this cookie but delete at the end. We only get the master_customer_id and the password.
$query = $_COOKIE["NJSBACookie"];

# If user logs in get their Master Customer ID.
preg_match("/MasterCustomerID=(\d+)\&/", $query, $matches );
$master_customer_id = $matches[1];
//error_log("$today: $master_customer_id \n",3, 'log/php-errors.log');

#1. First we check that the master_customer_id exist. If not send back to login page
if( !$master_customer_id ) {
    header("Location: https://members.njsba.org/Default.aspx?TabId=71&returnurl=http%3A%2F%2Fwww.njsba.org%2Fgrantsoffice.php");
    //header("Location: http://personify752webtest.njsba.org/default.aspx?tabid=71&returnurl=http%3A%2F%2Fwww.njsba.org%2Fgrants-office%2Fgrantsoffice.php");
    exit();
}

#If logged in move on.
#2. Start the needed variables.
$value = "";
$token = "";
$userkey = "";
$email = "";
$password = '';
$firstname = "";
$lastname = "";
$autolink = "";
$test = "false";

#3. Retrieve the master_customer_id and password
if(!$password) {
    preg_match("/Password=(.*)==\&/", $query, $pword );
    $password = $pword[1];
}

#4. Authenticate to get the token
// The GetAuth function recieves a json with the Token and an auto-response (OK or Error)
$authenticate = GetAuthKey( $secret );

#5. Use the authentication to obtain the Token
$getToken = json_decode(GetAuth( $key, $authenticate));
$token = $getToken->Token;

$list_url = 'http://upstream.grantsoffice.com/desktopmodules/grantsoffice/grantsoffice/api/User/List?key=' . $key . '&token=' . $token;

//This number is the number of pages for the JOSN in the list
$list_contents = json_decode(file_get_contents($list_url), true);
$number_of_pages = 1;

#####################################################################
#                                                                   #
#      THERE ARE TWO DATABASES(DB) USED FOR THE AUTHENTICATION      #
#                                                                   #
# 1. THE 1st DB IS THE GO DB. THE FUNCTION isGOMember WILL CHECK IF #
#    THE MEMBER IS RECORDED IN THIER DB.                            #
#                                                                   #
# 2. THE 2nd DB IS IN OUR SQL DB. THE FUNCTION IsMemberRecorded     #
#    WILL CHECK IF THE MEMBER IS RECORDED IN OUR DB.                #
#                                                                   #
#####################################################################

// IN THEIR DB
$isMemberSubscribed = isGOMember ( $key, $token, $master_customer_id );

// IN OUR DB
$isMemberRecorded = IsMemberRecorded($master_customer_id);

# 6. Now there are three options:
#    a. The member is in their DB and our DB
#    b. The member is in their DB but not in our DB
#    c. The member is not in their DB nor in our DB

if ($isMemberSubscribed) { 
#    a. The member is in their DB and our DB
    if ($isMemberRecorded) { 
        LogMemberLogin( $master_customer_id );
        $member = json_decode(GetGoUserInformation($master_customer_id)->GetGoUserInfoResult);
        $userkey = $member->Userkey;
        $autolink = GetAutoLoginLink($key, $secret, $userkey);
        error_log("$today: Autolink $autolink \n",3, 'log/php-errors.log');
        header('Location: ' . $autolink, true);
        die();
    }

#   b. The member is in their DB but not in our DB
    if (!$isMemberRecorded) {
        $check_email = json_decode(GetBasicUserInfo($master_customer_id)->GetBasicUserInfoResult)->Email;
        for ($i = 0; $i <= $number_of_pages; $i++) {
            $read_obj = json_decode(file_get_contents($list_url . '&pageIndex=' . $i), true);
            for ($j = 0; $j < 200; $j++) {
                if ($read_obj['Users'][$j]['Email'] == $check_email) {
                    $userkey = $read_obj['Users'][$j]['UserKey'];
                    $firstname = $read_obj['Users'][$j]['FirstName'];
                    $lastname = $read_obj['Users'][$j]['LastName'];
                    $email = $read_obj['Users'][$j]['Email'];
                }
            }
        }
        $autolink = GetAutoLoginLink($key, $secret, $userkey);
        error_log("$today: Autolink $autolink \n",3, 'log/php-errors.log');
        SaveMemberInfo( $master_customer_id,  $authenticate,  $userkey,  $token,  $autolink,  $email,  $firstname,  $lastname,  $password,  $today);
        LogMemberLogin( $master_customer_id );
        header('Location: ' . $autolink, true);
        die();
    }
}

#    c. The member is not in their DB nor in our DB
if (!$isMemberSubscribed) { 
    if (!$isMemberRecorded) {
        //USE THE GetBasicUserInfo WEBSERVICE TO OBTAIN BASIC INFO
        $json = GetBasicUserInfo( $master_customer_id );

        $nonRecordedMember = json_decode($json->GetBasicUserInfoResult);

        $email = $nonRecordedMember->Email;
        $firstname = $nonRecordedMember->FirstName;
        $lastname = $nonRecordedMember->LastName;

        $create_url = "http://upstream.grantsoffice.com/desktopmodules/grantsoffice/grantsoffice/api/User/Create";
        $create_array = array('Key' => $key, 'Token' => $token, 'Test' => $test, 'Email' => $email, 'FirstName' => $firstname, 'LastName' => $lastname, 'Password' => $password);
        $create_content = json_encode($create_array);

        $create_curl = curl_init($create_url);
        curl_setopt($create_curl, CURLOPT_HEADER, false);
        curl_setopt($create_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($create_curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($create_curl, CURLOPT_POST, true);
        curl_setopt($create_curl, CURLOPT_POSTFIELDS, $create_content);

        $json_response = curl_exec($create_curl);
        $status = curl_getinfo($create_curl, CURLINFO_HTTP_CODE);
        curl_close($create_curl);
        $create_response = json_decode($json_response);

        $Message = $create_response->Message;

        if ($Message == 'User successfully created!') {
            $userkey = $create_response->UserKey;
            $autolink = GetAutoLoginLink($key, $secret, $userkey);
            SaveMemberInfo( $master_customer_id,  $authenticate,  $userkey,  $token,  $autolink,  $email,  $firstname,  $lastname,  $password,  $today);
            echo '<p>Link:  <a href="' . $autolink . '" target="_blank">' . $autolink . '</a></p>';

            error_log("$today: $master_customer_id logged in to GO office\nand a new entry has been added to GO DB and NJSBA DB\n",3, 'log/php-errors.log');
            header("Location: $autolink");
            LogMemberLogin( $master_customer_id );
        }
        else {
            header("Location: http%3A%2F%2Fwww.njsba.org%2Fgrantsoffice.php");
        }            
    }
}
?>
