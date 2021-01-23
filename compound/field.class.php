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
 * @package    profilefield_compound
 * @category   profilefield
 * @copyright  2012 Rajesh Taneja
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class profile_field_compound extends profile_field_base {

    
    /** @var int $datakey */
    public $fieldid;

    /**
     * Constructor
     *
     * Pulls out the options for compound from the database and sets the
     * the corresponding key for the data if it exists
     *
     * @param int $fieldid id of user profile field
     * @param int $userid id of user
     */
    public function __construct($fieldid = 0, $userid = 0, $fielddata = null) {
        // First call parent constructor.
        parent::__construct($fieldid, $userid, $fielddata);

        $this->fieldid = $fieldid;
    }
    // public function __construct($fieldid = 0, $userid = 0, $fielddata = null) {

    //    require_once(__DIR__ . '/../../../../config.php');

    //     global $USER, $CFG;
    //     // First call parent constructor.
    //     parent::__construct($fieldid, $userid, $fielddata);

    //     // // Param 1 for menu type is the options.
    //     // if (isset($this->field->param1)) {
    //     //     $options = explode("\n", $this->field->param1);
    //     // } else {
    //     //     $options = array();
    //     // }
    //     // $this->options = array();
    //     // if (!empty($this->field->required)) {
    //     //     $this->options[''] = get_string('choose').'...';
    //     // }
    //     // foreach ($options as $key => $option) {
    //     //     // Multilang formatting with filters.
    //     //     $this->options[$option] = format_string($option, true, ['context' => context_system::instance()]);
    //     // }

    //     // // Set the data key.
    //     // if ($this->data !== null) {
    //     //     $key = $this->data;
    //     //     if (isset($this->options[$key]) || ($key = array_search($key, $this->options)) !== false) {
    //     //         $this->data = $key;
    //     //         $this->datakey = $key;
    //     //     }
    //     // }
    // }
    // function profile_field_compound($fieldid=0, $userid=0) {
    //     global $DB;
    //     //first call parent constructor
    //     parent::__construct($fieldid, $userid);

    //     if (!empty($this->field)) {
    //         $datafield = $DB->get_field('user_info_data', 'data', array('userid' => $this->userid, 'fieldid' => $this->fieldid));
    //         if ($datafield !== false) {
    //             $this->data = $datafield;
    //         } else {
    //             $this->data = $this->field->defaultdata;
    //         }
    //     }
    // }

    /**
     * Adds the profile field to the moodle form class
     *
     * @param moodleform $mform instance of the moodleform class
     */
    function edit_field_add($mform) {
        //$PAGE->requires->js('/local/staffmanager/assets/staffmanager.js');
        //$this->page->requires->js('/user/profile/field/compound/metodo.js',true);
        //$mform->addElement('button',  'add_json_element'.$this->field->id,  format_string("Agregar ".$this->field->name));
        //var_dump($this->userid);
        $mform->addElement('html', '<div class="text-center"><a href="/local/jsonform/index.php?userid='.$this->userid.'&fieldid='.$this->field->id.'" class="btn btn-secondary mb-3">Administrar '.$this->field->name.'</a></div>');
        //$this->content->text = $OUTPUT->action_link('/user/profile/field/compound/myajaxscript.php', 'clickit', new component_action('click', 'block_myblock_sendemail'));
        // $size = $this->field->param1;
        // $maxlength = $this->field->param2;
        // $fieldtype = ($this->field->param3 == 1 ? 'password' : 'text');

        // // Create the form field.
        // $mform->addElement($fieldtype, $this->inputname, format_string($this->field->name), 'maxlength="'.$maxlength.'" size="'.$size.'" ');
        // $mform->setType($this->inputname, PARAM_TEXT);
    }

    /**
     * Display the data for this field
     *
     * @return string data for custom profile field.
     */
    function display_data() {
        global $DB;
        $structure = $DB->get_record('user_info_field', ['id' => $this->fieldid]);

        $str = json_decode($structure->param1);
        $titles = [];
        foreach($str->properties as $s){
            foreach ($s->items->properties as $item) {
                array_push($titles, $item->title);
            }
        }
        
        $data = parent::display_data();
        $dataform = json_decode($data);
        $data = '';
        foreach($dataform as $d){
            foreach($d as $key=>$value){
                $data .=  '<hr>';
                $data .= '<ul>';
                $i=0;
                foreach ($value as $k => $v) {
                    $data .= "<li><b>".$titles[$i]."</b>: ".$v."</li>";
                    $i++;
                }
                $data .=  '</ul>';
            }
        }
       
        return $data;
    }

    /**
     * Sets the default data for the field in the form object
     *
     * @param moodleform $mform instance of the moodleform class
     */
    function edit_field_set_default($mform) {
        //if (!empty($default)) {
            //$mform->setDefault($this->inputname, $this->field->defaultdata);
        //}
    }

    /**
     * Validate the form field from profile page
     *
     * @param stdClass $usernew user input
     * @return string contains error message otherwise NULL
     **/
    // function edit_validate_field($usernew) {

    // }

    /**
     * Process the data before it gets saved in database
     *
     * @param stdClass $data from the add/edit profile field form
     * @param stdClass $datarecord The object that will be used to save the record
     * @return stdClass
     */
    function edit_save_data_preprocess($data, $datarecord) {
        $data->defaultdata = '';
        return $data;
    }

    /**
     * HardFreeze the field if locked.
     *
     * @param moodleform $mform instance of the moodleform class
     */
    function edit_field_set_locked($mform) {
        if (!$mform->elementExists($this->inputname)) {
            return;
        }
        if ($this->is_locked() and !has_capability('moodle/user:update', get_context_instance(CONTEXT_SYSTEM))) {
            $mform->hardFreeze($this->inputname);
            $mform->setConstant($this->inputname, $this->data);
        }
    }
}


