<?php

/*$r = rmb('22212123');
  echo ($r);*/

class A{

	private static $one;
	static public function model(){
		if(!static::$one){
			static::$one = new static;
		}
		return static::$one;
	}

	public function rmb($money){
		return rmb($money);
	}
};

$a = A::model()->rmb('172.190');

//echo $a;
echo "\n";
$b = "4455";
$a = preg_match_all("/<script.*?>(?P<n>.*)<\/script>/i",'asd<script 11111> saasd </script> asdasd',$matches,PREG_OFFSET_CAPTURE);
//var_dump($a,$matches);

$s= 'aaaaa<script 1111> 222222 </script> nnnnn';

$p= "/<script.*?>(?P<n>.*)<\/script>/i";

$a = preg_replace($p,"$1",$s);

var_dump($s,$a);

die('');

?>









