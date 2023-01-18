<?php
/**
 * Some visual facilities.
 * 
 * Here we have:
 * - table ($data, $title="", $colClass="");
 * - ...
 */

// Show the data created and the data that wasn't created
function table ($data, $title="", $colClass="") {
  // creates a table to show the data
  $table = new html_table();
  $table->head = array_keys($data[0]);
  $table->data = $data;
  if ($title != "")
    $table->caption = $title;
  if ($colClass != "") {
    for ($i = 0; $i < count($table->head); $i++) {
      $table->colclasses[$i] = $colClass;
    }
  }
  return html_writer::table($table);
}
