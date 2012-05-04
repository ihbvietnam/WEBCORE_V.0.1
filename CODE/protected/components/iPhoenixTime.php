<?php
class iPhoenixTime {
static function stringToTime($str){
	$tmp=array_diff ( explode ( '/', $str ), array ('' ));
	return mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]);
}
}
?>