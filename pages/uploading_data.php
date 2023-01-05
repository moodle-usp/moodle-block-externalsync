<?php
/**
 * In this page the user can to see the data loaded,
 * and now it needs to be confirmed to be finally 
 * uploaded.
 */

require_once('../../../config.php');
global $PAGE, $OUTPUT;

// page configs
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('pluginname', 'block_externalsync'));

print $OUTPUT->header();


/* FUNCTIONS */
/* Creates the courses from the uploaded CSV file */
function createCourses ($courses) {
  foreach ($courses as $course) {
      // Create the course in Moodle
      $newcourse = new \stdClass();
      $newcourse->shortname = $course['name'];
      $newcourse->fullname = $course['name'];
      $newcourse->summary = 'Este é o sumário';
      $newcourse->idnumber = 123;
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


/* TREATMENT */
// load the loading view
$action = "Creating courses..."; // "Uploading users", "Synchronizing", etc
print "<div style='text-align: center'>" . $action . "</div>";
$view = file_get_contents('../templates/loading.html');
print $view;

// receive the data
$type = $_SESSION['type'];
$data_array = $_SESSION['uploadedData'];

if ($type == 'course')    createCourses($data_array);
else if ($type == 'user') createUsers($data_array);


/* FOOTER */
print $OUTPUT->footer();