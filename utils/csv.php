<?php

/* This function reads a CSV file with header and outputs its data as an array */
function csvToArray ($csvString) {
  $lines = explode(PHP_EOL, $csvString);
  $array = array();
  $header = str_getcsv($lines[0]);
  $is_header = 0;
  foreach ($lines as $line) {
    if (empty($line)) break;
    if ($is_header == 0) $is_header++;
    else $array[] =  array_combine($header, str_getcsv($line));
  }
  return $array;
}