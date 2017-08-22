<?php

/* Mail Template */
$MAIL['welcomeweb']['mailid'] =  5471141;
$MAIL['forgotpassword']['mailid'] =  5471137;
// $MAIL['trackingcode']['mailid'] =  5471147;
$MAIL['trackingcode']['mailid'] =  5476514;
$MAIL['giidlist']['mailid'] =  5471144;
$MAIL['redeemdont']['mailid'] =  5635510;
$MAIL['redeemdontbe']['mailid'] = 5635516;
$MAIL['redeemdontbea']['mailid'] = 5635606;
$MAIL['redeemdontbeamaybe']['mailid'] = 5635607;

$MAIL['welcomeweb']['listid'] =  3308474;
$MAIL['forgotpassword']['listid'] =  3308472;
// $MAIL['trackingcode']['listid'] =  3308476;
$MAIL['trackingcode']['listid'] =  3308476;
$MAIL['giidlist']['listid'] =  3308475;

$MAIL['redeemdont']['listid'] =  3379001;
$MAIL['redeemdontbe']['listid'] = 3376724;
$MAIL['redeemdontbea']['listid'] = 3379002;
$MAIL['redeemdontbeamaybe']['listid'] = 3379003;

$data = "<LIST_ID>".$MAIL[$mailtemplate]['listid'] ."</LIST_ID><CREATED_FROM>1</CREATED_FROM><UPDATE_IF_FOUND>true</UPDATE_IF_FOUND>";
$data .= "<COLUMN><NAME>EMAIL</NAME><VALUE>".$email."</VALUE></COLUMN>";
$data .= "<COLUMN><NAME>FIRST_NAME</NAME><VALUE>".$firstname."</VALUE></COLUMN>";
$data .= "<COLUMN><NAME>LAST_NAME</NAME><VALUE>".$lastname."</VALUE></COLUMN>";
$data .= "<COLUMN><NAME>PASSWORD</NAME><VALUE>".$password."</VALUE></COLUMN>";
$data .= "<COLUMN><NAME>USER_NAME</NAME><VALUE>".$username."</VALUE></COLUMN>";
$data .= "<COLUMN><NAME>TRACKING_CODE</NAME><VALUE>".$trackingcode."</VALUE></COLUMN>";

$redeem = "<LIST_ID>".$MAIL[$mailtemplate]['listid'] ."</LIST_ID><CREATED_FROM>1</CREATED_FROM><UPDATE_IF_FOUND>true</UPDATE_IF_FOUND>";
$redeem .= "<COLUMN><NAME>EMAIL</NAME><VALUE>".$email."</VALUE></COLUMN>";
$redeem .= "<COLUMN><NAME>FIRST_NAME</NAME><VALUE>".$firstname."</VALUE></COLUMN>";
$redeem .= "<COLUMN><NAME>LAST_NAME</NAME><VALUE>".$lastname."</VALUE></COLUMN>";


$MAIL['welcomeweb']['template'] =  $data;
	 
$MAIL['forgotpassword']['template'] =  $data;

$MAIL['trackingcode']['template'] =  $data;

$MAIL['giidlist']['template'] = $data;

$MAIL['redeemdont']['template'] = $redeem;

$MAIL['redeemdontbe']['template'] = $redeem;

$MAIL['redeemdontbea']['template'] = $redeem;

$MAIL['redeemdontbeamaybe']['template'] = $redeem;





?>
