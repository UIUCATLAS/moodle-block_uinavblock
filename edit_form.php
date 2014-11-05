<?php
 /*   _ _____   _   _            ______ _            _    
| | | |_   _| | \ | |           | ___ \ |          | |   
| | | | | |   |  \| | __ ___   _| |_/ / | ___   ___| | __
| | | | | |   | . ` |/ _` \ \ / / ___ \ |/ _ \ / __| |/ /
| |_| |_| |_  | |\  | (_| |\ V /| |_/ / | (_) | (__|   < 
 \___/ \___/  \_| \_/\__,_| \_/ \____/|_|\___/ \___|_|\_\	
 Copyright 2014 dandavis/University of Illinois at Urbana Champaign [CCBY2.0] or better.
 
 Moodle Block Configure Form PHP
*/

class block_uinavblock_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
 
        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
 
			
		// show moodle section numbers in nav item text?
		$mform->addElement(
			'advcheckbox', 
			'config_shownumbers', 
			get_string('label_shownums', 'block_uinavblock'), 
			get_string('desc_shownums', 'block_uinavblock', 'Show section numbers'),
			array('group' => 1), array(0, 1)
		);	
		$mform->setDefault('config_shownumbers', 1);
		$mform->setType('config_shownumbers', PARAM_MULTILANG);
	
	
		// show moodle section titles in nav item text?
		$mform->addElement(
			'advcheckbox', 
			'config_showtitles', 
			get_string('label_showtitles', 'block_uinavblock'), 
			get_string('desc_showtitles', 'block_uinavblock', 'Show section titles'),
			array('group' => 1), array(0, 1)
		);	
		$mform->setDefault('config_showtitles', 1);
		$mform->setType('config_showtitles', PARAM_MULTILANG);
	
		
		// A vertical layout config option
		$mform->addElement(
			'advcheckbox', 
			'config_vertical', 
			get_string('label_vertical', 'block_uinavblock'), 
			get_string('desc_vertical',  'block_uinavblock', 'Alternate Layout'),
			array('group' => 1), array(0, 1)
		);	
		$mform->setDefault('config_vertical', 1);
		$mform->setType('config_vertical', PARAM_MULTILANG);
	
			
		// A page placement config option
		$mform->addElement(
			'advcheckbox', 
			'config_showwithcontent', 
			get_string('label_placement', 'block_uinavblock'), 
			get_string('desc_placement',  'block_uinavblock', 'Layout Alternate'),
			array('group' => 1), array(0, 1)
		);	
		$mform->setDefault('config_showwithcontent', 0);
		$mform->setType('config_showwithcontent', PARAM_MULTILANG);
	
			
		// A text label for users to see above the jump menu
		$mform->addElement(
			'text', 
			'config_caption', 
			get_string('label_caption', 'block_uinavblock'), 
			get_string('desc_caption',  'block_uinavblock', 'Caption Text'),
			array('group' => 1), array(0, 1)
		);	
		$mform->setDefault('config_caption', "Jump To");
		$mform->setType('config_caption', PARAM_MULTILANG);	
	
	
    }
}
