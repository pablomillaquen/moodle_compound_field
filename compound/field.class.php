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
    

    /**
     * Adds the profile field to the moodle form class
     *
     * @param moodleform $mform instance of the moodleform class
     */
    function edit_field_add($mform) {
        $mform->addElement('html', '<div class="text-center"><a href="/local/jsonform/index.php?userid='.$this->userid.'&fieldid='.$this->field->id.'" class="btn btn-secondary mb-3">Administrar '.$this->field->name.'</a></div>');
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
                if(isset($item->title)){
                    array_push($titles, $item->title);
                }
            }
        }
        
        $data = parent::display_data();
        $dataform = json_decode($data);
        $data = '';
        if(isset($dataform)){
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
        }
        
       
        return $data;
    }

    /**
     * Sets the default data for the field in the form object
     *
     * @param moodleform $mform instance of the moodleform class
     */
    function edit_field_set_default($mform) {
   
    }

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


