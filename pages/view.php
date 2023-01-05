<?php
/**
 * In this page the user can select CSV files of users or
 * courses to upload.
 * 
 * This uses the 'view.html' template, and and to the 
 * 'upload.php' page, where the data can be seen and confirmed
 * to upload.
 */

require_once('../../../config.php');
global $PAGE, $OUTPUT;

// page configs
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));

print $OUTPUT->header();

$view = file_get_contents('../templates/view.html');
print $view;

print $OUTPUT->footer(); 
