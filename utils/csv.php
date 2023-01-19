<?php

/* This function reads a CSV file with header and outputs its data as an array */
function csvToArray ($csvString) {
  $lines = explode(PHP_EOL, $csvString);
  $header = str_getcsv($lines[0]);
  $is_header = 0;
  foreach ($lines as $line) {
    if (empty($line)) break;
    if ($is_header == 0) $is_header++;
    else $array[] =  array_combine($header, str_getcsv($line));
  }
  return $array;
}

/* To check if the array is consistant */
function checkArray ($array, $type) {
  $keys = array_keys($array[0]);
  
  if ($type == 0)
    $header = ['id', 'code', 'shortname', 'fullname', 'start', 'end', 'summary'];  
  else if ($type == 1)
    $header = ['cpf', 'email', 'name', 'birthdate', 'mothername'];
  else {
    return false; // TODO: error treatment
  }
  
  $ii = 0;
  foreach ($keys as $key) {
    $header_key = $header[$ii];
    $ii++;
    if ($key != $header_key) {
      return false;
    }
  }
  return true;
}