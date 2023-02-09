<?php
/**
 * Here we have some functions that use tables of courses
 */

require_once('../../../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once('sync.php');

/* Search for the course using the course 'shortname' */
function getCourse ($course_shortname) {
  global $DB;

  $course = $DB->get_record('course', ['shortname' => $course_shortname]);
  return $course;
}

/* Creates the courses from some array */
function createCourses ($courses, $replace) {
  $result = array(
    'created' => array(),
    'error' => array()
  );
  foreach ($courses as $course) {
    // check if the course already exists in database by its 'shortname'
    $db_course = getCourse($course['shortname']);
    // if the course doesn't exists, $db_course is false
    if ($db_course and !$replace) {
      // TODO: Error treatment
      $result['error'][] = $course;
      continue;
    }
    
    $newcourse = new stdClass;
    $newcourse->shortname = $course['shortname'];
    $newcourse->fullname = $course['fullname'];
    $newcourse->summary = $course['summary'];
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

    // if is already in database, replace
    if ($db_course) {
      // update
      $newcourse->id = $db_course->id;
      update_course($newcourse);

      // save
      $result['updated'][] = $course;
    }
    // else, creates
    else {
      $created_course = \create_course($newcourse);
      
      // save in the $sucess_courses array
      $result['created'][] = $course;
    }

    // sync course
    syncCourse($course);

    // Add the course result to the original course object
    // $course['result'] = $created_course;

    // TODO: We need to registyer the new courses in the tables that make the relationship between Verao and Moodle
    // Register in the externalsync_courses table
    // $created_course->id
  }
  return $result;
}