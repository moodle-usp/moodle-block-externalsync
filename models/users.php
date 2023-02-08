<?php
/**
 * Here we have some functions that use tables of users
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once('sync.php');

/* Search for the user using the field sent */
function getUser ($user_data, $fields) {
  global $DB;

  foreach ($fields as $field) {
    $user = $DB->get_record('user', [$field => $user_data[$field]]);
    if ($user) {
      $user->cause = $field;
      return $user;
    }
  }
  return false;  
}

/* Creates the users from some array */
function createUsers ($users) {
  $result = array(
    'created' => array(),
    'updated' => array()
  );

  foreach ($users as $user) {
    // user object
    $newuser = new stdClass();
    $newuser->email = $user['email'];
    $newuser->username = $user['username'];
    $newuser->firstname = $user['firstname'];
    $newuser->lastname = $user['lastname'];
    
    //check if the user is already in database
    $db_user = getUser($user, ['username', 'email']);

    // if the user doens't exists, $db_user is false
    if ($db_user) {
      // update
      $newuser->id = $db_user->id;
      user_update_user($newuser);

      // save
      $user['cause'] = $db_user->cause;
      $result['updated'][] = $user;
    } 
    else {
      // create
      user_create_user($newuser);

      // save
      $result['created'][] = $user;
    }

    // try to sync with the respective user in external system
    syncUser($user);

    // verify if user course is empty
    if (empty($user['course'])) continue;
    // else, try to sync
    subscribeUser($user);
    
  }
  return $result;
}