<?php
/**
 * Here you can to see the data uploaded and you need 
 * to confirm that you really want to upload this data
 * to the system.
 * 
 * This uses the 'confirmation.html' template, and send to the
 * 'uploading_data.php' page.
 */

// Page configurations
require_once('../../../config.php');
require_once($CFG->dirroot.'/course/lib.php');

global $PAGE, $OUTPUT;

$PAGE->set_pagelayout('standard');
// TODO: we need to fix the strings references to use get_string instead of the strings directly
//$PAGE->set_heading(get_string('page', 'externalsync');
$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));

print $OUTPUT->header();

/* Functions */

/* Gets the file name uploaded via form */
function getUploadedCSVFileName ($type) {
    // TODO: what is the correct way to get the file in Moodle? optional_param?
    $csv = $_FILES[$type];
    $csv_name = $csv['tmp_name'];
    return $csv_name;
}
  
/* This function reads a csv file with header and output its data as an array */
function csvToArray ($csvFile) {
    // open the file
    $file_to_read = fopen($csvFile, 'r');
    if (!$file_to_read) {
        print 'File not found :(';
        return;
    }
    // get the header of CSV
    $header = fgetcsv($file_to_read, 1000, ',');
    // tests for end-of-file (eof) on a file pointer
    while (!feof($file_to_read)) {
        // get line
        $line = fgetcsv($file_to_read, 1000, ',');
        // if the line is blank then the file is finished
        if (empty($line)) break;
        // else, it needs to be added to the array
        $lines[] = array_combine($header, $line);
    }
    // close the file
    fclose($file_to_read);
    return $lines;
}

/* Show data to create */
function showDataToCreate ($data) {
    // if the number of rows is zero, the function can't continue
    if (count($data) == 0)
        return; // TODO: Add some error message or treatment

    // creates a table to show the data
    $table = new html_table();
    $table->head = array_keys($data[0]);
    $table->data = $data;

    print html_writer::table($table);
}


// checks the type of the uploaded csv file (0: course | 1: user)
// TODO: is the "hidden" input type the correct way to do this?
$type = $_POST['type'] == 0 ? 'course' : 'user';

// get and convert the uploaded CSV file
$filename = getUploadedCSVFileName($type);
$uploadedData = csvToArray($filename);

// show the information
showDataToCreate($uploadedData);

// view with the confirmation form
$view = file_get_contents('../templates/confirmation.html');

// save the array and the type in session
$_SESSION['data_array'] = $uploadedData;
$_SESSION['type'] = $type;

if ($type == 'course') {
    print "<p>Do you really want to create these courses?</p>";
    print $view;
    // createCourses($uploadedData);
}
else if ($type == 'user') {
    print "<p>Do you really want to create these users?</p>";
    print $view;
    // createUsers($uploadedData);
}
// TODO: Error treatment!
else
    print 'there is a problem :(';

print $OUTPUT->footer();