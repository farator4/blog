<?php
/*
if (!class_exists('Zend_Loader')) {
	require_once WPPostsRateKeys::$plugin_dir . 'classes/YoutubeWordpress/Zend/Loader.php';
}
Zend_Loader::loadClass ( 'Zend_Gdata_Query' );
Zend_Loader::loadClass ( 'Zend_Gdata_YouTube' );
*/
if (!class_exists('Youtube_Interface')) {
	class Youtube_Interface {
		/*
		 * @var $userName string The Youtube username.
		 */
		private $keyword;
		
		/**
		 * The keyword
		 *
		 * @param string	$keyword       	
		 */
		public function __construct($keyword) {
			$this->keyword = $keyword;
		}
		
		/**
		 * Retrieve user's uploaded videos.
		 *
		 * @param $maxResults int
		 *       	 Maximum number of YoutubeVideo to return.
		 * @return array(YoutubeVideo) Videos retrieved.
		 */
		public function getVideos($maxResults) {
			try {
                set_include_path(get_include_path() . PATH_SEPARATOR . dirname(WSW_Main::$plugin_dir) . '/lib/Youtube');

				if (!class_exists('Zend_Loader')) {
					require_once 'Zend/Loader.php';
				}

				Zend_Loader::loadClass ( 'Zend_Gdata_Query' );
				Zend_Loader::loadClass ( 'Zend_Gdata_YouTube' );
				// If the keyword is compoused, divide each word
				$key_phrase = $this->keyword;
				$key_phrase_arr = explode(' ', $key_phrase);
				
				$query_url = Zend_Gdata_YouTube::VIDEO_URI . "/-/";
				foreach ($key_phrase_arr as $key_phrase_item) {
					if (trim($key_phrase_item)!='') {
						$query_url .= trim($key_phrase_item) . '/';
					}
				}
				//$query_url .= '?v=2';

				$query = new Zend_Gdata_Query ( $query_url );
				$query->setMaxResults ( $maxResults );
				$query->setParam ( 'orderby', 'viewCount' );
				
				$yt = new Zend_Gdata_YouTube ();
				$yt->setMajorProtocolVersion ( 2 );
				
				$videoFeed = $yt->getFeed ( $query, 'Zend_Gdata_YouTube_VideoFeed' );
				// TODO See how this initialization must be done, I mean if is really neccesary
				$keyVideos = array ();
				foreach ( $videoFeed as $videoEntry ) {
					$keyVideos [] = new WSW_YoutubeVideo ( $videoEntry );
				}
				return $keyVideos;
			} catch (Exception $e) {
				// Store to log
				$msg_to_log = 'Error while getVideos from Youtube, Url: ' . $query_url
	   									. ', Exception Msg: ' . $e->getMessage();
		        return array();
			}
		}
	}
}