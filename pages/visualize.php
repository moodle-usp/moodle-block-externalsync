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

$errors = (count($result_array['error']) != 0);
$successes = (count($result_array['success']) > 0);

$data = array();

// if its all ok, it's nice to show the new data
if (count($result_array['success']) > 0) {
  $data['have_success'] = 1;
  $data['success'] = table($result_array['success'], '', 'sucess');
}

// TODO: we need to do something now. Go back to the page?
if ($errors) {
  // show the data that wasn't created
  $data['have_error'] = 1;
  $data['error'] = table($result_array['error'], '', 'error');
}

$data['type'] = $form_data->type ? 'users' : 'courses';
$data['return_url'] = new moodle_url('/blocks/externalsync/pages/upload.php');

print $OUTPUT->header();
print $OUTPUT->render_from_template('block_externalsync/created_data', $data);
print $OUTPUT->footer();