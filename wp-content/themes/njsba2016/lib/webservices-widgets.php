<?php

// Wrapper for Web Services to make simple one line "widgets" to stick on pages.

//require_once('WebServicesLib.php');


class WebServicesWidgets
{
	private $ECOMMERCE_URL;

	private static $MAX_UPCOMING_MEETINGS = 3;

	private static $MAX_UPCOMING_COUNTY_MEETINGS = 3;

	private static $MAX_DIRECT_SERVICES = 5;

	private static $FAIL_MSG = '<p>We are currently updating the meetings list. Please check back at a later time.</p>';

	private static $NO_MEETINGS = '<p>There are currently no upcoming meetings.</p>';

	private static $NO_SERVICES = '<p>There are currently no services.</p>';

	private $ws;

	public function __construct()
	{
		if(WebServicesLib::DEBUG)
		{
			$this->ws = new WebServicesLib(false, true, true);
		}
		else
		{
			$this->ws = new WebServicesLib();
		}

		$this->ws = new WebServicesLib();
		$this->ws->authenticate('apiuser', 'iEJCoDh1SnInW834WV2Oo2XRZhZEHYbm8QNtmaejtGcExoElTt0NKTMXOvTRvr2');

		
		$this->ECOMMERCE_URL = 'https://members.njsba.org/Events/NJSBAEventsCalendar/MeetingDetails.aspx?ProductId=';
#		$this->ECOMMERCE_URL = 'https://members.njsba.org/Default.aspx?TabID=55&amp;ProductId=';
	


	//$this->ECOMMERCE_URL = WebServicesLib::DEBUG ? 'http://membclonus.njsba.org:90/EbusPTEST/OnlineStore/ProductDetail/tabid/55/Default.aspx?ProductId=' : 'https://members.njsba.org/OnlineStore/ProductDetail/tabid/55/Default.aspx?ProductId=';
	}

	/**
	 * Write out a list with up to $MAX_UPCOMING_COUNTY_MEETINGS county meetings with their dates.
	 */
	public function getUpcomingCountyMeetings()
	{
		$output = '';
		$count = 0;

		$meetingDetails = '';
		$meetingTitle = '';
		$meetingURL = '';
		$meetingDate = '';

		$noMeetingsToShow = true;

		try
		{
			$meetings = $this->ws->getAllCountyMeetings();

			if(isset($meetings->Product))
			{
				// Hackity hack hack!
				// If not an array, foreach goes through objects members
				if(!is_array($meetings->Product))
				{
					$meetings->Product = array($meetings->Product);
				}

				$output = '<dl>';
				foreach($meetings->Product as $meeting)
				{
					if($count >= WebServicesWidgets::$MAX_UPCOMING_COUNTY_MEETINGS)
					{
						break;
					}

					$meetingDetails = $this->ws->getMeetingDetails($meeting->productId);

					if($meetingDetails->haseBusiness === true && $meetingDetails->isValidated === true)
					{
						$noMeetingsToShow = false;

						$meetingTitle = $meetingDetails->shortName;
						$meetingURL = $this->ECOMMERCE_URL . $meetingDetails->productId;
						$meetingDate = $meetingDetails->startDate;

						$output .= '<!-- ' . $meetingDetails->productCode . ' | ' . $meeting->productId . ' -->';
						$output .= '<dt><a href="'. $meetingURL . '">' . $meetingTitle . '</a></dt>';
						$output .= '<dd>' . date('F j - g:i A', $meetingDate) . '</dd>';
					}
					elseif($meetingDetails->isValidated === true)
					{
						$noMeetingsToShow = false;

						$meetingTitle = $meetingDetails->shortName;
						$meetingDate = $meetingDetails->startDate;

						$output .= '<!-- ' . $meetingDetails->productCode . ' | ' . $meeting->productId . ' -->';
						$output .= '<dt><strong>' . $meetingTitle . '</strong></dt>';
						$output .= '<dd>' . date('F j - g:i A', $meetingDate) . '</dd>';
					}

					++$count;
				}
				$output .= '</dl>';
			}
			else
			{
				$output = WebServicesWidgets::$NO_MEETINGS;
			}
		}
		catch(Exception $e)
		{
			$output = WebServicesWidgets::$FAIL_MSG;
		}

		if($noMeetingsToShow)
		{
			$output = WebServicesWidgets::$NO_MEETINGS;
		}

		echo($output);
	}

