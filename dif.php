<?php

$from = strtotime("12-11-2022 10:00:00");
$to = strtotime("12-11-2022 11:00:00");

$duration = 68*60 ; //sec

if (( $duration -= $to - $from ) <= 0 ){
    echo $duration -= $to - $from;
}
else{
    echo "You still have time";
}

