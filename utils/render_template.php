<?php
/**
 * To render templates more easily!
 */

$dirname = 'block_externalsync/';

function render_template ($template_name, $data="") {
  global $OUTPUT, $dirname;

  return $OUTPUT->render_from_template($dirname . $template_name, $data);
}