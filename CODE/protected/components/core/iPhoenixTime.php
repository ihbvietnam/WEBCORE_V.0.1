<?php
class iPhoenixTime {
static function stringToTime($str,$char='/',$milestone='start'){
	$tmp=array_diff ( explode ( $char, $str ), array ('' ));
	if($milestone == 'start')
		return mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]);
	else
		return mktime(0,0,0,$tmp[1],$tmp[0]+1,$tmp[2]);
}
}
?>