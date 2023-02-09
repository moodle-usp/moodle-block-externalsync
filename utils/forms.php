<?php
/**
 * Some forms that we use.
 */
require_once("$CFG->libdir/formslib.php");

// Form to upload the files
class uploadform extends moodleform {
  public function definition () {
    $this->_form->addElement('text', 'description', 'Description');
    $this->_form->addElement('select', 'type', 'Type', ['courses', 'users']);
    $this->_form->addElement('advcheckbox', 'replace', 'Replace the data if already exists.', array(), array(0,1));
    $this->_form->addElement('file', 'file', 'CSV File');
    $this->_form->addElement('submit', 'button', 'Upload');

    $this->_form->addRule('description', null, 'required');
    $this->_form->addRule('type', null, 'required');
    $this->_form->addRule('file', null, 'required');
  }
}

// Form to submit
class confirmationform extends moodleform {
  public function definition () {
    $this->_form->addElement('submit', 'button', 'Confirm');
  }
}