	/**
	 * Write out a list with up to $MAX_UPCOMING_MEETINGS meetings with their dates.
	 */
	public function getUpcomingMeetings($return="")
	{
		$output = '';
		$count = 0;

		$meetingDetails = '';
		$meetingTitle = '';
		$meetingURL = '';
		$meetingDate = '';

		$noMeetingsToShow = true;

		try
		{
			$meetings = $this->ws->getAllMeetings();

			if(isset($meetings->Product))
			{
				// Hackity hack hack!
				// If not an array, foreach goes through objects members
				if(!is_array($meetings->Product))
				{
					$meetings->Product = array($meetings->Product);
				}

				$output = '<dl>';
				foreach($meetings->Product as $meeting)
				{
					if($count >= WebServicesWidgets::$MAX_UPCOMING_MEETINGS)
					{
						break;
					}

					$meetingDetails = $this->ws->getMeetingDetails($meeting->productId);

					if($meetingDetails->haseBusiness === true && $meetingDetails->isValidated === true)
					{
						$noMeetingsToShow = false;

						$meetingTitle = $meetingDetails->shortName;
						$meetingURL = $this->ECOMMERCE_URL . $meetingDetails->productId;
						$meetingDate = $meetingDetails->startDate;

						$output .= '<!-- ' . $meetingDetails->productCode . ' | ' . $meeting->productId . ' -->';
						$output .= '<dt><a href="'. $meetingURL . '">' . $meetingTitle . '</a></dt>';
						$output .= '<dd>' . date('F j - g:i A', $meetingDate) . '</dd>';

						++$count;
					}

				}
				$output .= '</dl>';
			}
			else
			{
				$output = WebServicesWidgets::$NO_MEETINGS;
			}
		}
		catch(Exception $e)
		{
			$output = WebServicesWidgets::$FAIL_MSG;
		}

		if($noMeetingsToShow)
		{
			$output = WebServicesWidgets::$NO_MEETINGS;
		}
                
                if(empty($return)){
                    echo($output);
                }else{
                    return $output;
                }
	}

	/**
	 * Write out a list with all meetings. Those without eBusiness will not be included.
	 */
	public function getAllUpcomingMeetings()
	{
		$output = '';

		$meetingURL = '';

		$noMeetingsToShow = true;

		try
		{
			$meetings = $this->ws->getAllMeetings();

			if(isset($meetings->Product))
			{
				// Hackity hack hack!
				// If not an array, foreach goes through objects members
				if(!is_array($meetings->Product))
				{
					$meetings->Product = array($meetings->Product);
				}

				$output = '<dl class="meetings">';
				foreach($meetings->Product as $meeting)
				{
					$meetingDetails = $this->ws->getMeetingDetails($meeting->productId);

					if(is_object($meetingDetails) && $meetingDetails->isValidated === true && $meetingDetails->haseBusiness === true)
					{
						$meetingURL = $this->ECOMMERCE_URL . $meetingDetails->productId;

						$noMeetingsToShow = false;

						$output .= '<!-- ' . $meetingDetails->productCode . ' | ' . $meeting->productId . ' -->';
						$output .= '<dt class="meeting-title">' . $meetingDetails->shortName . '</dt>';
						$output .= '<dd class="meeting-body"><dl class="meeting-details">';
						$output .= '<dt>Date:</dt>';
						$output .= '<dd>'. date('l, F j, Y', $meetingDetails->startDate) . '</dd>';
						$output .= '<dt>Time:</dt>';
						$output .= '<dd>'. date('g:i A', $meetingDetails->startDate) . '</dd>';
						$output .= '<dd><a href="'. $meetingDetails->addressUrl . '" rel="nofollow">Directions</a></dd>';
						$output .= '<dd><a href="'. $meetingURL . '">Register Now</a></dd>';

						$output .= '</dl></dd>';
					}
				}
				$output .= '</dl>';
			}
			else
			{
				$output = WebServicesWidgets::$NO_MEETINGS;
			}
		}
		catch(Exception $e)
		{
			$output = WebServicesWidgets::$FAIL_MSG;
		}

		if($noMeetingsToShow)
		{
			$output = WebServicesWidgets::$NO_MEETINGS;
		}

		echo($output);
	}

