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


/* MISCELLANEOUS */
/* Search for the course using the course 'shortname' */
function getCourse ($course_shortname) {
  global $DB;

  $course = $DB->get_record('course', ['shortname' => $course_shortname]);
  return $course;
}

/* CREATION FUNCTIONS */
/* Creates the courses from the uploaded CSV file */
function createCourses ($courses) {
  $result = array('sucess' => array(), 'error' => array());
  foreach ($courses as $course) {
      // check if the course already exists in database by its 'shortname'
      $db_course = getCourse($course['shortname']);
      // if the course doesn't exists, $db_course is false
      if ($db_course) {
        // TODO: Error treatment
        print 'ERROR: The "' . $course['fullname'] . '" course already exists in database with the "' . $db_course->shortname . '" shortname and id ' . $db_course->id . '<br>';
        $result['error'][] = $course;
        continue;
      }

      // Create the course in Moodle
      $newcourse = new \stdClass();
      $newcourse->shortname = $course['shortname'];
      $newcourse->fullname = $course['fullname'];
      $newcourse->summary = 'Este é o sumário';
      $newcourse->idnumber = $course['id'];
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
      $created_course = \create_course($newcourse);
  
      // Add the course result to the original course object
      $course['result'] = $created_course;

      // Save in the $sucess_courses array
      $result['sucess'][] = $course;

      // TODO: We need to register the new courses in the tables that make the relationship between Verão and Moodle
      // Register in the externalsync_courses table
      // $created_course->id 
  }
  return $result;
}

/* Creates the users from the uploaded CSV file */
// OBS: ISN'T WORKING FOR NOW
function createUsers ($users) {
  // debbug
  echo 'creating users...';
  foreach ($users as $user) {
      // do something...
  }
}

/* FUNCTIONS OF SYNCHRONIZATION */
// This receives the $result_array and synchronize external course with internal (Moodle) course.
function synchronizeCourses ($result_array) {
  global $DB;
  
  // where the objects will be save
  $lines = array();

  foreach ($result_array as $course) {
    // add to the $lines array
    $lines[] = array(
      'course_moodle_id' => $course['result']->id,
      'course_external_id' => $course['id'],
      'sync_date' => 1, // TODO: Add a real datetime. How should this be done?
      'log' => 'patacabapa' // TODO: Add a real log. What 'real log' means?
    );
  }
  // try to add to database
  // TODO: we need to do some error treatment here too.
  $process_result = $DB->insert_records('mdl_externalsync_courses', $lines);
  
  return $process_result;
}


/* TREATMENT AND VIEW */
// load the loading view
$action = "Creating courses..."; // "Uploading users", "Synchronizing", etc
print "<div style='text-align: center'>" . $action . "</div>";
$view = file_get_contents('../templates/loading.html');
print $view;

// receive the data
$type = $_SESSION['type'];
$data_array = $_SESSION['data_array'];

if ($type == 'course') {
  // create the courses
  $result_array = createCourses($data_array);

  // Created the courses, it needs to be added in database to synchronize.
  // The course id in moodle, that is in the $sucess_courses, will be synchronized
  // with the external id.
  // OBS: ISN'T TOTALLY WORKING FOR NOW
  // $process_result = synchronizeCourses($result_array);
  
  // verify if errors array isn't empty
  $process_result = count($result_array['error']) == 0;

  // if its all ok, we can to go to home page
  if ($process_result)
    redirect(new moodle_url('../../../?redirect=0')); // this url is ugly...
  
  // TODO: we need to do something now. Go back to the page?
  else {
    
  }
}    
// OBS: ISN'T WORKING FOR NOW
else if ($type == 'user') {
  // create the users. 
  $result = createUsers($data_array);
}

/* FOOTER */
print $OUTPUT->footer();