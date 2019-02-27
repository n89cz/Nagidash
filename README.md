# Nagidash

Very simple monitoring dashboard for Nagios where you see only items which return state other then 0. Currenty it does not include items in unknown state (TODO). 

Nagidash is based on "Nagios Dashboard - PHP" which is presented here (https://exchange.nagios.org/directory/Addons/Frontends-%28GUIs-and-CLIs%29/Web-Interfaces/Nagios-Dashboard--2D-PHP/details#_ga=2.211361109.1353996912.1550563425-409400710.1548750848). It uses 
Bootstrap 4 and currently work with Nagios version Nagios® Core™ 4.4.3. I have not tested it on any others versions.

Please feel free to use and edit Nagidash to fit your needs.

If you have any wishes let me know.



TODO:

<s>1. Include also items which are in unknown state - DONE</s>

2. In httpd errorlog is plenty of these errors:

    Undefined offset: 0 in /var/www/html/nagidash/index.php on line 124
    
    and

    Undefined offset: 0 in /var/www/html/nagidash/index.php on line 124

    This need to be fixed so i does not flood the errorlog
    
3. Webbrowser push notifications?
