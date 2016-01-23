<?php

function theme_strlen($str) {
	if (function_exists('mb_strlen')) {
		return mb_strlen($str);
	}
	return strlen($str);
}

function theme_strpos($source, $target) {
	if (function_exists('mb_strpos')) {
		return mb_strpos($source, $target);
	}
	return strpos($source, $target);
}

function theme_get_array_value($arr = array(), $key = null, $def = false) {
	if (is_array($arr) && @isset($arr[$key])) {
		return $arr[$key];
	}
	return $def;
}

function theme_is_empty_html($str) {
	return (!is_string($str) || theme_strlen(str_replace(array('&nbsp;', ' ', "\n", "\r", "\t"), '', $str)) == 0);
}


function theme_is_vmenu_widget($id) {
	return (strpos($id, 'vmenu') !== false);
}



function theme_trim_long_str($str, $len = 50, $sep = ' ') {
	$words = explode($sep, $str);
	$wcount = count($words);
	while ($wcount > 0 && theme_strlen(join($sep, array_slice($words, 0, $wcount))) > $len)
		$wcount--;
	if ($wcount != count($words)) {
		$str = join($sep, array_slice($words, 0, $wcount)) . '&hellip;';
	}
	return $str;
}

function theme_get_current_url() {
	$pageURL = 'http';
	if (is_ssl()) {
		$pageURL .= 's';
	}
	$pageURL .= '://' . $_SERVER['SERVER_NAME'];
	if ($_SERVER['SERVER_PORT'] != '80') {
		$pageURL .= ':' . $_SERVER["SERVER_PORT"];
	}
	$pageURL .= $_SERVER["REQUEST_URI"];
	return $pageURL;
}

function theme_remove_last_slash($url) {
	$len = theme_strlen($url);
	if ($len > 0 && $url[$len - 1] == '/') {
		$url = substr($url, 0, -1);
	}
	return $url;
}

function theme_is_current_url($url) {
	// remove # anchor
	if (strpos($url, '#')) {
		$url = substr($url, 0, strpos($url, '#'));
	}

	$url = theme_remove_last_slash($url);
	$cur = theme_remove_last_slash(theme_get_current_url());

	// compare
	return ($cur == $url);
}

function theme_prepare_attr($attr = array()) {
	$attr = wp_parse_args($attr);
	if (count($attr) == 0)
		return '';
	$result = '';
	foreach ($attr as $name => $value) {
		if (empty($name) || empty($value))
			continue;
		$result .= ' ' . strtolower($name) . '="' . esc_attr($value) . '"';
	}
	return $result;
}

function theme_highlight_excerpt($search_query, $text) {
	$text = strip_tags($text);
	$keys = explode(' ', $search_query);
	foreach ($keys as $i => $key) {
		$keys[$i] = preg_quote($keys[$i], '/');
	}
	$workkeys = $keys;

	// Extract a fragment per keyword for at most 4 keywords.  First we
	// collect ranges of text around each keyword, starting/ending at
	// spaces.  If the sum of all fragments is too short, we look for
	// second occurrences.
	$ranges = array();
	$included = array();
	$length = 0;
	while ($length < 256 && count($workkeys)) {
		foreach ($workkeys as $k => $key) {
			if (strlen($key) == 0) {
				unset($workkeys[$k]);
				continue;
			}
			if ($length >= 256) {
				break;
			}
			// Remember occurrence of key so we can skip over it if more
			// occurrences are desired.
			if (!isset($included[$key])) {
				$included[$key] = 0;
			}

			// NOTE: extra parameter for preg_match requires PHP 4.3.3
			if (preg_match('/' . $key . '/iu', $text, $match, PREG_OFFSET_CAPTURE, $included[$key])) {
				$p = $match[0][1];
				$success = 0;
				if (($q = strpos($text, ' ', max(0, $p - 60))) !== false &&
						$q < $p) {
					$end = substr($text, $p, 80);
					if (($s = strrpos($end, ' ')) !== false && $s > 0) {
						$ranges[$q] = $p + $s;
						$length += $p + $s - $q;
						$included[$key] = $p + 1;
						$success = 1;
					}
				}

				if (!$success) {
					// for the case of asian text without whitespace
					$q = _theme_text_find_1stbyte($text, max(0, $p - 60));
					$q = _theme_text_find_delimiter($text, $q);
					$s = _theme_text_find_1stbyte_reverse($text, $p + 80, $p);
					$s = _theme_text_find_delimiter($text, $s);
					if (($s >= $p) && ($q <= $p)) {
						$ranges[$q] = $s;
						$length += $s - $q;
						$included[$key] = $p + 1;
					} else {
						unset($workkeys[$k]);
					}
				}
			} else {
				unset($workkeys[$k]);
			}
		}
	}

	// If we didn't find anything, return the beginning.
	if (sizeof($ranges) == 0)
		return '<p>' . _theme_text_truncate($text, 256) . '&nbsp;...</p>';

	// Sort the text ranges by starting position.
	ksort($ranges);

	// Now we collapse overlapping text ranges into one. The sorting makes
	// it O(n).
	$newranges = array();
	foreach ($ranges as $from2 => $to2) {
		if (!isset($from1)) {
			$from1 = $from2;
			$to1 = $to2;
			continue;
		}
		if ($from2 <= $to1) {
			$to1 = max($to1, $to2);
		} else {
			$newranges[$from1] = $to1;
			$from1 = $from2;
			$to1 = $to2;
		}
	}
	$newranges[$from1] = $to1;

	// Fetch text
	$out = array();
	foreach ($newranges as $from => $to)
		$out[] = substr($text, $from, $to - $from);

	$text = (isset($newranges[0]) ? '' : '...&nbsp;') .
			implode('&nbsp;...&nbsp;', $out) . '&nbsp;...';
	$text = preg_replace('/(' . implode('|', $keys) . ')/iu', '<strong class="search-excerpt">\0</strong>', $text);
	return "<p>$text</p>";
}

