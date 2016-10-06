<?php 

function character_limiter($str, $n = 500, $end_char = '&#8230;') {
	if ( strlen($str) <= $n ) {
		return $str;
	} else {
		$ret = substr($str, 0, $n).$end_char;
		return $ret;
	}
}

?>