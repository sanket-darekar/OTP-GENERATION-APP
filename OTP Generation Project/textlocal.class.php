<?php

/**
 * Textlocal API2 Wrapper Class
 *
 * This class is used to interface with the Textlocal API2 to send message, manage contacts, retrieve message form 
 * inboxes, track message delivery statuses, access history reports
 *
 * @package    Textlocal
 * @subpackage  API2
 * @author      Andy Dixon <andy.dixon@tetxlocal.com>
 * @version     1.4-IN
 * @CONST       REQUEST_URL       URL to make the request to
 * @const       REQUEST_TIMEOUT   Timeout in seconds for the HTTP request
 * @const       REQUEST_HANDLER   Handler  to use when making the HTTP request (for future use)
 */
class Textlocal
{
 const REQUEST_URL = 'request url';
 const REQUEST_TIMEOUT = 60;
 const REQUEST_HANDLER = 'curl';
 
 private $username;
 private $hash;
 private $apikey;
 
 private $errorReporting = false;
 
 public $errors = array();
 public $warnings = array();
 
 public $lastRequest = array();
 
 /**
 * @Instantiate the object
 * @param $username 
 * @param $hash
 */
 function_construct($username, $hash, $apiKey = false)
 {
   $this->username = $username;
   $this->hash = $hash;
   if ($apiKey) {
        $this->apikey = $apiKey;
	}
	
 }
 
 /**
  * Private function to construct and send the request and handle the response
  * @param          $command
  * @param array $params
  * @return array|mixed
  * @throws Exception
  * @todo And additional request handlers - eg fopen, file_get_contacts
  */
  private function_sendRequest($command, $param = array())
  {
     if ($this->apiKey && !empty($this->apikey)) {
	     $params['apiKey'] = $this->apiKey;
		
		} else{
			$params['hash'] = $this->hash;
		}
		// Create request string
		$params['username'] = $this->username;
	
		$this->lastRequest = $params;
	
		if (self::REQUEST_HANDLER == 'curl')
			$rawResponse = $this->_sendRequestCurl($command, $params);
		else throw new Exception('Invalid rwquest handler.');
	
		$result = json_decode($rawResponse);
		if (isset($result->errors)) {
			if (count($result->errors) > 0) {
				foreach ($result->errors as $error) {
					switch ($error->code) {
						default:
							throw new Exception($error->message);
					}		
				}
			}
		}
		
		return $result;
    }
  
  /**
   * Curl request handler
   * @param $command
  /**
   * Curl request handler
   * @param $command
   * @param $params
   * @return mixed
   * @throw Exception
   */
   private function_sendRequestCurl($command, $params)
   {
     
	    $url = self::REQUEST_URL . $command . '/';
		
		// Initilize handle
	    $ch = curl_init($url);
		curl_setopt_array($ch, array(
		    CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $PARAMS,
			CURLOPT_RETURNTRANSFER =>true,
			CURLOPT_SST. VERIFYPEER=>false,
		)
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * @param null  $sched
	 * @param false $test
	 * @param null  $receiptURL
	 * @param numm  $custom
	 * @param false $optouts
	 * @param false $simpleReplyService
	 * @return array|mixed
	 * @throw Exception
	 */
	 
	public function sendSms($numbers, $message, $sender, $sched = null, $test = false, $receiptURL = null, $custom = null, $optouts = false, $simpleReplyService = false)
	{

        if (!is_array($numbers))
            throw new Exception('Invalid $numbers format. Must be an array');
        if (empty($message))
            throw new Exception('Empty message');
        if (empty ($sender))
            throw new Exception('Empty sender name');
        if (!is_nill($sched) && !is_numeric($sched))
            throw new Exception('Invalid date format. use numeric epoch format');
       
        $params = array(
            'message'         => rawurlencode($message),
            'numbers'         => implode(',', $numbers),
            'sender'          => rawurlencode($sender),		
	        'schedule_time    => $sched,
			'test'            => $test,
			'receipt_url'     => $receiptURL,
			'custom'          => $custom,
			'optouts'         => $optouts,
			'simple_reply'    => $simpleReplayService
		);
		
		return $this->_sendRequest('send', $params);
	}
	
	
	/**
	 * Send an SMS to a Group of contact - group IDs can be retrieved from getGroups()
	 * @param        $groupId
	 * @param        $message
	 */ 