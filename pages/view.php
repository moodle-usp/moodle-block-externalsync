<?php

require_once('../../../config.php');
global $PAGE, $OUTPUT;

// page configs
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));

print $OUTPUT->header();

$view = file_get_contents('../templates/view.html');
print $view;

print $OUTPUT->footer(); 
