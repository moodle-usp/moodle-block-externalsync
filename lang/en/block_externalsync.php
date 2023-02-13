<?php

defined('MOODLE_INTERNAL') || die();

// main
$string['pluginname']               = 'External Sync';
$string['main_msg']                 = 'Here you can to upload your courses and users using CSV files.';

// types
$string['type_courses']             = 'courses';
$string['type_users']               = 'users';

// form to upload files
$string['form_uploadTitle']         = 'Upload Files';
$string['form_description']         = 'Description';
$string['form_type']                = 'Type';
$string['form_replace']             = 'Replace the data if already exists.';
$string['form_csvFile']             = 'CSV File';

// errors
$string['error_emptyData']          = 'Empty data. Please, try again.';
$string['error_invalidFile']        = 'Invalid file uploaded. Please, verify if you choose the correct type.';
$string['error_onUploading']        = 'There is an error when uploading data!<br>Please, try again.';
$string['error_courseDoesntExist']  = "The course {$a} doesn't exist.";

// data confirmation
$string['dataConfirmation_msg']     = 'Confirm the data you want to upload';

// created data
$string['createdData_errorTitle']   = 'Errors';
$string['createdData_errorMsg']     = 'These {$a} already are in the database.';
$string['createdData_updatedTitle'] = 'Updated';
$string['createdData_updatedMsg']   = 'These {$a} was successfully updated.';
$string['createdData_createdTitle'] = 'Created';
$string['createdData_createdMsg']   = 'These {$a} was successfully created.';

// buttons
$string['button_upload']            = 'Upload';
$string['button_confirm']           = 'Confirm';
$string['button_return']            = 'Return';

// tables
$string['table_title']              = 'Table {$a->tableName}';