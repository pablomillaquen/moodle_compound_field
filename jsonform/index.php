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

require_once '../../config.php';
global $USER, $DB, $CFG;

require_once("forms/compound.php");

$PAGE->set_url('/local/jsonform/index.php');
$PAGE->set_context(context_system::instance());

require_login();

$userid = optional_param('userid', '', PARAM_TEXT); 
$fieldid = optional_param('fieldid', '', PARAM_TEXT);

if(!$userid || !$fieldid){
	redirect($CFG->wwwroot.'/user/profile.php');
}

$mform = new compound_form();
$toform = [];


require_login();


$obj = $DB->get_record('user_info_field', ['id' => $fieldid]);

$strpagetitle = get_string('jsonform', 'local_jsonform');
$strpageheading = get_string('jsonform', 'local_jsonform');


$PAGE->set_title($strpagetitle." ".$obj->name);
$PAGE->set_heading($strpageheading." ".$obj->name);

$PAGE->requires->js_call_amd('local_jsonform/jsform', 'init', array($userid, $fieldid));


$results = new stdClass();

$options = trim(preg_replace('/\s\s+/', ' ', $obj->param1));

$results->options = htmlspecialchars($options, ENT_QUOTES, 'UTF-8');
$results->lang = "es";
$results->userid = $userid;
$results->fieldid = $fieldid;

$formcompound = new stdClass();
$formcompound->userid = $userid;
$formcompound->fieldid = $fieldid;
$toform = $formcompound;
$mform->set_data($toform);
$fromform = $mform->get_data();

echo $OUTPUT->header();

echo $OUTPUT->render_from_template('local_jsonform/templateform', $results);

$mform->display();

echo $OUTPUT->footer();