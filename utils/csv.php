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

/* To verify if the array is consistant */
function verifyArray ($array, $type) {
  $keys = array_keys($array[0]);
  $is_ok = true;

  if ($type == 0)
    $header = ['id', 'code', 'shortname', 'fullname', 'start', 'end'];  
  else if ($type == 1)
    $header = ['cpf', 'email', 'name', 'birthdate', 'mothername'];
  else
    echo 'vish';
  
  $ii = 0;
  foreach ($keys as $key) {
    $header_key = $header[$ii];
    $ii++;
    if ($key != $header_key) {
      $is_ok = false;
      break;
    }
  }

  if (!$is_ok) {
    \core\notification::error('The uploaded CSV is invalid. Verify if you choose the correct type.');
    $url = new moodle_url('/blocks/externalsync/pages/upload.php');
    redirect($url, '', false);
  }
}