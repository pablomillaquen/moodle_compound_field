<?php

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
 * External Web Service
 *
 * @package    local_jsonform
 * @copyright 2020 Pablo Millaquén {@link http://mltecnologias.cl}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");

class local_jsonform_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function loadjson_parameters() {
        return new external_function_parameters(
                array(
                    'userid' => new external_value(PARAM_INT, 'The user id'),
                    'fieldid' => new external_value(PARAM_INT, 'The field id')
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function loadjson($userid, $fieldid) {
        global $DB;
        //$params = self::validate_parameters(self::getExample_parameters(), array());
        $params = self::validate_parameters(self::loadjson_parameters(), 
                array('userid'=>$userid, 'fieldid'=>$fieldid));

        $sql = 'SELECT data FROM {user_info_data} WHERE userid = ? AND fieldid = ?';
        $paramsDB = $params; //array($itemid);
        $db_result = $DB->get_records_sql($sql,$paramsDB);
        
        return $db_result;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function loadjson_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'data' => new external_value(PARAM_NOTAGS, 'Data for json form'),
                )
            )
        );
    }


    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function updatejson_parameters() {
        return new external_function_parameters(
                array(
                    'userid' => new external_value(PARAM_INT, 'The user id'),
                    'fieldid' => new external_value(PARAM_INT, 'The field id'),
                    'data' => new external_value(PARAM_TEXT, 'The json data', VALUE_DEFAULT, ''),
                    'dataformat' => new external_value(PARAM_INT, 'The format data'),
                    'type' => new external_value(PARAM_TEXT, 'The type of process', VALUE_DEFAULT, '')
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function updatejson($userid, $fieldid, $data, $dataformat = 1, $type) {
        global $DB;
        if($type == 'u'){//Edit
            $params = self::validate_parameters(self::updatejson_parameters(), 
                array('data'=>$data ,'dataformat'=>$dataformat, 'userid'=>$userid, 'fieldid'=>$fieldid));

            $sql = 'UPDATE {user_info_data} SET data = ?, dataformat = ? WHERE userid = ? AND fieldid = ?';
            $paramsDB = array($data, $dataformat, $userid, $fieldid); //array($itemid);
            $db_result = $DB->execute($sql,$paramsDB);
        }else{ //Save
            $params = self::validate_parameters(self::updatejson_parameters(), 
                array('userid'=>$userid, 'fieldid'=>$fieldid, 'data'=>$data ,'dataformat'=>$dataformat ));

            $sql = 'INSERT INTO {user_info_data} (userid, fieldid, data, dataformat) VALUES (?, ?, ?, ?)';
            $paramsDB = $params; //array($itemid);
            $db_result = $DB->execute($sql,$paramsDB);
        }
        
        return $db_result;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function updatejson_returns() {
        return null;
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function getform_parameters() {
        return new external_function_parameters(
                array(
                    'fieldid' => new external_value(PARAM_INT, 'The field id')
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function getform($fieldid) {
        global $DB;
        $params = self::validate_parameters(self::getform_parameters(), 
                array('fieldid'=>$fieldid));

        $sql = 'SELECT param1 FROM {user_info_field} WHERE id = ?';
        $paramsDB = $params; //array($itemid);
        $db_result = $DB->get_records_sql($sql,$paramsDB);
        
        return $db_result;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function getform_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'param1' => new external_value(PARAM_NOTAGS, 'custom form structure'),
                )
            )
        );
    }
}
