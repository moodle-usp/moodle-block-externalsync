<?php
/**
 * Here the data will be processed. It means that the data is received, the CSV files are
 * transformed to array, the user needs to confirm the upload and the system try to upload
 * the data.
 */

// Page configurations
require_once('../../../config.php');
global $PAGE, $OUTPUT;

$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));
$PAGE->set_pagelayout('admin');
require_login();

// requires
require_once('../utils/forms.php'); // forms (to get uploaded data and submit data)
require_once('../utils/csv.php'); // some CSV functions
require_once('../utils/visuals.php'); // some visual functions (table)

// confirmation form
$confirmation_form = new confirmationform();
$confirmed = $confirmation_form->get_data();

// if $confirmed is something, so we can save the data in database
if (!empty($confirmed) and !is_null($confirmed)) {
  print $OUTPUT->header();

  // get the data sent in session
  $uploadedData = $_SESSION['data_array'];
  $request = $_SESSION['form_data'];
  unset($_SESSION['data_array']);
  unset($_SESSION['form_data']);

  // creating courses
  if ($request->type == 0) {
    require_once('../models/courses.php'); 

    $result = createCourses($uploadedData);
    $_SESSION['result'] = $result;
    $url = new moodle_url('visualize.php');
    redirect($url);
  }
  // creating users
  else {
    print 'upload users etc etc';
  }
}
// else, so the data need to be confirmed
else {
  // upload form
  $form = new uploadform();
  $request = $form->get_data();

  // if request is somthing, so we have data
  if (!empty($request) and !is_null($request)) {
    
    // if we have data, so we need to process this data
    try {
      $uploadedData = csvToArray($form->get_file_content('file'));
    } catch (Exception $e) {
      \core\notification::error('Invalid file uploaded.');
      redirect($CFG->wwwroot . '/blocks/block_externalsync/upload.php');
    }

    verifyArray($uploadedData, $request->type);

    // TODO: If the user just go out, the data stay in session. We need to garantee that
    // this data don't stay in session. How we can do this?
    // save in session
    $_SESSION['data_array'] = $uploadedData;
    $_SESSION['form_data'] = $request;

    // after processing, its nice to view this data in a table
    $uploadedData_table = table($uploadedData, 'Table "' . $request->description . '"');
    $data = array(
      'table'=> $uploadedData_table, 
      'msg' => 'Confirm the data you want to upload.'
    );

    print $OUTPUT->header();

    print $OUTPUT->render_from_template('block_externalsync/data_view', $data);

    // confirmation button
    print $confirmation_form->render();
  }
  // else, so we have no data so its an error!
  else
    \core\notification::error('There is an error when uploading data!<br>Go back to upload page and try again.');
}