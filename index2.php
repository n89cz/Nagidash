<?php
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

//we want to look for these items in status.dat
$hostname = 'host_name=';
$service_des = 'service_description=';
$curr_state = 'current_state=';
$plugin_out = 'plugin_output=';
$last_check = 'last_check=';
$is_service = 'servicestatus {';

while(!feof($data_source)){ //while through status.dat
    $line = fgets($data_source);

	$service_strpos = strpos($line,$is_service);		

	if ($service_strpos!==false){
	echo($line);
	}



//while loop end
}

?>


</body>
</html>
