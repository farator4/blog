<?php
use DaveChild\TextStatistics as TS;
if ( ! class_exists( 'WSW_Calc' ) ) {

    /**
     *
     */
    class WSW_Calc{
        static function calc_post_score($text) {
            $textStatistics = new TS\TextStatistics;

            return $textStatistics->fleschKincaidReadingEase($text);

         }

        static function calc_post_density($text, $keyword) {
            $textStatistics = new TS\TextStatistics;

            $wordCount = $textStatistics->wordCount($text);

            $keywordCount = preg_match_all( '`\b' . preg_quote( $keyword, '`' ) . '\b`miu', utf8_encode( $text ), $res );

            $keywordDensity = ($keywordCount/$wordCount) *100;

            $strResult = $keywordDensity;
            return round($strResult, 2);
        }



        /**
         * Fetch all headings and return their content.
         *
         * @param string $postcontent Post content to find headings in.
         *
         * @return array Array of heading texts.
         */
        static function get_headings_h1( $postcontent, $keyword ) {
            if(!isset($keyword) || trim($keyword) =='') return '0';
            $retValue = '0';

            preg_match_all( '`<h([1])(?:[^>]+)?>(.*?)</h\\1>`si', $postcontent, $matches );


            if ( isset( $matches[2] ) && is_array( $matches[2] ) && $matches[2] !== array() ) {

                foreach ( $matches[2] as $heading ) {

                    if (strpos($heading,trim($keyword)) !== false) {
                        $retValue = '1';
                    }
                }
            }

            return $retValue;
        }

        static function get_headings_h2( $postcontent, $keyword ) {
            if(!isset($keyword) || trim($keyword) =='') return '0';
            $retValue = '0';

            preg_match_all( '`<h([2])(?:[^>]+)?>(.*?)</h\\1>`si', $postcontent, $matches );


            if ( isset( $matches[2] ) && is_array( $matches[2] ) && $matches[2] !== array() ) {

                foreach ( $matches[2] as $heading ) {
                    if (strpos($heading,trim($keyword)) !== false) {
                        $retValue = '1';
                    }
                }
            }

            return $retValue;
        }
        static function get_headings_h3( $postcontent, $keyword ) {
            if(!isset($keyword) || trim($keyword) =='') return '0';
            $retValue = '0';

            preg_match_all( '`<h([3])(?:[^>]+)?>(.*?)</h\\1>`si', $postcontent, $matches );


            if ( isset( $matches[2] ) && is_array( $matches[2] ) && $matches[2] !== array() ) {

                foreach ( $matches[2] as $heading ) {
                    if (strpos($heading,trim($keyword)) !== false) {
                        $retValue = '1';
                    }
                }
            }

            return $retValue;
        }

        static function get_keyword_decoration_bold( $postcontent , $keyword) {
            if(!isset($keyword) || trim($keyword) =='') return '0';
            $retValue = '0';

            preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $postcontent, $matches, PREG_SET_ORDER);

            foreach ($matches as $val) {
                if(trim($val[3]) == trim($keyword)){
                    if(trim($val[2]) == 'b') $retValue = '1';
                    if(trim($val[2]) == 'strong') $retValue = '1';


                }
            }
            return $retValue;
        }

        static function get_keyword_decoration_italic( $postcontent , $keyword) {
            if(!isset($keyword) || trim($keyword) =='') return '0';
            $retValue = '0';

            preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $postcontent, $matches, PREG_SET_ORDER);

            foreach ($matches as $val) {
                if(trim($val[3]) == trim($keyword)){
                    if(trim($val[2]) == 'i') $retValue = '1';
                    if(trim($val[2]) == 'em') $retValue = '1';
                }
            }
            return $retValue;
        }

        static function get_keyword_decoration_underline( $postcontent , $keyword) {
            if(!isset($keyword) || trim($keyword) =='') return '0';
            $retValue = '0';

            preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $postcontent, $matches, PREG_SET_ORDER);

            foreach ($matches as $val) {
                if(trim($val[3]) == trim($keyword)){
                    if(trim($val[2]) == 'u') $retValue = '1';

                }
            }
            return $retValue;
        }
    } // end WSW_Calc
}
