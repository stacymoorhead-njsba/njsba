<?php

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

    public $details = array(
        'meeting_id', 
        'meeting_name', 
        'meeting_loc_link', 
        'meeting_start_date', 
        'meeting_end_date', 
        'meeting_add_1', 
        'meeting_add_2', 
        'meeting_add_3', 
        'meeting_city', 
        'meeting_state', 
        'meeting_postal', 
        'meeting_cty_flag',//county flag 
        'meeting_mt_flag', 
        'meeting_code',
        );

}





    //these are specifically the fields not in the object from personify
    $meeting_details_extra = array(
        'made_date',
        'personify_url',
        );

//Change the get_permalink for meetings to get the personify url
function override_meetings_link( $url, $post, $leavename ) {
    if ($post->post_type == 'meetings' && get_field('personify_url')) {
        $url = get_field('personify_url');
    }
    return $url;
}


add_filter( 'post_type_link', __NAMESPACE__ . '\\override_meetings_link', 10, 3 );

//acf fields for evevents
    if( function_exists('acf_add_local_field_group') ):

        $m = new MeetingServices();

        $fields = array_merge($m->details, $meeting_details_extra);

        $group_key = 'MeetingDetails';

        //add acf group
        acf_add_local_field_group(array(
            'key' => $group_key,
            'title' => 'Meeting Details',
            'fields' => array (),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'meetings',
                    ),
                ),
            ),
        ));


        foreach ($fields as $meeting_detail){

            acf_add_local_field(array(
                'key' => $meeting_detail,
                'label' => $meeting_detail,
                'name' => $meeting_detail,
                'type' => 'text',
                'parent' => $group_key,
            ));

        }


    endif;

    function mty_get_object_vars($array,$add_values=""){

        foreach ($array as $key => &$value) {

            if (is_object($value)) {
                $value = get_object_vars($value);
            }

            if(is_array($add_values)){

                foreach ($add_values as $new_key => $new_value) {
                    $value[$new_key] = $new_value;
                }

            }

        }
        return $array;

    }

