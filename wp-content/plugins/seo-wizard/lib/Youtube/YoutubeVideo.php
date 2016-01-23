<?php
/*
if (!class_exists('Zend_Loader')) {
	require_once WPPostsRateKeys::$plugin_dir . 'classes/YoutubeWordpress/Zend/Loader.php';
}
Zend_Loader::loadClass ( 'Zend_Gdata_YouTube_VideoEntry' );
Zend_Loader::loadClass ( 'Zend_Gdata_Query' );
Zend_Loader::loadClass ( 'Zend_Gdata_YouTube' );
*/
class WSW_YoutubeVideo {
	/*
	 * @var $videoEntry Zend_Gdata_YouTube_VideoEntry.
	 */
	public $videoEntry;
	
	/*
	 * @var $title string The title of the video as a string.
	 */
	public $title;
	
	/*
	 * @var $description string The description of the video as a string.
	 */
	public $description;
	
	/*
	 * @var $tags array(string) An array of the tags assigned to this video.
	 */
	public $tags;
	
	/*
	 * @var $publishedDate Zend_Gdata_App_Extension_Published This represents
	 * the publishing date for an entry.
	 */
	public $publishedDate;
	
	/*
	 * @var $id Zend_Gdata_App_Extension_Id The YouTube video ID based upon the
	 * atom:id value.
	 */
	public $id;
	
	/**
	 * Initializator constructor.
	 *
	 * @param $videoEntry Zend_Gdata_YouTube_VideoEntry
	 *       	 Zend_Gdata_YouTube_VideoEntry behind this Youtube video.
	 */
	public function __construct($videoEntry) {
		$this->videoEntry = $videoEntry;
		$this->title = $videoEntry->getVideoTitle ();
		$this->description = $videoEntry->getVideoDescription ();
		$this->tags = $videoEntry->getVideoTags ();
		$this->publishedDate = $videoEntry->getPublished ();
		$this->id = $videoEntry->getVideoId ();
	}
	
	/**
	 * Return the Thumbnail
	 *
	 */
	public function getThumbnail() {
		$video_id = $this->id;
		
		return "http://img.youtube.com/vi/$video_id/0.jpg"; // This is the big mage
		// return "http://img.youtube.com/vi/$video_id/1.jpg"; // This is the small thumbnail
	}
	
	/**
	 * Return the HTML code needed to display this YouTube video on a web page.
	 *
	 * @param $width int
	 *       	 Video's width on the web page.
	 * @param $height int
	 *       	 Video's height on the web page.
	 */
	public function getCodeToDisplayVideo($width, $height) {
		// XXX return <<<"EOT"
		return <<<EOT

<object width="$width" height="$height">
  <param name="movie" value="{$this->videoEntry->content->src}"></param>
  <embed src="{$this->videoEntry->content->src}" type="{$this->videoEntry->content->type}" width="$width" height="$height">
  </embed>
</object>
EOT;
	}
	
	/**
	 *
	 * @param $maxResults int
	 *       	 Maximum number of YoutubeVideo to return.
	 * @return array(YoutubeVideo) Videos retrieved.
	 */
	public function getRelatedVideos($maxResults) {
		try {
			
			if (!class_exists('Zend_Loader')) {
				require_once WPPostsRateKeys::$plugin_dir . 'classes/YoutubeWordpress/Zend/Loader.php';
			}
			Zend_Loader::loadClass ( 'Zend_Gdata_Query' );
			Zend_Loader::loadClass ( 'Zend_Gdata_YouTube' );
			
			$query = new Zend_Gdata_Query ( Zend_Gdata_YouTube::VIDEO_URI . "/{$this->videoEntry->getVideoId()}/" . Zend_Gdata_YouTube::RELATED_URI_SUFFIX );
			$query->setMaxResults ( $maxResults );
			
			$yt = new Zend_Gdata_YouTube ();
			$yt->setMajorProtocolVersion ( 2 );
			
			$relatedVideosFeed = $yt->getFeed ( $query, 'Zend_Gdata_YouTube_VideoFeed' );
			// TODO See how this initialization must be done, I mean if is really neccesary.
			$relatedVideos = array ();
			foreach ( $relatedVideosFeed as $relatedVideoEntry ) {
				$relatedVideos [] = new YoutubeVideo ( $relatedVideoEntry );
			}
			return $relatedVideos;
		} catch (Exception $e) {
			// Store to log
			$msg_to_log = 'Error while getRelatedVideos from Youtube' 
   									. ', Exception Msg: ' . $e->getMessage();		        	
		    // Add log
	        WPPostsRateKeys_Logs::add_error('362',$msg_to_log);
	        
	        return array();
		}
	}
}
