<?php
if (!class_exists('WSW_LSI')) {
	class WSW_LSI
	{
		/**
		 * Get the LSI suggestions
		 * @param 	string 	$keyword
		 * @param 	bool 	$testing	true when we are testing, so no from database and don't store result
		 * @param	string	$use_this_test_key
		 * 
		 * @return	array	each element is a keyword returned
		 */
		static function get_lsi_by_keyword($keyword,$use_this_test_key='') {
			$to_return = array();
			
			// Avoid add the keyword twice
			$already_added = array();
			
			// Before get,compare,search replace the follow
			$keyword = str_replace("\'","'", $keyword);
				// Make the request to the service

				$settings = WSW_Main::$settings;
                $accountKey = $settings['lsi_bing_api_key'];
                if(trim($accountKey =='')) $accountKey ='LHt17J/oQUpn0Qd/X32W33eKeNv4s3VqZN/owgh4iLY=';

				if ($accountKey!='') {
					$language = 'en-US';
					
					$ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/';
					$WebSearchURL = $ServiceRootURL . 'RelatedSearch?$format=json&Query=';
					$request = $WebSearchURL . urlencode( "'$keyword'");

					if ($language!='') {
						$request .= '&Market=' . urlencode( "'$language'");
					}
					
					if (function_exists('curl_version')) {
						$process = curl_init($request);
						curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
						curl_setopt($process, CURLOPT_USERPWD,  $accountKey . ":" . $accountKey);
						curl_setopt($process, CURLOPT_TIMEOUT, 30);
						curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
						
						@curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
						@curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
						
						$response = @curl_exec($process);
						if (!$response) {
							// Is null, so return the error message
							$response_error = curl_error($process);
						}
					}

					if (!function_exists('curl_version') || !$response) {
						$context = stream_context_create(
								array('http' => array(
										//'proxy' => 'tcp://127.0.0.1:8888',
										'request_fulluri' => true,
										'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
								)
								)
						);
						$response = @file_get_contents($request, 0, $context);
					}
					
					if ($response) {
						$jsonobj = json_decode($response);
						if (is_array($jsonobj->d->results)) {
							foreach($jsonobj->d->results as $value) {
								if (!in_array($value->Title, $already_added)) {
									$already_added[] = $value->Title;
									
									$to_return[] = array('lsi'=>$value->Title,'BingUrl'=>$value->BingUrl);
								}
							}
						}
					}
					else {
						// Store in log that the keyword is invalid
						$code = '311';
						$msg = "Fail getting LSI keywords for Key: $keyword and Bing API Key: $accountKey Check that the Bing API Key is correct. Return: " . $response_error;
					}
				}

			
			return $to_return;
		}
	}
}
