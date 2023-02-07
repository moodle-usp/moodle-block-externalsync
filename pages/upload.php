<?php

/**
 * Here the user can to upload the files of courses 
 * or users.
 */

// Page configurations
require_once('../../../config.php');
global $PAGE, $OUTPUT;

$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));
$PAGE->set_pagelayout('admin');
require_login();

print $OUTPUT->header();

// requires
require_once('../utils/render_template.php'); // to render templates
require_once('../utils/forms.php');

// upload form
$form = new uploadform('processing.php');
print $OUTPUT->render_from_template('block_externalsync/upload', ['forms' => $form->render()]);

print $OUTPUT->footer();