function meetings_cron(){


    //we're adding all the post ids to this, so we can delete all the other posts
    $post__not_in = array();
    $m =  new MeetingServices();
    $details = $m->details;
    $meetings = $m->getAllMeetings();
    $meetings = mty_get_object_vars($meetings);
    
    $i = 0;


    foreach($meetings as $meeting) {




//meetings_cron - COUNTIES

        $counties = '';

        if(!empty($meeting['meeting_county'])){

            $counties = explode(', ', $meeting['meeting_county']);

            foreach ($counties as &$county) {

                    $county = trim($county);

                    $wp_county = get_page_by_title($county, 'OBJECT', 'counties' );

                    if (!is_object($wp_county)) {
                    //CREATE COUNTY IF ISN'T THERE ALREADY



                        //create the county
                        $post_id = wp_insert_post(
                            array(
                                'post_name'         =>  sanitize_title($county),
                                'post_title'        =>  $county,
                                'post_type'     =>  'counties',
                                'post_status'   => 'publish',

                            )
                        );
                        //SET EVENT CATEGORY ON COUNTYW
                        wp_set_object_terms( $post_id, $county, 'event-categories', false );
                        
                    }//wp_county empty

            }//foreach counties

    }//if $meeting['meeting_county']);


//meetings_cron - MEETINGS



            //create wp_meeting, we're gonna use that to check to see if this meeting exists
                //There "SHOULD" only be one meeting per meeting_id

                $meeting_query = new WP_Query( 
                    array( 
                        'post_type'      => 'meetings', 
                        'posts_per_page' => 1,
                        'meta_key'      => 'meeting_id',
                        'meta_value'    => $meeting['meeting_id'],
                    ));

                $meeting_query = get_object_vars($meeting_query);
                $meeting_query = $meeting_query['posts'];
                $wp_meeting = '';

                if(!empty($meeting_query[0])){
                     $wp_meeting = $meeting_query[0];
                }


            //create page_name
                $post_name = sanitize_title($meeting['meeting_name'].'---'.$meeting['meeting_id']);

            //date to compare things to
                $date = intval(date('U'));

                    $meeting_exists = false;


                // If this meeting exists, check further to see if it's the same meeting
                    if($wp_meeting != null){

                        $wp_meeting_id = get_field('meeting_id',$wp_meeting->ID);
                        $meeting_id = $meeting['meeting_id'];

                        if (intval($wp_meeting_id) == intval($meeting_id)) {
                            $meeting_exists = true;
                        }
                        
                    }//if $wp_meeting

                   


                
           

    // MEETINGS - Is this a new meeting? or is it past it's expiration?

            if ( $meeting_exists == false && intval($meeting['meeting_end_date']) > $date) {

                //MEETING META

                $meeting_meta = array();
                //SET THE REST OF THE ACF FIELDS
                    foreach ($meeting as $key => $value) {
                        if(in_array($key, $details)){

                            //add_post_meta( $post_id, $key, $value );
                            $meeting_meta[$key] = $value;
                        }

                    }//foreach end
                //SET THE LINK TO THE PERSONIFY URL
                    $personify_url = 'https://members.njsba.org/Events/NJSBAEventsCalendar/MeetingDetails.aspx?ProductId=';
                    $meeting_meta['personify_url'] = $personify_url.$meeting['meeting_id'];

                //CREATE MEETING
                    $post_id = wp_insert_post(
                            array(
                                'post_title' => $meeting['meeting_name'],
                                'post_type'     =>  'meetings',
                                'post_status'       => 'publish',
                                'meta_input' => $meeting_meta,
                            )
                        );

                //CREATE MEETING CATEGORIES
                    if( $meeting['meeting_mt_flag'] == 'Y'){
                        $counties[] = 'training';
                        }
                    wp_set_object_terms( $post_id, $counties, 'event-categories', false );




                //ADD POST ID TO $posts_not_in
                    $post__not_in[] = $post_id;




            
    //MEETINGS - this meeting exists, delete it if it's old, update it if it's not.
            }elseif($meeting_exists == 1){

                $endDate = intval(get_field('meeting_end_date', $wp_meeting->ID));

                if($endDate != $meeting['meeting_end_date']){

                    update_post_meta( $wp_meeting->ID, 'meeting_end_date', $meeting['meeting_end_date'] );
                    $endDate = $meeting['meeting_end_date'];

                }//if $endDate end

                if( $endDate < $date){
                  

                    $purge = wp_delete_post($wp_meeting->ID, true);
                   
                }else{
                    
                    //Update values
                    foreach ($meeting as $key => $value) {

            
                        if(in_array($key, $details)){

                            if (get_field($key, $wp_meeting->ID) && get_field($key, $wp_meeting->ID) != $meeting[$key] ) {

                                //make sure this is update and not add_post_meta
                                update_post_meta( $wp_meeting->ID, $key, $value );

                            }// if field exists end
                        }//if in_array end
                    }//foreach end

                }//else end
                
                //ADD POST ID TO $posts_not_in
                $post__not_in[] = $wp_meeting->ID;


            }//elseif $wp_meetings end 

    }//MEETINGS FOREACH END



    $query = new WP_Query( 
    array( 
        'post_type'      => 'meetings', 
        'posts_per_page' => -1,
        'post__not_in'   => $post__not_in,
    ));



    $query = get_object_vars($query);

    foreach ($query['posts'] as $post) {
        wp_delete_post($post->ID,true);
    }


}//meetings_cron end

//add_action('init', 'meetings_cron');

if ( ! wp_next_scheduled( 'personify_meetings' ) ) {
    
    /*
    Options are 

    hourly
    twicedaily
    daily

    */
  wp_schedule_event( time(), 'twicedaily', 'personify_meetings' );
}

add_action( 'personify_meetings', 'meetings_cron' );




