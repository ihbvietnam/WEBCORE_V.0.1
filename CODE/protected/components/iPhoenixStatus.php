<?php
class iPhoenixStatus {
/*
	 * Encode status
	 */
	static function encodeStatus($list){
		$code=0;
		foreach ($list as $status){
			$code += pow(2, $status);
		}
		return $code;
	}
	/*
	 * Decode status
	 */
	static function decodeStatus($code){
		if($code==0) return array();
		$tmp=strrev((string)decbin($code));
		$result=array();
		$pos=0;
		while($pos<strlen($tmp)){
			$pos=strpos($tmp, '1',$pos);
			$result[]=$pos;
			$pos++;
		}
		return $result;
	}
}