<?php
$connect = new mysqli("localhost","root","","voting",3307) or die("connection failed!");   //3307 i have added bcoz i change the port in config file otherwise there is not need to write by default 3306 is running

if($connect)
{
    echo "Connected!";
}
else{
    echo "Not Connected!";
}
?>