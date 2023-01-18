<?php
/**
 * Here the user will can see the uploaded data, with well-succeded creations and
 * the errors if it was.
 */

// Page configurations
require_once('../../../config.php');
global $PAGE, $OUTPUT;

// requires
require_once('../utils/visuals.php'); // some visual functions (table)

$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));
$PAGE->set_pagelayout('admin');
require_login();

print $OUTPUT->header();


$result_array = $_SESSION['result'];
// unset($_SESSION['result']);

// verify if errors array isn't empty
$process_result = (count($result_array['error']) == 0);

// if its all ok, it's nice to show the new courses
if (count($result_array['success']) > 0)
  print table($result_array['success'], 'Created courses', 'sucess');

// TODO: we need to do something now. Go back to the page?
if (! $process_result) {
  // show the courses that wasn't created
  print table($result_array['error'], 'Courses with error', 'error');
}
print $OUTPUT->render_from_template('block_externalsync/homepage_button', '');


/* FOOTER */
print $OUTPUT->footer();