	/**
	 * Write out a list with all county meetings. Those without eBusiness will not have a link.
	 */
	public function getAllUpcomingCountyMeetings()
	{
		$output = '';

		$meetingURL = '';

		$noMeetingsToShow = true;

		try
		{
			$meetings = $this->ws->getAllCountyMeetings();

			if(isset($meetings->Product))
			{
				// Hackity hack hack!
				// If not an array, foreach goes through objects members
				if(!is_array($meetings->Product))
				{
					$meetings->Product = array($meetings->Product);
				}

				$output = '<dl class="meetings">';
				foreach($meetings->Product as $meeting)
				{
					$meetingDetails = $this->ws->getMeetingDetails($meeting->productId);
					$meetingURL = $this->ECOMMERCE_URL . $meetingDetails->productId;

					if($meetingDetails->isValidated === true)
					{
						$noMeetingsToShow = false;

						$output .= '<!-- ' . $meetingDetails->productCode . ' | ' . $meeting->productId . ' -->';
						$output .= '<dt class="meeting-title">' . $meetingDetails->shortName . '</dt>';
						$output .= '<dd class="meeting-body"><dl class="meeting-details">';
						$output .= '<dt>Date:</dt>';
						$output .= '<dd>'. date('l, F j, Y', $meetingDetails->startDate) . '</dd>';
						$output .= '<dt>Time:</dt>';
						$output .= '<dd>'. date('g:i A', $meetingDetails->startDate) . '</dd>';

						if($meetingDetails->haseBusiness === true)
						{
							$output .= '<dd><a href="'. $meetingDetails->addressUrl . '" rel="nofollow">Directions</a></dd>';
							$output .= '<dd><a href="'. $meetingURL . '">Register Now</a></dd>';
						}
						$output .= '</dl></dd>';
					}
				}
				$output .= '</dl>';
			}
			else
			{
				$output = WebServicesWidgets::$NO_MEETINGS;
			}
		}
		catch(Exception $e)
		{
			$output = WebServicesWidgets::$FAIL_MSG;
		}

		if($noMeetingsToShow)
		{
			$output = WebServicesWidgets::$NO_MEETINGS;
		}

		echo($output);
	}

	/**
	 * Get all of the meetings for a county. Those with eBusiness have a link to register.
	 *
	 * @param string $county
	 */
	public function getCountyMeetings($county)
	{
		$output = '';

		$meetingURL = '';

		$noMeetingsToShow = true;

		try
		{
			$meetings = $this->ws->getCountyMeetings($county);

			if(isset($meetings->Product))
			{
				// Hackity hack hack!
				// If not an array, foreach goes through objects members
				if(!is_array($meetings->Product))
				{
					$meetings->Product = array($meetings->Product);
				}

                                $index = 0;
				$output = '<dl class="meetings">';
				foreach($meetings->Product as $meeting)
				{

					$meetingDetails = $this->ws->getMeetingDetails($meeting->productId);
					$meetingURL = $this->ECOMMERCE_URL . $meetingDetails->productId;

                                        
					if($meetingDetails->isValidated === true)
					{
						$noMeetingsToShow = false;
							
						$output .= '<!-- ' . $meetingDetails->productCode . ' | ' . $meeting->productId . ' -->';
						$output .= '<dt class="meeting-title">' . $meetingDetails->shortName . '</dt>';
						$output .= '<dd class="meeting-body"><dl class="meeting-details">';
						$output .= '<dt>Date:</dt>';
						$output .= '<dd>'. date('l, F j, Y', $meetingDetails->startDate) . '</dd>';
						$output .= '<dt>Time:</dt>';
						$output .= '<dd>'. date('g:i A', $meetingDetails->startDate) . '</dd>';

						if($meetingDetails->haseBusiness === true)
						{
							$output .= '<dd><a href="'. $meetingDetails->addressUrl . '" rel="nofollow">Directions</a></dd>';
							$output .= '<dd><a href="'. $meetingURL . '">Register Now</a></dd>';
                                                        
						}
                                                
                                                if ($index < 1) 
                                                {
                                                    $output .= '<dd>'.$meetingDetails->eBusinessShortDescription.'</dd>';
                                                    $index++;
                                                }    
                                                
						$output .= '</dl></dd>';
					}
				}
				$output .= '</dl>';
			}
			else
			{
				$output = WebServicesWidgets::$NO_MEETINGS;
			}
		}
		catch(Exception $e)
		{
			$output = WebServicesWidgets::$FAIL_MSG;
		}

		if($noMeetingsToShow)
		{
			$output = WebServicesWidgets::$NO_MEETINGS;
		}

		echo($output);
	}

