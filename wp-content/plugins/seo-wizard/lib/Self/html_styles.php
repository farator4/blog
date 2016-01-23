<?php
if (!class_exists('WSW_HtmlStyles')) {
	class WSW_HtmlStyles
	{
	    /**
         * Return the number of keywords as Bold
         * 
         * @param	array	$keyword_arr
         * @param	string	$content
         * @return 	int
         * @static 
         */
        static function how_many_keyword_bold($keyword_arr,$content) {
        	$pieces = WSW_Keywords::get_pieces_by_keyword($keyword_arr,$content);
        	
        	// Checks for each piece of code, is needed the total
        	$to_return = 0;
        	
        	for ($i=0;$i<(count($pieces)-1);$i++) {
        		 
        		$result = WSW_HtmlStyles::if_some_style_in_pieces($pieces, $i
        				, WSW_HtmlStyles::get_bold_styles(), $keyword_arr);
        		if ($result) {
        			$to_return++;
        		}
        	}
        	
        	return $to_return;
        }
        
	    /**
         * Return the number of keywords as italic
         * 
         * @param	array	$keyword_arr
         * @param	string	$content
         * @return 	bool
         * @static 
         */
        static function how_many_keyword_italic($keyword_arr,$content) {
        	$pieces = WSW_Keywords::get_pieces_by_keyword($keyword_arr,$content);
        	 
        	// Checks for each piece of code, is needed the total
        	$to_return = 0;
        	 
        	for ($i=0;$i<(count($pieces)-1);$i++) {
        	
        		$result = WSW_HtmlStyles::if_some_style_in_pieces($pieces, $i
        						, WSW_HtmlStyles::get_italic_styles(), $keyword_arr);
        		if ($result) {
        			$to_return++;
        		}
        	}
        	 
        	return $to_return;
        }
        
	    /**
         * Return the number of keywords as underline
         * 
         *
         * @param	array	$keyword_arr
         * @param	string	$content
         * @return 	bool
         * @static 
         */
        static function how_many_keyword_underline($keyword_arr,$content) {
        	
        	
        	$pieces = WSW_Keywords::get_pieces_by_keyword($keyword_arr,$content);
        	 
        	// Checks for each piece of code, is needed the total
        	$to_return = 0;
        	 
        	for ($i=0;$i<(count($pieces)-1);$i++) {
        	
        		$result = WSW_HtmlStyles::if_some_style_in_pieces($pieces, $i
        						, WSW_HtmlStyles::get_underline_styles(), $keyword_arr);
        		if ($result) {
        			$to_return++;
        		}
        	}
        	 
        	return $to_return;
        }

	    /**
         * Return all the styles for bold, underline or italic
         * 
         * @return 	array
         * @static 
         */
        static function get_styles() {
        	
        	return array(
        			array('<b>','</b>','bold')
        			, array('<strong>','</strong>','bold')
        			, array('style','font-weight: bold','bold')
        			, array('<i>','</i>','italic')
        			, array('<em>','</em>','italic')
        			, array('style','font-style: italic','italic')
        			, array('<u>','</u>','underline')
        			, array('style','text-decoration: underline','underline')
        			, array('<h1','</h1>','H1') // without > to allow define attributes
        			, array('<h2','</h2>','H2') // without > to allow define attributes
        			, array('<h3','</h3>','H3') // without > to allow define attributes
        		);
        }
        
	    /**
         * Return all the styles to be check before apply an internal link
         * 
         * @return 	array
         * @static 
         */
        static function get_styles_not_allowed_in_links() {
        	// without > to allow define attributes
        	return array(
        			array('<h1','</h1>','H1') 
        			, array('<h2','</h2>','H2')
        			, array('<h3','</h3>','H3')
        			, array('<a','</a>','a')
        			, array('<img','>','img')
        			, array('<title','</title>','title')
        		);
        }
        
	    /**
         * Return all the h_styles
         * 
         * @param 	string	$h			can be H1, H2 or H3
         * @return 	array
         * @static 
         */
        static function get_h_styles($h) {
        	$all_styles = self::get_styles();
        	$return = array();
        	
        	foreach ($all_styles as $style) {
        		if ($style[2]==$h)
        			$return[] = $style;
        	}
        	
        	return $return;
        }
        
	    /**
         * Return all the italic_styles
         * 
         * @return 	array
         * @static 
         */
        static function get_italic_styles() {
        	$all_styles = self::get_styles();
        	$return = array();
        	
        	foreach ($all_styles as $style) {
        		if ($style[2]=='italic')
        			$return[] = $style;
        	}
        	
        	return $return;
        }
        
	    /**
         * Return all the bold_styles
         * 
         * @return 	array
         * @static 
         */
        static function get_bold_styles() {
        	$all_styles = self::get_styles();
        	$return = array();
        	
        	foreach ($all_styles as $style) {
        		if ($style[2]=='bold')
        			$return[] = $style;
        	}
        	
        	return $return;
        }
        
	    /**
         * Return all the underline_styles
         * 
         * @return 	array
         * @static 
         */
        static function get_underline_styles() {
        	$all_styles = self::get_styles();
        	$return = array();
        	
        	foreach ($all_styles as $style) {
        		if ($style[2]=='underline')
        			$return[] = $style;
        	}
        	
        	return $return;
        }
        
	    /**
         * Apply the bold HTML style
         * 
         * @param 	string	$keyword
         * @return 	string
         * @static 
         */
        static function apply_bold_styles($keyword) {
        	$settings = WSW_Main::$settings;
        	
        	$design_arr = self::get_bold_styles();
        	$selected_design_id = $settings['opt_keyword_decorate_bold_type'];
        	$selected_design = $design_arr[$selected_design_id];
        	
        	if ($selected_design[0]=='style') {
        		$html_before = '<span style="' . $selected_design[1] . '">'; 
        		$html_after = '</span>';
        	}
        	else {
        		$html_before = $selected_design[0]; 
        		$html_after = $selected_design[1];
        	}
        	
        	return $html_before . $keyword . $html_after;
        }
        
	    /**
         * Apply the italic HTML style
         * 
         * @param 	string	$keyword
         * @return 	string
         * @static 
         */
        static function apply_italic_styles($keyword) {
        	$settings = WSW_Main::$settings;
        	$design_arr = self::get_italic_styles();
        	$selected_design_id = $settings['opt_keyword_decorate_italic_type'];
        	$selected_design = $design_arr[$selected_design_id];
        	
        	if ($selected_design[0]=='style') {
        		$html_before = '<span style="' . $selected_design[1] . '">'; 
        		$html_after = '</span>';
        	}
        	else {
        		$html_before = $selected_design[0]; 
        		$html_after = $selected_design[1];
        	}
        	
        	return $html_before . $keyword . $html_after;
        }
        
	    /**
         * Apply the underline HTML style
         * 
         * @param 	string	$keyword
         * @return 	string
         * @static 
         */
        static function apply_underline_styles($keyword) {
        	$settings = WSW_Main::$settings;

        	$design_arr = self::get_underline_styles();

        	$selected_design_id = $settings['opt_keyword_decorate_underline_type'];

        	$selected_design = $design_arr[$selected_design_id];
        	
        	if ($selected_design[0]=='style') {
        		$html_before = '<span style="' . $selected_design[1] . '">'; 
        		$html_after = '</span>';
        	}
        	else {
        		$html_before = $selected_design[0]; 
        		$html_after = $selected_design[1];
        	}
        	
        	return $html_before . $keyword . $html_after;
        }
        
	    /**
         * Check if the Internal Link can be applied
         * 
         * Checks too:
         * - if the keyword is inside a tag
         * - if the keyword is inside a shortcode
         * - if inside of some of the follow tags: <a>,<img>,<title>,<h1>,<h2>,<h3>
         * 
         * @param	string	$content
         * @param	string	$keyword
         * @param	array	$keyword_arr
         * @return 	bool
         * @static 
         */
        static function if_ready_to_apply_internal_link($content,$keyword_arr,$key_pos=1) {
			$pieces = WSW_Keywords::get_pieces_by_keyword($keyword_arr,$content);
			
			$before_key_pos = $key_pos - 1;
			
			if (count($pieces)>$key_pos) {
				$array_to_check = self::get_styles_not_allowed_in_links();
				$some_style = self::if_some_style_in_pieces($pieces,$before_key_pos,$array_to_check,$keyword_arr);
				
				if ($some_style) { // If true, is inside a not allowed tag
					return false;
				}
				else {
					$in_tag_attr = self::keyword_in_tag_attribute($pieces,$before_key_pos);
					if ($in_tag_attr) {
						return false;
					}
					else {
						$in_shortcode = self::keyword_in_shortcode($pieces,$before_key_pos);
						
						if ($in_shortcode)
							return false;
					}
				}
			}
			
        	return true;
        }
        
	    /**
         * Check if has some of the three styles applied
         * 
         * Checks too:
         * - if the keyword is inside a tag
         * - if the keyword is inside a shortcode
         * 
         * @param	string	$content
         * @param	string	$keyword
         * @param	array	$keyword_arr
         * @return 	bool
         * @static 
         */
        static function if_some_style_or_in_tag_attribute($content,$keyword_arr,$key_pos=1) {
			$pieces = WSW_Keywords::get_pieces_by_keyword($keyword_arr,$content);
			
			$before_key_pos = $key_pos - 1;
			
			if (count($pieces)>$key_pos) {
				$some_style = self::if_some_style_in_pieces($pieces,$before_key_pos,array(),$keyword_arr);
				if ($some_style) { // If true, so some style is applied
					return $some_style;
				}
				else {
					$in_tag = self::keyword_in_tag_attribute($pieces,$before_key_pos);
					if ($in_tag) {
						return array(TRUE,'in_tag');
					}
					else {
						$in_shortcode = self::keyword_in_shortcode($pieces,$before_key_pos);
						
						if ($in_shortcode)
							return array(TRUE,'in_shortcode');
					}
				}
			}
			
        	return FALSE;
        }
        
        /**
         * Check if has the keyword is in a shortcode
         * 
         * @param	array	$pieces
         * @param	int		$before_key_pos
         * @return 	bool
         * @static 
         */
        static function keyword_in_shortcode($pieces,$before_key_pos) {
        	
        	// Make piece 1 as the join of all pieces before the current keyword to check
        	$piece1 = '';
        	for ($i=0;$i<=$before_key_pos;$i++) {
        		$piece1 .= $pieces[$i];
        	}
        	
        	{
        		// Check for keyword inside shortcode
        		$last_less_than = strrpos($piece1,'[');
        		if ($last_less_than!==FALSE) {
        			$last_bigger_than = strrpos($piece1,']');
        			if ($last_bigger_than===FALSE || $last_bigger_than<$last_less_than)
        				return TRUE;
        		}
        	}
        	
        	return FALSE;
        }
        
        /**
         * Check if has the keyword is in a tag
         * 
         * @param	array	$pieces
         * @param	int		$before_key_pos
         * @return 	bool
         * @static 
         */
        static function keyword_in_tag_attribute($pieces,$before_key_pos) {
        	
        	// Make piece 1 as the join of all pieces before the current keyword to check
        	$piece1 = '';
        	for ($i=0;$i<=$before_key_pos;$i++) {
        		$piece1 .= $pieces[$i];
        	}
        	
        	// Check for keyword in alt or href attribute
        	$last_less_than = strrpos($piece1,'<');
        	if ($last_less_than!==FALSE) {
        		$last_bigger_than = strrpos($piece1,'>');
        		if ($last_bigger_than===FALSE || $last_bigger_than<$last_less_than)
        			return TRUE;
        	}
        	
        	return FALSE;
        }
        
        
	    /**
         * Get the content of Alt or Title attribute
         * 
         * 
         * @param	html	$sub_piece
         * @return 	string	this include the delimiter
         * @static 
         */
        static function get_content_in_alt_or_title($sub_piece,$alt_or_title_att='alt') {
        	
        	$sub_piece = '<img' . $sub_piece . '>';
        	
        	@$doc=new DOMDocument();
        	

        	
			@$doc->loadHTML($sub_piece);
			@$xpath = new DOMXPath(@$doc);
			@$images=$xpath->query('//img');
			
			/*@var $images DOMNodeList */
			if ($images->length>0) {
				
				/*@var $current_img DOMElement */
				$current_img = $images->item(0);
				if ($alt_or_title_att=='alt') {
					return (string) $current_img->getAttribute('alt');
				}
				else {
					return (string) $current_img->getAttribute('title');
				}
			}
			else {
				return '';
			}			
        }
        
	    /**
         * If user select this settings: automatic add_rel_nofollow_image_links
         * 
         * An image link is a link with an image as content
         * 
         * @param	html	$content
         * @param	array	$settings
         * 
         * @return 	html
         * @static 
         */
        static function add_rel_nofollow_image_links($content,$settings) {
        	
        	if (array_key_exists('auto_add_rel_nofollow_img_links' , $settings) && $settings['auto_add_rel_nofollow_img_links']==='1') {
        		
        		// Go through all links tags and check if is external with do follow, then add the nofollow
        		$matches = array();
        	
        		preg_match_all('/<a\s[^>]*href=\"([^\"]*)\"[^>]*>(.*)<\/a>/siU',$content,$matches);
        	
        		// In $matches[0] stores the whole tag a, in $matches[1] stores the href URLs
        		$index = 0;
        		foreach ($matches[0] as $tags) {
        			$a_content = $matches[2][$index]; // To check if is a img
        			
        			if (strpos($a_content, '<img')!==FALSE) {
        				
        				{
        					if (substr_count($tags,'rel="nofollow"')==0
        							&& substr_count($tags,'rel=nofollow')==0
        							&& substr_count($tags,'rel="no follow"')==0
        					) {
        						$is_dofollow = TRUE;
        					}
        				}
        				
        				if ($is_dofollow) {
        					// Add rel="nofollow" attribute
        					 
        					$old_a_tag = $tags;
        					$new_tag = str_replace('<a ','<a rel="nofollow" ',$old_a_tag);
        					 
        					// Replace in content Old tag with New tag
        					$content = str_replace($old_a_tag,$new_tag,$content);
        				}
	        		}
	        		$index++;
	        	}
        	}
        	 
        	return $content;
        }
        
	    /**
         * If user select to force it: automatic add_rel_nofollow_external_links
         * 
         * @param	html	$content
         * @param	array	$settings
         * 
         * @return 	html
         * @static 
         */
        static function add_rel_nofollow_external_links($content,$settings) {
        	
        	if ($settings['chk_nofollow_in_external']) {
        		$wp_url = get_bloginfo('wpurl');


	        	$wp_url_clean = str_replace('http://www.','',$wp_url);
	        	$wp_url_clean = str_replace('https://www.','',$wp_url_clean);
	        	$wp_url_clean = str_replace('https://','',$wp_url_clean);
	        	$wp_url_clean = str_replace('http://','',$wp_url_clean);
        		
	        	// Go through all links tags and check if is external with do follow, then add the nofollow 
	        	$matches = array();
	        	
	        	preg_match_all('/<a\s[^>]*href=\"([^\"]*)\"[^>]*>(.*)<\/a>/siU',$content,$matches);
	        	
	        	// In $matches[0] stores the whole tag a, in $matches[1] stores the href URLs
	        	$index = 0;
	        	foreach ($matches[0] as $tags) {
	        		$url = $matches[1][$index];
	        		
	        		// Check if is external
	        		$is_external = FALSE;
	        		
	        		// Clean from http://www. and http://
	        		$url_clean = str_replace('http://www.','',$url);
	        		$url_clean = str_replace('https://www.','',$url_clean);
	        		$url_clean = str_replace('https://','',$url_clean);
	        		$url_clean = str_replace('http://','',$url_clean);
	        		
	        		if ((strpos($url,'http://')===0 || strpos($url,'https://')===0) && strpos($url_clean,$wp_url_clean)!==0) // Url of code begins with https:// or http://
        				$is_external = TRUE;
	        		
	        		// Check if is do follow
	        		$is_dofollow = FALSE;
	        		{
		        		if (substr_count($tags,'rel="nofollow"')==0
		        			&& substr_count($tags,'rel=nofollow')==0
		        			&& substr_count($tags,'rel="no follow"')==0
		        			) {
		        			$is_dofollow = TRUE;
		        		}
	        		}
	        		
	        		if ($is_external && $is_dofollow) {
	        			// Add rel="nofollow" attribute
	        			
	        			$old_a_tag = $tags;
	        			$new_tag = str_replace('<a ','<a rel="nofollow" ',$old_a_tag);
	        			
	        			// Replace in content Old tag with New tag
	        			$content = str_replace($old_a_tag,$new_tag,$content);
	        		}
	        			
	        		$index++;
	        	} 
        	}
        	
        	return $content;
        }
        
	    /**
         * Decorates Images in the Post Content
         * 
         * Used to change the Alt and Title tags accoding to settings selected by user
         * 
         * @param	html	$new_content
         * @param	array	$settings
         * @return 	html
         * @static 
         */
        static function decorates_images($new_content, $settings) {

        	if ($settings['opt_image_alternate_type']!='none' || $settings['opt_image_title_type']!='none') {
        		$new_content = self::decorate_image_tag_atts($new_content,$settings['txt_image_alternate'],
                    $settings['txt_image_title'], $settings['opt_image_alternate_type'], $settings['opt_image_title_type']);
        	}
        	
        	return $new_content;
        }
        
	    /**
         * If user select to force it: automatic adding of alt=keyword
         * 
         * to all images in the content that do not have alt tags 
         * 
         * @param	html	$content				the content to search in
         * @param	string	$alt_value				the value to be set in the Alt attribute
         * @param	string	$title_value			the value to be set in the Title attribute
         * @param	string	$alt_decoration_type	can be "none", "empty" or "all"
         * @param	string	$title_decoration_type	can be "none", "empty" or "all"
         * 
         * @return 	html
         * @static 
         */
        static private function decorate_image_tag_atts($content, $alt_value, $title_value, $alt_decoration_type, $title_decoration_type) {

        	// explode the string by <img begginin tag
        	$str_arr = explode('<img',$content);
        	$new_str_arr = array();

        	for ($i=0; $i<count($str_arr); $i++) {
        		if ($i == 0) // Ignore the first piece of html because there isn't no <img tag
        			$new_str_arr[] = $str_arr[$i];
        		else {
        			$piece = $str_arr[$i];
        			
        			{
        				$pos_bigger_than = strpos($piece, '>'); // Finding the next >, is the one that close the <img tag
        			}
        			if ($pos_bigger_than) {
        				// Check if between the beginning of the $piece up to the next > possition is an alt tag
        				
        				{
        					$sub_piece = substr($piece, 0, $pos_bigger_than);
        				}

                /*
                 * Image Title
                 */
                if ($title_decoration_type != 'none') {

                  {
                    if (substr_count($sub_piece, ' title=') == 0
                      && substr_count($sub_piece, ' title =') == 0
                    ) { // Haven't alt tag, so ADD it

                      $piece = ' title="' . $title_value . '"' . $piece;
                    }
                    else {
                      // Check if has title tag but is empty, or if the option of "all" is selected
                      $inside_title_attr = trim(self::get_content_in_alt_or_title($sub_piece, 'title'), "'\" \\");
                      if ($inside_title_attr == '' || $title_decoration_type == 'all'){
                        // replace old tag value with new one
                        // Take in care the case in this the "title" is separated to the "="
                        $piece = str_ireplace('title =', 'title=', $piece);

                        $piece = str_ireplace(' title="' . $inside_title_attr . '"',' title="' . $title_value . '"',$piece);
                        $piece = str_ireplace(" title='" . $inside_title_attr . "'",' title="' . $title_value . '"',$piece);
                      }
                    }
                  }
                }

        				/*
        				 * Image Alt
        				 */
        				if ($alt_decoration_type != 'none') {
	        				
        					{
        						if (substr_count($sub_piece, ' alt=')==0
        								&& substr_count($sub_piece, ' alt =')==0
        						) { // Haven't alt tag, so ADD it
        						
        							$piece = ' alt="' . $alt_value . '"' . $piece;
        							// Now the sub piece is the piece
        							$sub_piece = $piece;
        						}
        						else {
        							// Check if has alt tag but is empty, or if the option of "all" is selected
        							$inside_alt_tag = trim(self::get_content_in_alt_or_title($sub_piece), "'\" \\");
        							if ($inside_alt_tag == '' || $alt_decoration_type == 'all'){
        								// replace old tag value with new one
        								// Take in care the case in this the "alt" is separated to the "="
        								$piece = str_ireplace('alt =', 'alt=', $piece);
        								 
        								$piece = str_ireplace(' alt="' . $inside_alt_tag . '"', ' alt="' . $alt_value . '"', $piece);
        								$piece = str_ireplace(" alt='" . $inside_alt_tag . "'", ' alt="' . $alt_value . '"', $piece);
        								// Now the sub piece is the piece
        								$sub_piece = $piece;
        							}
        						}
        					}
        				}


        			}
        				
        			$new_str_arr[] = $piece;
        		}
        	}
        		
        	return implode('<img', $new_str_arr);
        }
        
	    /**
         * Check if has some of the three styles applied to the pieces of code
         * 
         * @param	array	$pieces
         * @param	int		$index				keyword possition
         * @param	array	$arrays_to_check
         * @param	array	$keyword_arr
         * @return 	bool|array
         * @static 
         */
        static function if_some_style_in_pieces($pieces, $index, $arrays_to_check=array(), $keyword_arr) {
        	
        	foreach ($keyword_arr as $keyword) {

        		// determine both parts of texts
	        	$piece1 = '';
		        $piece2 = '';
	        	for ($i=0;$i<count($pieces);$i++) {
	        		if ($i<=$index) {
	        			if ($piece1=='')
	        				$piece1 .= $pieces[$i];
						else
	        				$piece1 .= $keyword . $pieces[$i];
	        		}
	        		else {
	        			if ($piece2=='')
	        				$piece2 .= $pieces[$i];
						else
	        				$piece2 .= $keyword . $pieces[$i];
	        		}
	        	}
	        	
	        	// Check in the already defined style arrays
	        	if (count($arrays_to_check)==0)
	        		$arrays_to_check = self::get_styles();
	        	
	        	foreach ($arrays_to_check as $to_check) {
	        		if ($to_check[0]!='style') {
	        			$begin_with = FALSE;
	        			$end_with = FALSE;
	        			
	        			{
	        				$pos_h_tmp = strpos($to_check[2],'H');
	        			}
	        			
	        			if ($pos_h_tmp===0) {
	        				// The Checks for H1, H2 and H3 are different, this tags can have other tags inside
	        				// But is a keyword is part of an attribute will not be considered, so
	        				// i clean the content of other tags
	        				$piece1 = strip_tags($piece1,'<h1><h2><h3>');
	        				$piece2 = strip_tags($piece2,'<h1><h2><h3>');
	        				
	        				// Check if begin with
	        				{
		        				$first_open_tag_left = strripos($piece1,$to_check[0]);
		        				$first_close_tag_left = strripos($piece1,$to_check[1]);
		        			}
		        			
		        			/*
	        				 * check in the left
	        				 * If: has at least one <h1
	        				 * and: 
	        				 * 		haven't </h1>
	        				 * 		or
	        				 * 		have </h1> before <h1>
	        				 */
	        				if ($first_open_tag_left!==FALSE) {
		        				if (
		        				$first_close_tag_left===FALSE
		        				|| ($first_close_tag_left!==FALSE && $first_close_tag_left < $first_open_tag_left)
		        				)
		        					$begin_with = TRUE;
		        				
		        			}
	        				// Check if end with
	        				{
		        				$first_open_tag_right = stripos($piece2,$to_check[0]);
	        					$first_close_tag_right = stripos($piece2,$to_check[1]);
		        			}
	        				/*
	        				 * check in the right
	        				 * If: has at least one </h1
	        				 * and: 
	        				 * 		haven't <h1>
	        				 * 		or
	        				 * 		have </h1> before <h1>
	        				 */
	        				if ($first_close_tag_right!==FALSE) {
		        				if (
		        				$first_open_tag_right===FALSE
		        				|| ($first_open_tag_right!==FALSE && $first_close_tag_right < $first_open_tag_right)
		        				)
		        					$end_with = TRUE;
		        			}
		        			
		        			if ($begin_with && $end_with) {
			        			// If has another H1, H2 or H3 inside, doesn't count
		        				{
		        					$piece_to_check = substr($piece1, $first_open_tag_left + 4); // +4 for the <hx>
		        					
		        					if (substr_count($piece_to_check, '<h1>')>0
		        							|| substr_count($piece_to_check, '<h2>')>0
		        							|| substr_count($piece_to_check, '<h3>')>0
		        					) {
		        						// Set to False so this match isn't counted
		        						$begin_with = FALSE;
		        						$end_with = FALSE;
		        					}
		        				}
		        			}		        			
	        			}
	        			else {
		        			// Check if begins with
		        			
	        				{
			        			// Determine the position (from rigth to left) of the "<"
			        			$first_back_less = strripos($piece1,'<'); 
			        			// Determine the position (from rigth to left) of the current tag to check
			        			$first_back_tag = strripos($piece1,$to_check[0]);
	        				}
		
		        			if ($first_back_less!==FALSE && $first_back_tag!==FALSE) {
		        				if ($first_back_less == $first_back_tag)
		        					$begin_with = TRUE;
		        			}
		
		        			// Check if ends with
		        			
		        			{
		        				// Determine the position (from left to rigth) of the "<"
			        			$first_less = stripos($piece2,'<'); 
			        			// Determine the position (from left to rigth) of the current tag to check
			        			$first_tag = stripos($piece2,$to_check[1]);
		        			}
		
		        			if ($first_less!==FALSE && $first_tag!==FALSE) {
		        				if ($first_less == $first_tag)
		        					$end_with = TRUE;
		        			}
	        			}
	        				
	        			if ($begin_with && $end_with) {	        					
	        				return array(TRUE,$to_check[2]);
	        			}
	        		}
	        		else {
	        			// 
	        			/*
	        			 * Some tag with style="$to_check[1]"
	        			 * example:
	        			 * <span style="font-weight: bold;">keyword</span>
	        			 * <p style="some: some; font-style: italic" id="some">keyword</span>
	        			 * <span style="text-decoration: underline;">keyword</span>
	        			 */
	        			
	        			{
		        			$strpos_1 = strrpos($piece1,'<');
			        		$strpos_2 = strrpos($piece1,'>');
			        		
			        		$sub_str = substr($piece1,$strpos_1,$strpos_2-$strpos_1);
			        		
			        		if (substr_count($sub_str,$to_check[1])>0)
			        			return array(TRUE,$to_check[2]);
	        			}
	        		}
	        	}
        	}
        	
        	return FALSE;        	
        }
	}
}

