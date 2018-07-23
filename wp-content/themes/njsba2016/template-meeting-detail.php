<?php
/**
 * Template Name: Meeting Detail
 *
 */


?>

	<div style="padding-left: 50px;padding-right:80px;padding-top:20px;padding-bottom:50px; background-color: white;color:black;text-align:justify">
		<?php
	
	     require_once ABSPATH . '/wp-content/plugins/njsba-plugin/personify-event_integration/personify-cron_job.php';
	     // $m =  new MeetingServices();
          //$details = $m->details;
       //  $meetings = $m->getAllMeetings();
       // $meetings1 = mty_get_object_vars($meetings);
        
          $productid = $_GET['ProductId'];
          
		 $url = 'https://ws.njsba.org/njsba/meetingDetail/svc/Service/Info?ProductId=' .$productid ;
            
           $request = wp_remote_get( $url);
            
            if(is_wp_error($request)) {
            return false;
            }
            				
            $body = wp_remote_retrieve_body($request);
            
            $data = json_decode($body);
            //echo '<color="black">';
           // echo '<pre>';
            // print_r($_GET['ProductId']);
            // print_r($productid);
            //print_r( $post['personify_url']);
            //print_r($details);
           // print_r($data);
            //print_r($meetings);
           // print_r($meetings1);
            echo '</pre>';
            if(!empty($data)) {

			//	echo '<ul>';
				foreach( $data as $response ) { 
//

                      //   echo  '<br></br>';
						echo  '<h3>'.$response->shortName.'</h3>';
					//	echo '	<div style="width:20%;">';
					//	 echo '<img  src="https://ws.njsba.org/njsba/Order/' .$response->featuredImage. '"'  ; 
					//	 echo '</div>';
					//	echo '<p><b>Meeting Name:</b>  ' .$response->longName. '</p>';
					    if($response->description !== '')
					 echo '<p><b>Description:</b>  ' .strip_tags($response->description). '</p>';
						echo '<p><b>Meeting Date:</b>  ' .$response->meetingDate .'</p>';
						echo '<p><b>Meeting Time:</b>  ' .$response->meetingTime .'</p>';
						if($response->meetingCounty !== '')
						echo '<p><b>County:</b>  ' .$response->meetingCounty .'</p>'; 
						echo '<p><b>Where:</b>  ' .$response->facility;'</p>'; 
						echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$response->facilityAddress .'</p>'; 
					    echo '<p><b>Location:</b>  <a href="' .$response->userAddressLink .'"><i class="fa fa-map-marker"></i></a></p>';
					//	if($productid=='21602532')
					//	 	echo '<a class="btn btn--small" href="https://www.njsba.org/about/governance/delegate-assembly/delegate-assembly-registration/">Register</a>';
					//	else
						if($response->isRegFull)
					    echo '<b><font color="red">Registration is currently full.</font></b><p></p><p> Wait list is available by contacting our Call Center at <a href="mailto:callcenter@njsba.org.com">callcenter@njsba.org</a>.</p>';
					    else
					    		if($productid=='24665867')
						 	echo '<a class="btn btn--small" href="https://www.njsba.org/about/governance/delegate-assembly/delegate-assembly-registration/" target="_blank">Register</a>';
						 	elseif($productid=='24665731')
						 	continue;
						 	elseif($productid=='22099309')
						 	echo '<a class="btn btn--small" href="https://www.eventbrite.com/e/are-you-future-ready-101-an-introductory-working-session-tickets-36306997206" target="_blank">Register</a>';
						 	elseif($productid=='22099319')
						 	echo '<a class="btn btn--small" href="https://www.eventbrite.com/e/best-practices-of-successful-education-foundations-tickets-44923116250" target="_blank">Register</a>';
						 	else
						echo '<a class="btn btn--small" href="https://ws.njsba.org/njsba/Order/?ProductId=' .$productid. '">Register</a>';
						//echo '<a class="btn btn--small" href="https://ws.njsba.org/njsba/Order/?ProductId=' .$productid. '">Register</a>';
//					echo '</li>';
				}
//				echo '</ul>';
 
			}	
		?>        
	</div>
<?php



?>