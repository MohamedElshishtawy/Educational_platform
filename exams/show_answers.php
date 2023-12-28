<?php
ob_start();
session_start();
//go to index page
if (!isset($_SESSION['phone']) || !$_SESSION['se'] == '1se' || !$_SESSION['se'] == '2se' || !$_SESSION['se'] == '3se') {

  header('location: ../');
  exit();
} else {

  //prepare page
  include_once '../init.php';
  include_once '../' . $connect;
  include_once '../' . $functions;

  
//   if(! isset($_GET['student']) || ! $_GET['exam'] || ! $_GET['student'] != $_SESSION['id']){
//     session_destroy();
//     header('location: ../../');
//     exit();
// }

$student_id = $_GET['student'];
$student_se = $_SESSION['se'];
$exam_id = $_GET['exam_id'];
$exam_name = $_GET['exam_n'];


$student_id = $_SESSION['id'];
$title = 'إجابات';
include_once '../' . $header;

  date_default_timezone_set('Africa/Cairo');

  // Get Answers for the student from the file
  $answer_location = 'answers/'.$student_se[0].'/'.$exam_name.'/'.$student_id.'.php';
  $file_content = include_once $answer_location;
  $file_content = stripslashes($file_content);
  $answers = unserialize($file_content);

  // Get the exam question grom the file
  $exam_location = $student_se[0].'/'.$exam_name.'.php';
  include_once $exam_location; // Include $eaxm1 (all questions) // Include the main.php

  showExamAnsers($exam1, $answers, $student_id, $student_se, $db);

  include_once '../' .$footer;

}