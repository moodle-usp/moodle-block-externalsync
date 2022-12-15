<?php

// Page configurations
require_once('../../../config.php');
require_once($CFG->dirroot.'/course/lib.php');

global $PAGE, $OUTPUT;

$PAGE->set_pagelayout('standard');
// TODO: we need to fix the strings references to use get_string instead of the strings directly
//$PAGE->set_heading(get_string('page', 'externalsync');
$PAGE->set_heading('External Sync');

print $OUTPUT->header();

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

/* Gets the file name uploaded via form */
function getUploadedCSVFileName ($type) {
    // TODO: what is the correct way to get the file in Moodle? optional_param?
    $csv = $_FILES[$type];
    $csv_name = $csv['tmp_name'];
    return $csv_name;
}

/* Creates the courses from the uploaded CSV file */
function createCourses ($courses) {
    // debbug
    echo 'creating courses...';
    foreach ($courses as $course) {
        // Create the course in Moodle
        $newcourse = new \stdClass();
        $newcourse->shortname = $course['name'];
        $newcourse->fullname = $course['name'] ;
        $newcourse->description = $course['name'];
        $newcourse->summary = $course['name'];
        $newcourse->idnumber = 999;
        $newcourse->visible = 1;
    
        $newcourse->format = get_config('moodlecourse', 'format');
        $newcourse->numsections = get_config('moodlecourse', 'numsections');
        $newcourse->summaryformat = FORMAT_HTML;
    
        // convert the date strings to time
        $start_time = strtotime($course['start']);
        $end_time = strtotime($course['end']);
    
        $newcourse->startdate = $start_time;
        $newcourse->enddate = $end_time;
        $newcourse->timemodified = time();
    
        $newcourse->category = 1;
        
        // To enable the course creation, just uncomment the line bellow
        // $created_course = \create_course($newcourse);
    
        // TODO: We need to register the new courses in the tables that make the relationship between Verão and Moodle
        // Register in the externalsync_courses table
        // $created_course->id 
    }
}

/* Creates the users from the uploaded CSV file */
function createUsers ($users) {
    // debbug
    echo 'creating users...';
    foreach ($users as $user) {
        // do something...
    }
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


// verify if is defined the sent confirmation
$confirmed = $_POST['confirmation'];
if (isset($confirmed)) {
    // get the array and type from the session
    session_start();
    $uploadedData = $_SESSION['data_array'];
    $type = $_SESSION['type'];
    
    // insert into database
    if ($type == 'course')
        createCourses($uploadedData);
    else if ($type == 'user')
        createUsers($uploadedData);
}
// if not, so is the confirmation time!
else {
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
    session_start();
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
    else
        print 'there is a problem :(';
}

print $OUTPUT->footer();