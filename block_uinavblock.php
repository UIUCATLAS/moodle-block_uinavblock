<?php
/*   _ _____   _   _            ______ _            _    
| | | |_   _| | \ | |           | ___ \ |          | |   
| | | | | |   |  \| | __ ___   _| |_/ / | ___   ___| | __
| | | | | |   | . ` |/ _` \ \ / / ___ \ |/ _ \ / __| |/ /
| |_| |_| |_  | |\  | (_| |\ V /| |_/ / | (_) | (__|   < 
 \___/ \___/  \_| \_/\__,_| \_/ \____/|_|\___/ \___|_|\_\	
 Copyright 2014 dandavis/University of Illinois at Urbana Champaign [CCBY2.0] or better.
 
 Moodle Block main PHP code
*/

class block_uinavblock extends block_base {

	
    public function init() { // required by moodle
        $this->title = get_string('uinavblock', 'block_uinavblock');
    }
	
	//saves block config to moodle DB:
	public function instance_config_commit( $nolongerused = false  ) {
		global $DB;
		return $DB->set_field('block_instances','configdata', base64_encode(serialize($this->config)) ,  array('id' =>$this->instance->id));
	}
	
	public function get_content() {
	
		global $PAGE;
		
		//use a cached copy if available:
		if ($this->content !== null) {
		  return $this->content;
		}
	 
		//gather needed config data into local variables:
		$course = $this->page->course;
		$courseformat = course_get_format($course);
		$courseformatoptions = $courseformat->get_format_options();
		$context = context_course::instance($course->id);

			
		if(!$this->config){ //set defaults for first-time load
			$this->config=  new stdClass;
			$this->config->isDefault= 1;
			$this->config->shownumbers= 1;
			$this->config->showtitles= 1;
			$this->config->vertical= 1;
			$this->config->caption= get_string('default_caption', 'block_uinavblock') ;
			$this->config->showwithcontent= 0;

			// save these defaults in same format as user block configure menu:
			$this->instance_config_commit(); 
			
		}//end if no config (no custom config set using edit_form.php)
			
			
		//template for block interface content:
		$this->content         =  new stdClass;
		$this->content->text   = '';
		$this->content->footer = '';
		
		//we only want to jazz up weeks and topics, other formats don't make sense"
		if(  ! ( $course->format=="weeks" || $course->format=="topics"   )){
			return '';
		} 
		
		// make config settings available to client-side JS, which dynamically creates the jump menu:
		$this->content->text.= 	'<script>CourseNavConfig={
					cfg: ' .	 json_encode($course) .', ' . '
					numbers:'. 		$this->config->shownumbers 		.', ' . '
					titles:'. 		$this->config->showtitles 		.', ' . '
					vertical:'. 	$this->config->vertical 		.', ' . '
					caption:"'. 	$this->config->caption 			.'", ' . '
					placement:'. 	$this->config->showwithcontent 	. ', ' . '
					MSG_NO_FORMAT:'. 	json_encode(get_string('MSG_NO_FORMAT',	'block_uinavblock')) 	.', ' . '
					MSG_NO_ITEMS:'. 	json_encode(get_string('MSG_NO_ITEMS', 	'block_uinavblock')) 	.', ' . '
					MSG_NO_TARGET:'. 	json_encode(get_string('MSG_NO_TARGET',	'block_uinavblock')) 	. 
					
				"};</script>".
				"<div id=navblockcontainer></div>";

		// add block code to "all" JS bundler:
		$this->page->requires->js('/blocks/uinavblock/lib.js'); 
		return $this->content;
	}
	  
  
	public function html_attributes() { //sets attrib on moodle-created block sidebar section
		$attributes = parent::html_attributes(); // Get default values
		$attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute
		return $attributes;
	}



}  // end class
