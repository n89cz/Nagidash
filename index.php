<?php
//TODO: Move all configuration items into config.php and require the file:
//require_once 'config.php';

$data_source = fopen("/var/spool/nagios/status.dat", "r") or exit("I am not able to open status.dat file. Is the path correct?");
$page_title = "Nagidash";
$current_date = date('Y-m-d H:i:s');
$refresh_rate = 30;
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
$hostarray = array();
$servicearray = array();
$statearray = array();
$pluginarray = array();
$checkarray = array();
$ackarray = array();
$disarray = array();

//arrays for status of hosts/services
$finaluparray = array();
$finalwarnarray = array();
$finalcritarray = array();
$finaldisarray = array();
$finalunknownarray = array();

//field to check in nagios status.dat
$hostname = 'host_name=';
$hostgroup= 'host_group=';
$servicedes = 'service_description=';
$currstate = 'current_state=';
$pluginout = 'plugin_output=';
$lastcheck = 'last_check=';
$ackcheck = 'been_acknowledged=';
$discheck = 'active_checks_enabled=';

//counters for loops
$hostcount = 0;
$servicecount = 0;
$currcount = 0;
$plugcount = 0;
$lastcount = 0;
$discount = 0;
$disttlcount = 0;
$ackcount = 0;
$ttlcount = 0;
$check = 0;
$okcount = 0;
$warncount = 0;
$critcount = 0;
$unknowncout = 0;

while(!feof($data_source)){ //begin while through nagios status.dat
$line = fgets($data_source);

//strpos to check for field line by line
$hostpos = strpos($line,$hostname);
$servicepos = strpos($line,$servicedes);
$currpos = strpos($line,$currstate);
$plugpos = strpos($line,$pluginout);
$lastpos = strpos($line,$lastcheck);
$dispos = strpos($line,$discheck);
$ackpos = strpos($line,$ackcheck);

       if ($hostpos!==false){
        $hostcount++;
        $hostarray[$hostcount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
       }
       $check=0;

       if ($servicepos!==false){
        $servicecount++;
        $servicearray[$servicecount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
       }
       $check=0;

       if ($currpos!==false){
        $currcount++;
        $statearray[$currcount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
       }
       $check=0;

       if ($plugpos!==false){
        if (strpos($line,"long_plugin_output=")===false){
         $plugcount++;
        $pluginarray[$plugcount]=substr($line,strpos($line,'=')+1,strlen($line));
         $check=1;
        }
       }
       $check=0;

       if ($lastpos!==false){
        $lastcount++;
        $checkarray[$lastcount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
       }
      $check=0;

       if ($servicearray[$servicecount]!=""){ //if the host has a service being checked
       if ($dispos!==false){
        $discount++;
        $disarray[$discount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
       }
       $check=0;

       if ($ackpos!==false){
        $ackcount++;
        $ackarray[$ackcount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
       }
       }

       if ($servicearray[$servicecount]==""){ //if the host has no service being checked
        if ($ackpos!==false){
        $ackcount++;
        $ackarray[$ackcount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
       }

       $check=0;

       if ($dispos!==false){
        $discount++;
        $disarray[$discount]=substr($line,strpos($line,'=')+1,strlen($line));
        $check=1;
        }
       }

       if ($check==1){ //if for final array building
        $ttlcount++;

        if ($disarray[$ttlcount]==1){ //if for active checks being enabled (1)

         if ($statearray[$ttlcount]==0){ //if for state being up/ok (0 for acknowledgements, you dont acknowledge an up service/host)
          $okcount++;
          $finaluparray[$okcount]=$statearray[$ttlcount].",0,".$checkarray[$ttlcount].",".$hostarray[$ttlcount].",".$pluginarray[$ttlcount].",".$servicearray[$servicecount];
         }

         if ($statearray[$ttlcount]==1){ //if for state being warning 
          $warncount++;
           if ($ackarray[$ttlcount]==""){
            $ackarray[$ttlcount]=0;
           }

          $finalwarnarray[$warncount]=$hostarray[$ttlcount]." - ". $servicearray[$servicecount]. " - " .$pluginarray[$ttlcount]  . " - " . " Last check: " . $last_check
        }

        if ($statearray[$ttlcount]==2){ //if for state being critical
         $critcount++;

          if ($ackarray[$ttlcount]==""){
           $ackarray[$ttlcount]="0";
          }

         $finalcritarray[$critcount]=$hostarray[$ttlcount] ." - ". $servicearray[$servicecount] ." - ". $pluginarray[$ttlcount]  . " - " . " Last check: " . $last_check
        }// end if for state being critical
	
	//if for unknown state
	if ($statearray[$ttlcount]==3) {
	    $unknowncount++;
	    if ($ackarray[$ttlcount]=="") {
		$ackarray[$ttlcount]=0;
	    }
	$last_check = date('Y/m/d H:i:s', $checkarray[$lastcount]);
	$finalunknownarray[$unknowncout]=$hostarray[$ttlcount] . " - ". $servicearray[$servicecount] ." - ". $pluginarray[$ttlcount] . " - " . " Last check: " . $last_check;
	}
	

       }  //end if for active checks being enabled

        //if active checks are 0 then checking is disabled (0), the 3 represents the disabled state
        if ($disarray[$ttlcount]==0){ 
         $disttlcount++;
         $finaldisarray[$disttlcount]="3,0,".$checkarray[$ttlcount].",".$hostarray[$ttlcount].",".$pluginarray[$ttlcount].",".$servicearray[$servicecount];
        }
      }  //end if for final array building
}//end while loop through nagios status.dat


//next line for debugging purposes
//echo '<pre>'; print_r($finalunknownarray); echo '</pre>';


fclose($data_source);
?>

<div class="container-fluid">

<h6><?php echo($page_title); echo(" "); echo($current_date); ?></h6>

<?php
if (empty($finalwarnarray) && empty($finalcritarray) && empty($finalunknownarray)) {
    echo '<div class="alert alert-success">';
    echo '<strong>OK - no issue detected</strong>';
    echo '</div>';

}
else {
    //show items in critical status
    foreach ($finalcritarray as $crit_item) {
	echo '<div class="alert alert-danger">';
	echo($crit_item);
	echo '</div>';
    }

    //show items in unknown state
    foreach ($finalunknownarray as $unknown_item) {
	echo '<div class="alert alert-danger">';
	echo($unknown_item);
	echo '</div>';
    }

    //show item in warning status
    foreach ($finalwarnarray as $warn_item) {
	echo '<div class="alert alert-warning">';
	echo($warn_item);
	echo '</div>';
    }
}

?>

</div>
</body>
</html>
