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


$result_array = $_SESSION['data_array'];
$form_data = $_SESSION['form_data'];
unset($_SESSION['result']);
unset($_SESSION['form_data']);

if (empty($result_array) or is_null($result_array) or empty($form_data) or is_null($form_data)) {
  \core\notification::error('Empty data. Try again.');
  $url = new moodle_url('/blocks/externalsync/pages/upload.php');
  redirect($url);
}


$data = array();
$created = (isset($result_array['created']) and count($result_array['created']) > 0);
$updated = (isset($result_array['updated']) and count($result_array['updated']) > 0);
$errors = (isset($result_array['error']) and count($result_array['error']) > 0);


if ($created) {
  // show the data that was created
  $data['have_created'] = 1;
  $data['created'] = table($result_array['created'], '', 'created');
}
if ($errors) {
  // show the data that wasn't created
  $data['have_error'] = 1;
  $data['error'] = table($result_array['error'], '', 'error');
}
if ($updated) {
  // show the data that was updated
  $data['have_updated'] = 1;
  $data['updated'] = table($result_array['updated'], '', 'udpated');
}



$data['type'] = $form_data['type'] ? 'users' : 'courses';
$data['return_url'] = new moodle_url('/blocks/externalsync/pages/upload.php');

print $OUTPUT->header();
print $OUTPUT->render_from_template('block_externalsync/created_data', $data);
print $OUTPUT->footer();