// The number of bytes used when WordPress looking around to find delimiters
// (either a whitespace or a point where ASCII and other character switched).
// This also represents the number of bytes of few characters.
define('_THEME_LEN_SEARCH', 15);

function _theme_text_find_1stbyte($string, $pos = 0, $stop = -1) {
	$len = strlen($string);
	if ($stop < 0 || $stop > $len) {
		$stop = $len;
	}
	for (; $pos < $stop; $pos++) {
		if ((ord($string[$pos]) < 0x80) || (ord($string[$pos]) >= 0xC0)) {
			break;	  // find 1st byte of multi-byte characters.
		}
	}
	return $pos;
}

function _theme_text_find_1stbyte_reverse($string, $pos = -1, $stop = 0) {
	$len = strlen($string);
	if ($pos < 0 || $pos >= $len) {
		$pos = $len - 1;
	}
	for (; $pos >= $stop; $pos--) {
		if ((ord($string[$pos]) < 0x80) || (ord($string[$pos]) >= 0xC0)) {
			break;	  // find 1st byte of multi-byte characters.
		}
	}
	return $pos;
}

function _theme_text_find_delimiter($string, $pos = 0, $min = -1, $max = -1) {
	$len = strlen($string);
	if ($pos == 0 || $pos < 0 || $pos >= $len) {
		return $pos;
	}
	if ($min < 0) {
		$min = max(0, $pos - _THEME_LEN_SEARCH);
	}
	if ($max < 0 || $max >= $len) {
		$max = min($len - 1, $pos + _THEME_LEN_SEARCH);
	}
	if (ord($string[$pos]) < 0x80) {
		// Found ASCII character at the trimming point.  So, trying
		// to find new trimming point around $pos.  New trimming point
		// should be on a whitespace or the transition from ASCII to
		// other character.
		$pos3 = -1;
		for ($pos2 = $pos; $pos2 <= $max; $pos2++) {
			if ($string[$pos2] == ' ') {
				break;
			} else if ($pos3 < 0 && ord($string[$pos2]) >= 0x80) {
				$pos3 = $pos2;
			}
		}
		if ($pos2 > $max && $pos3 >= 0) {
			$pos2 = $pos3;
		}
		if ($pos2 > $max) {
			$pos3 = -1;
			for ($pos2 = $pos; $pos2 >= $min; $pos2--) {
				if ($string[$pos2] == ' ') {
					break;
				} else if ($pos3 < 0 && ord($string[$pos2]) >= 0x80) {
					$pos3 = $pos2 + 1;
				}
			}
			if ($pos2 < $min && $pos3 >= 0) {
				$pos2 = $pos3;
			}
		}
		if ($pos2 <= $max && $pos2 >= $min) {
			$pos = $pos2;
		}
	} else if ((ord($string[$pos]) >= 0x80) || (ord($string[$pos]) < 0xC0)) {
		$pos = _theme_text_find_1stbyte($string, $pos, $max);
	}
	return $pos;
}

function _theme_text_truncate($string, $byte) {
	$len = strlen($string);
	if ($len <= $byte)
		return $string;
	$byte = _theme_text_find_1stbyte_reverse($string, $byte);
	return substr($string, 0, $byte);
}
