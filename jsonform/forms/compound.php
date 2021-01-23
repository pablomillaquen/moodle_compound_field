<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Displays information about all the assignment modules in the requested course
 *
 * @package   local_jsonform
 * @copyright 2020 Pablo Millaquén {@link http://mltecnologias.cl}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once("$CFG->libdir/formslib.php");

class compound_form extends moodleform{

	//Add elements to form
	public function definition(){
		global $CFG;

		$mform = $this->_form;
		
		$mform->addElement('hidden', 'userid', '', 'id="userid"');
		$mform->setType('userid', PARAM_INT);
		$mform->setDefault('userid', 0);

		$mform->addElement('hidden', 'fieldid', '', 'id="fieldid"');
		$mform->setType('fieldid', PARAM_INT);
		$mform->setDefault('fieldid', 0);

		$mform->addElement('hidden', 'data', '', 'id="data"');
		$mform->setType('data', PARAM_TEXT);
		$mform->setDefault('data', '');

		$mform->addElement('hidden', 'dataformat', '');
		$mform->setType('dataformat', PARAM_INT);
		$mform->setDefault('dataformat', 0);
	}

	public function validation($data, $files){
		return array();
	}
}