#!/usr/bin/php
<?php
include 'libs/JalaliDate.php';
if (in_array('-help',$argv)){
	echo PHP_EOL;
	echo "-ts unix_timestamp :			1563247896					\n";
	echo "-ymdHis year month day hout min sec : 20180101020304				\n";
	echo "-from from language fa_IR | en_US	, default : fa_IR							\n";
	echo "-out output format , default : Y/m/d H:i:s								\n";
	die(PHP_EOL);
}

$source = array();
foreach ($argv as $i => $arg){
	$arg = trim($arg);
	if (substr($arg, 0,1) == '-'){
		$key = trim($arg,' -');
		if (isset($argv[$i+1])) $source[$key] = $argv[$i+1];
	}
}

$from = !isset($source['from']) || empty($source['from'])?'fa_IR':$source['from'];
$outPut = !isset($source['out']) || empty($source['out'])?'Y/m/d H:i:s':$source['out'];
$date = new Noshika_JalaliDate();
$tsO = time();

if (isset($source['ts']) && !empty($source['ts'])){
	$tsO = intval($source['ts']);
}elseif (isset($source['ymdHis']) && !empty($source['ymdHis'])){
	$year	= substr($source['ymdHis'], 0 , 4);
	$month	= substr($source['ymdHis'], 4 , 2);
	$day	= substr($source['ymdHis'], 6 , 2);
	$hour	= substr($source['ymdHis'], 8 , 2);
	$min	= substr($source['ymdHis'], 10 , 2);
	$sec	= substr($source['ymdHis'], 12 , 2);
	if ($from == 'fa_IR'){
		$date->set_hejri_date($year, $month, $day);
		$date->setTime($hour, $min,$sec);
		$tsO = $date->date('U');
	}else {
		$tsO = mktime($hour,$min,$sec,$month,$day,$year);
	}
}

echo $date->date($outPut,'fa_IR',$tsO).PHP_EOL;
echo $date->date($outPut,'en_US',$tsO).PHP_EOL;
echo $tsO.PHP_EOL;
exit();

