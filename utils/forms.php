<?php
/**
 * Some forms that we use.
 */
require_once('../../../config.php');
require_once($CFG->libdir . "/formslib.php");

// Form to upload the files
class uploadform extends moodleform {
  public function definition () {
    $this->_form->addElement('text', 'description', get_string('form_description', 'block_externalsync'));
    $this->_form->addElement('select', 'type', get_string('form_type', 'block_externalsync'), [get_string('type_courses', 'block_externalsync'), get_string('type_users', 'block_externalsync')]);
    $this->_form->addElement('advcheckbox', 'replace', get_string('form_replace', 'block_externalsync'), array(), array(0,1));
    $this->_form->addElement('file', 'file', get_string('form_csvFile', 'block_externalsync'));
    
    $this->_form->addElement('submit', 'submitbutton', get_string('button_upload', 'block_externalsync'));
    $this->_form->addElement('cancel');

    $this->_form->addRule('description', null, 'required');
    $this->_form->addRule('type', null, 'required');
    $this->_form->addRule('file', null, 'required');
  }
}

// Form to submit
class confirmationform extends moodleform {
  public function definition () {
    $this->_form->addElement('submit', 'button', get_string('button_confirm', 'block_externalsync'));
    $this->_form->addElement('cancel');
  }
}