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
$plugin_array = array();
$state_array = array();

$critical_array = array();

$finalcritarray = array();

//loop counts
$service_count = 0;
$host_count = 0;
$curr_state_count = 0;
$critcoun = 0;
$ttlcount = 0;
$plugin_count = 0;


//we want to look for these items in status.dat
$hostname = 'host_name=';
$service_des = 'service_description=';
$curr_state = 'current_state=';
$plugin_out = 'plugin_output=';
$last_check = 'last_check=';

while(!feof($data_source)){ //while through status.dat
    $line = fgets($data_source);

    $servicepos = strpos($line,$service_des);
    $hostpos = strpos($line,$hostname);
    $currpos = strpos($line,$curr_state);
    $plugpos = strpos($line,$plugin_out);


    if ($hostpos!==false){
	$host_count++;
	$host_array[$host_count]=substr($line,strpos($line,'=')+1,strlen($line));
	$check=1;
	}
    $check=0;

    if ($servicepos!==false){
	$service_count++;
        $service_array[$service_count]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
	}
    $check=0;

    if ($plugpos!==false){
	$plugin_count++;
	$plugin_array[$plugin_count]=substr($line,strpos($line,'=')+1,strlen($line));
	$check=1;
	}
	$check=0;
	
    if ($currpos!==false){
	$curr_state_count++;
	$state_array[$curr_state_count]=substr($line,strpos($line,'=')+1,strlen($line));
	$check=1;
	}


    if ($check==1){ //if for final array building
	$ttlcount++;

    if ($state_array[$ttlcount]==2){ //if for state being critical
	$critcount++;
	echo($critcount);

	$finalcritarray[$critcount]=$host_array[$ttlcount] . $plugin_array[$ttlcount] . $service_array[$servicecount];
	}

    }//final array build if end

//while loop end
}


echo '<pre>'; print_r($finalcritarray); echo '</pre>';

fclose($data_source);
?>


<div class="container-fluid">

<h6><?php echo($page_title); echo(" "); echo($current_date); ?></h6>

<?php foreach ($finalcritarray as $crit_item) {

	echo '<div class="alert alert-danger">';
	echo($crit_item);
	echo '</div>';

}
?>

</div>



<!--
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

-->


</body>
</html>
