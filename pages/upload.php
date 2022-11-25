<?php

require_once('../../../config.php');
require_once($CFG->dirroot.'/course/lib.php');

global $PAGE, $OUTPUT;

$PAGE->set_pagelayout('standard');
//$PAGE->set_heading(get_string('page', 'externalsync');
$PAGE->set_heading('External Sync');

// verificamos se o form submetido é do tipo curso

//$course = optional_param('course', false, PARAM_INT);

$course = $_FILES['course'];
$courses = file_get_contents($course['tmp_name']);

/*
if( $course != false){
    echo "to aqui";
} else {
    echo "nada submetido";
}*/

// supondo que o csv agora está como array
$courses = [
    [
        'code' => 'MAC0315',
        'name' => 'Otimização Linear',
        'start' => '01/08/2022',
        'end' => '01/12/2022'
    ]
];

foreach($courses as $course){
    // Criar o curso no moodle

    $newcourse = new \stdClass();
    $newcourse->shortname = $course['name'];
    $newcourse->fullname = $course['name'] ;
    $newcourse->description = $course['name'];
    $newcourse->summary = $course['name'];
    $newcourse->idnumber = 999;
    $newcourse->visible = 1;

    $newcourse->format = get_config('moodlecourse', 'format');
    $newcourse->numsections = get_config('moodlecourse', 'numsections');
    $newcourse->summaryformat = FORMAT_HTML;

    $newcourse->startdate = time();
    $newcourse->enddate = $newcourse->startdate + 130*3600*24; # 130 dias
    $newcourse->timemodified = time();

    $newcourse->category = 1;
            
    $created_course = \create_course($newcourse);

    // Registrar na tabela externalsync_courses
    // $created_course->id 


}















