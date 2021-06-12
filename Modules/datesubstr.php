<?php
//Assign $date1 to $start & $date2 to $end
$start = new Datetime($date1);
$end = new Datetime($date2);
//Substract $start & $end
$interval = $start->diff($end);
//Get the result in (symbol, number) format, for example -2, 2, -5
$result = $interval->format('%R%a');
?>