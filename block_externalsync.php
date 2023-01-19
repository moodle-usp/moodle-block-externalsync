<?php

require_once('utils/render_template.php');

class block_externalsync extends block_base {
	public function init () {
		$this->title = '📁 ' . get_string('pluginname', 'block_externalsync'); // "ExternalSync"
		}
	
	public function get_content () {
		global $OUTPUT;

		// block content
		$this->content = new stdClass;
		
		// href to view
		$url = new moodle_url('/blocks/externalsync/pages/upload.php');
		$this->content->text = $OUTPUT->render_from_template('block_externalsync/extsync_block', ['url' => $url]);
		
		return $this->content;
		}
}
