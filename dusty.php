<?php

//define static value for duration

$tenureScale[] = 'DAILY';
$tenureScale[] = 'WEEKLY';
$tenureScale[] = 'HALF_MONTH';
$tenureScale[] = 'MONTHLY';
$tenureScale[] = 'QUATERLY';
$tenureScale[] = 'HALF_YEARLY';
$tenureScale[] = 'YEARLY';


$DAILY['DAILY'] 		= 1;    
$DAILY['WEEKLY'] 		= 7;  
$DAILY['HALF_MONTH'] 	= 15;  
$DAILY['MONTHLY'] 		= 30;  
$DAILY['QUATERLY'] 		= 90;  
$DAILY['HALF_YEARLY'] 	= 180;  
$DAILY['YEARLY'] 		= 365;  

$WEEKLY['WEEKLY'] 		= 1;
$WEEKLY['HALF_MONTH'] 	= 2;
$WEEKLY['MONTHLY'] 		= 4;
$WEEKLY['QUATERLY'] 	= 12;
$WEEKLY['HALF_YEARLY'] 	= 24;
$WEEKLY['YEARLY'] 		= 48;

$HALF_MONTH['HALF_MONTH'] 	= 1;
$HALF_MONTH['MONTHLY'] 		= 2;
$HALF_MONTH['QUATERLY'] 	= 6;
$HALF_MONTH['HALF_YEARLY'] 	= 12;
$HALF_MONTH['YEARLY'] 		= 24;

$MONTHLY['MONTHLY'] 	= 1;
$MONTHLY['QUATERLY'] 	= 3;
$MONTHLY['HALF_YEARLY'] = 6;
$MONTHLY['YEARLY'] 		= 12;

$QUATERLY['QUATERLY'] 	 = 1;
$QUATERLY['HALF_YEARLY'] = 2;
$QUATERLY['YEARLY'] 	 = 4;

$HALF_YEARLY['HALF_YEARLY'] = 1;
$HALF_YEARLY['YEARLY'] 		= 2;

$YEARLY['YEARLY'] = 1;


echo '<pre>';
print_r($tenureScale);

$emiMode = 3;//daily, weekly or monthly
$durationType = 6;// daily, weekly, or monthly
$duration = 2;// time to bowrrow the money
echo ${$tenureScale[$emiMode]}[$tenureScale[$durationType]]*$duration;


?>