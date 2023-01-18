<?php

class block_externalsync extends block_base {
	public function init () {
		$this->title = get_string('pluginname', 'block_externalsync'); // "ExternalSync"
		}
	
	public function get_content () {
		
		// block content
		$this->content = new stdClass;

		$this->content->text = ""; // empty page
		
		// an empty view
		$url = new moodle_url('/blocks/externalsync/pages/upload.php');		
		$this->content->footer = html_writer::link($url, 'Upload');
		
		return $this->content;
		}
}
