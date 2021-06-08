<?php
$start = new Datetime($date1);
$end = new Datetime($date2);
$interval = $start->diff($end);
$result = $interval->format('%a');
?>