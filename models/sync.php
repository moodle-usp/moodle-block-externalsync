<?php
/**
 * Here we have some functions that synchronize users with courses, 
 * including the subscription in courses and the externalsync_user_course
 * data.
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/user/lib.php');

/* Subscribe a user in some course */
function subscribeUser ($user) {
  global $DB;
  // user informations
  $course_shortname = $user['course'];
  $user_role        = $user['role'];
  
  // get the course
  $course = $DB->get_record('course', ['shortname' => $course_shortname]);

  // if the course doesn't exists, show error message
  if (empty($course)) {
    \core\notification::error("The course $course_shortname doesn't exist.");
    return false;
  }

  // get the user in db
  $userdb = $DB->get_record('user', ['username'=>$user['username']]);

  // moodle instance
  $instances = enrol_get_instances($course->id, true);
  $instance = array_values($instances)[0];
  $plugin = enrol_get_plugin('manual');

  // role assignment
  $plugin->enrol_user($instance, $userdb->id, $course->id);
  // if user_role is empty so use student;
  if (empty($user_role))
    $user_role = "student";
  // get role info
  $role = $DB->get_record("role", ["shortname" => $user_role]);
  // $context = context_system::instance();
  $context = context_course::instance($course->id);
  role_assign($role->id, $userdb->id, $context->id);

  // sync on the plugin table
  $DB->insert_record('externalsync_user_course', array(
    'user_id' => $userdb->id,
    'course_id' => $course->id,
    'sync_date' => time(),
    'log' => ''
  ));

  return true;
}

/* Sync an user here to external account of the same user */
function syncUser ($user) {
  global $DB;

  // get the user in Moodle database
  $userdb = $DB->get_record('user', ['username'=>$user['username']]);

  // insert into databse
  $DB->insert_record('externalsync_users', array(
    'user_moodle_id' => $userdb->id,
    'user_external_id' => $user['id'],
    'sync_date' => time(),
    'log' => ''
  ));

  return true;
}