<?php
//TODO: Move all configuration items into config.php and require the file:
//require_once 'config.php';

$data_source = fopen("/var/spool/nagios/status.dat", "r") or exit("I am not able to open status.dat file. Is the path correct?");
$page_title = "Nagidash";
$current_date = date('Y-m-d H:i:s');
$refresh_rate = 360;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo($page_title);?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="<?php echo($refresh_rate); ?>">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> -->

    <link rel="stylesheet" href="resources/bootstrap.min.css">
    <script src=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</head>

<body>
<?php

//arrays for different fields in nagios status.dat
$service_array = array();
$host_array = array();
$state_array = array();

$critical_array = array();

//loop counts
$servicecount = 0;
$host_count = 0;
$curr_state_count = 0;

//we want to look for these items in status.dat
$hostname = 'host_name=';
$service_des = 'service_description=';
$curr_state = 'current_state=';
$plugin_out = 'plugin_output=';
$last_check = 'last_check=';

while(!feof($data_source)){ //begin while through nagios status.dat
    $line = fgets($data_source);

    $servicepos = strpos($line,$service_des);
    $hostpos = strpos($line,$hostname);

    if ($servicepos!==false){
	 $servicecount++;
         $service_array[$servicecount]=substr($line,strpos($line,'=')+1,strlen($line));;
         $check=1;
    }
    $check=0;

    if ($hostpos!==false){
	$host_count++;
	$host_array[$host_count]=substr($line,strpos($line,'=')+1,strlen($line));;
	$check=1;
    }
    $check=0;

    if ($currpos!==false){
	$curr_state_count++;
	$statearray[$curr_state_count]=substr($line,strpos($line,'=')+1,strlen($line));
	$check=1;
    }
    $check=0;
}


echo '<pre>'; print_r($service_array); echo '</pre>';
echo '<pre>'; print_r($host_array); echo '</pre>';

fclose($data_source);
?>









    <div class="container-fluid">
	<h6><?php echo($page_title); echo(" "); echo($current_date); ?></h6>

	<div class="alert alert-danger">
	    <strong>Danger!</strong> You should <a href="#" class="alert-link">read this message</a>.
	</div>
	
	<div class="alert alert-warning">7
	     <strong>Warning!</strong> You should <a href="#" class="alert-link">read this message</a>.
	</div>
	
	<div class="alert alert-success">
	    <strong>Success!</strong> You should <a href="#" class="alert-link">read this message</a>.
	</div>
    </div>

</body>
</html>
