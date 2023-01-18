<?php
/**
 * Here we have some functions that use tables of courses
 */

/* Search for the course using the course 'shortname' */
function getCourse ($course_shortname) {
  global $DB;

  $course = $DB->get_record('course', ['shortname' => $course_shortname]);
  return $course;
}

/* Creates the courses from some array */
function createCourses ($courses) {
  $result = array(
    'success' => array(),
    'error' => array()
  );
  foreach ($courses as $course) {
    // check if the course already exists in database by its 'shortname'
    $db_course = getcourse($course['shortname']);
    // if the course doesn't exists, $db_coures is false
    if ($db_course) {
      // TODO: Error treatment
      $result['error'][] = $course;
      continue;
    }

    // If isn't in database, so we can create
    $newcourse = new stdClass;
    $newcourse->shortname = $course['shortname'];
    $newcourse->fullname = $course['fullname'];
    $newcourse->summary = 'This is summary'; // TODO
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

    // creating
    $created_course = \create_course($newcourse);

    // Add the course result to the original course object
    // $course['result'] = $created_course;

    // save in the $sucess_courses array
    $result['success'][] = $course;

    // TODO: We need to registyer the new courses in the tables that make the relationship between Verao and Moodle
    // Register in the externalsync_courses table
    // $created_course->id
  }
  return $result;
}