	/**
	 * Write out a table with up to $MAX_DIRECT_SERVICES direct services.
	 */
	public function getDirectServices()
	{
		$output = '';

		try
		{
			$services = $this->ws->getDirectServices();

			// Hackity hack hack!

			if(!isset($services->DirectService))
			{
				echo(WebServicesWidgets::$NO_SERVICES);

				return;
			}

			// If not an array, foreach goes through objects members
			if(!is_array($services->DirectService))
			{
				$services->DirectService = array($services->DirectService);
			}

			$output .= '<table id="services-direct-services-summary" class="services-direct-services"><tbody>';
			$output .= '
                            <tr class="head" style="color: #003366">
                                <td>Date</td>
                                <td style="text-transform: none !important;">
                                    Board of Education
                                </td><td>Department</td>
                            </tr>';

			$count = 0;
			foreach($services->DirectService as $directService)
			{
				$board = $directService->board;

				//more mess
				if(strlen($board) > 25)
				{
					$board = substr($board, 0, 25) . '...';
				}

				if($count >= WebServicesWidgets::$MAX_DIRECT_SERVICES)
				{
					break;
				}

				if($count & 1)
				{
					//odd
					$output .= '<tr class="odd">';
				}
				else
				{
					//even
					$output .= '<tr class="even">';
				}

				$output .= '<td>' . date('n/j', $directService->date) . '</td>';
				$output .= '<td>' . $board . '</td>';
				
				switch($directService->department)
				{
					case "Field Services":
						{
							$output .= '<td><a href="/resources/field-services/">' . $directService->department . '</a></td>';

							break;
						}
					case "Labor Relations":
						{
							$output .= '<td><a href="/resources/labor-relations/">' . $directService->department . '</a></td>';

							break;
						}
					default:
						{
							$output .= '<td>' . $directService->department . '</td>';

							break;
						}
				}

				$output .= '</tr>';

				++$count;
			}

			$output .= '</tbody></table>';
		}
		catch(Exception $e)
		{
			$output = WebServicesWidgets::$FAIL_MSG;
		}

		echo($output);
	}

	/**
	 * Write out a table with all the direct services.
	 */
	public function getAllDirectServices()
	{
		$output = '';

		try
		{
			$services = $this->ws->getDirectServices();

			// Hackity hack hack!

			if(!isset($services->DirectService))
			{
				echo(WebServicesWidgets::$NO_SERVICES);

				return;
			}

			// If not an array, foreach goes through objects members
			if(!is_array($services->DirectService))
			{
				$services->DirectService = array($services->DirectService);
			}

			$output .= '<table id="services-direct-services-all" class="services-direct-services"><tbody>';
			$output .= '<tr class="head"><td>Date</td><td style="text-transform: none !important;">Board of Education</td><td>Department</td></tr>';

			$count = 0;
			foreach($services->DirectService as $directService)
			{
				if($count & 1)
				{
					//odd
					$output .= '<tr class="odd">';
				}
				else
				{
					//even
					$output .= '<tr class="even">';
				}

				$output .= '<td>' . date('n/j', $directService->date) . '</td>';
				$output .= '<td>' . $directService->board . '</td>';
				
				switch($directService->department)
				{
					case "Field Services":
						{
							$output .= '<td><a href="/resources/field-services/">' . $directService->department . '</a></td>';

							break;
						}
					case "Labor Relations":
						{
							$output .= '<td><a href="/resources/labor-relations/">' . $directService->department . '</a></td>';

							break;
						}
					default:
						{
							$output .= '<td>' . $directService->department . '</td>';

							break;
						}
				}

				$output .= '</tr>';

				++$count;
			}

			$output .= '</tbody></table>';
		}
		catch(Exception $e)
		{
			$output = WebServicesWidgets::$FAIL_MSG;
		}

		echo($output);
	}
        
        /**
	 * Return all mandated training in an object
         * Those without eBusiness will not be included.
	 */
	public function getAllMandatedTraining()
	{
            $output = '';

            $meetingURL = '';

            $noMeetingsToShow = true;
            
            $returnMeetings = array();
            
            try
            {
                $meetings = $this->ws->getAllMeetings();

                if(isset($meetings->Product))
                {
                        // If not an array, foreach goes through objects members
                        if(!is_array($meetings->Product))
                        {
                            $meetings->Product = array($meetings->Product);
                        }

                        foreach($meetings->Product as $meeting)
                        {
                            $meetingDetails = $this->ws->getMeetingDetails($meeting->productId);

                            if(is_object($meetingDetails) && $meetingDetails->isValidated === true && $meetingDetails->haseBusiness === true)
                            {
                                $meetingURL = $this->ECOMMERCE_URL . $meetingDetails->productId;

                                $noMeetingsToShow = false;
                                
                                if(stripos($meetingDetails->shortName, "govern") > -1){
                                    array_push($returnMeetings, $meetingDetails);
                                }
                            }
                        }
                }
                else
                {
                        $output = WebServicesWidgets::$NO_MEETINGS;
                        return $output;
                }
            }
            catch(Exception $e)
            {
                    $output = WebServicesWidgets::$FAIL_MSG;
                    return $output;
            }

            if($noMeetingsToShow)
            {
                    $output = WebServicesWidgets::$NO_MEETINGS;
                    return $output;
            }

            return $returnMeetings;
	}

}

$WebServicesWidgets = new WebServicesWidgets();

//$WebServicesWidgets->getAllUpcomingMeetings();

?>
