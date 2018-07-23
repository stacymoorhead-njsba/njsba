<?php

// while(true){
//     //to infinity and beyond...
// }

class MeetingServices {

    private $wsdl = 'https://ws.njsba.org/GetNewEvents/newMeetings.asmx?wsdl';
    private $client;
    const VERSION = '1.0';

    public function __construct() {
        try {
             $options = array(  'soap_version' => SOAP_1_2,
                                'trace'        => true,
                                'exceptions'   => true,
                                'cache_wsdl'   => 'NONE',
                                'encoding'     => 'UTF-8',
                                'user_agent'   => 'NJSBA MeetingServices ' . MeetingServices::VERSION
                     );

            $this->client = new SoapClient($this->wsdl, $options);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        catch (SoapFault $e) {
            echo $e->getMessage();
        }
    }

    public function getAllMeetings()
    {
        $options = array(
            'http' => array(
                'header'  => 'Content-type: application/json\r\n',
                'method'  => 'GET'
            )
        );

        $response = $this->client->__soapCall("meetings", $options );

        $array  = json_decode($response->meetingsResult);

        return $array;
    }
}

$MeetingServices = new MeetingServices();
$meetings = $MeetingServices->getAllMeetings();


foreach ($meetings as $meeting) {

        if(!empty($meeting->meeting_county)){

            echo '--|'.$meeting->meeting_county.'|--
    ';

            $counties = explode(', ', $meeting->meeting_county);
            
            foreach ($counties as &$county) {
               
                $county = trim($county);

            }

            print_r($counties);

        }

}
