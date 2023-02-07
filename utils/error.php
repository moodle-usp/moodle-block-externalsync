<?php
/**
 * Error Treatment
 * 
 * Some errors messages etc.
 */

/* Show some error message and redirect to another page. */
// if the page header is loaded, the message will fail
function error_msg_redirect ($msg, $dir) {
  \core\notification::error($msg);
  $url = new moodle_url('/blocks/externalsync/' . $dir);
  redirect($url);
}