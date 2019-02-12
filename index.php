<?php
$datasource = fopen("/var/spool/nagios/status.dat", "r") or exit("I am not able to open status.dat file.");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap 4 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <div class="container-fluid">
	<h6>current date and time here</h6>
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
