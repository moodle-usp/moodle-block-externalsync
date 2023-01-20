<?php
/**
 * Here the user will can see the uploaded data, with well-succeded creations and
 * the errors if it was.
 */

// Page configurations
require_once('../../../config.php');
global $PAGE, $OUTPUT;

$url = new moodle_url("/blocks/externalsync/processing.php");
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));
$PAGE->set_pagelayout('admin');
require_login();

// requires
require_once('../utils/visuals.php'); // some visual functions (table)
require_once('../utils/error.php'); // error msg

// get the data from Session
$result_array = $_SESSION['data_array'];
$form_data = $_SESSION['form_data'];
// unset for security
unset($_SESSION['result']);
unset($_SESSION['form_data']);

// if the data is empty or not set, so we have error
if (empty($result_array) or is_null($result_array) or empty($form_data) or is_null($form_data)) 
  error_msg_redirect('Empty data. Try again.', 'pages/upload.php');

// to send to view
$data = array();

foreach ($result_array as $key=>$arrays) {
  if (count($arrays) > 0) {
    $data['have_' . $key] = 1;
    $data[$key] = table($arrays, '', $key);
  }
}

$data['type'] = $form_data['type'] ? 'users' : 'courses';
$data['return_url'] = new moodle_url('/blocks/externalsync/pages/upload.php');

print $OUTPUT->header();
print $OUTPUT->render_from_template('block_externalsync/created_data', $data);
print $OUTPUT->footer();