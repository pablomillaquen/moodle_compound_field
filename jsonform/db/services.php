<?php

$services = array(
      'jsonformservice' => array(                      //the name of the web service
          'functions' => array ('local_jsonform_loadjson', 'local_jsonform_updatejson', 'local_jsonform_getform'), //web service functions of this service
          'requiredcapability' => '',                //if set, the web service user need this capability to access 
                                                     //any function of this service. For example: 'some/capability:specified'                 
          'restrictedusers' =>0,                      //if enabled, the Moodle administrator must link some user to this service
                                                      //into the administration
          'enabled'=>1,                               //if enabled, the service can be reachable on a default installation
          'shortname'=>'jsonformservice' //the short name used to refer to this service from elsewhere including when fetching a token
       )
  );

$functions = array(
    'local_jsonform_loadjson' => array(
        'classname' => 'local_jsonform_external',
        'methodname' => 'loadjson',
        'classpath' => 'local/jsonform/externallib.php',
        'description' => 'Load json data for compound user profile type',
        'type' => 'read',
        'ajax' => true,
        'loginrequired' => true,
    ),
    'local_jsonform_updatejson' => array(
        'classname' => 'local_jsonform_external',
        'methodname' => 'updatejson',
        'classpath' => 'local/jsonform/externallib.php',
        'description' => 'Update json data to compound user profile type',
        'type' => 'write',
        'ajax' => true,
        'loginrequired' => true,
    ),  
    'local_jsonform_getform' => array(
        'classname' => 'local_jsonform_external',
        'methodname' => 'getform',
        'classpath' => 'local/jsonform/externallib.php',
        'description' => 'Get structure of custom fields',
        'type' => 'read',
        'ajax' => true,
        'loginrequired' => true,
    )  
);