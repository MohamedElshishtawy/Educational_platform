<?php
// show answer can be for admin or the same student can't anther one make it

ob_start();
session_start();
date_default_timezone_set('Africa/Cairo');

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


$exam = $db->prepare("
SELECT degrees.*, exams.exam_name, students.ar_name 
FROM degrees 
JOIN exams ON exams.id = degrees.exam_id 
JOIN students ON students.id = degrees.student_id
WHERE
degrees.student_id = ?
AND
degrees.exam_id = ?
");
$exam->execute([$student_id, $exam_id]);
if ( $exam->rowCount() > 0) {
  $exam = $exam->fetch(PDO::FETCH_ASSOC);
}
else{
  $exam = false; 
}


if ($student_id != $_SESSION['id']) { // the admin or another student
  if ( $_SESSION['se'] == 'AD' ){
    // show_answers_for_AD();
  }else{
    session_destroy();
    header("location: ../");
    exit();
  }
} else{
  $title = 'إجاباتى';
  include_once '../' . $header;
  echo '<br><br><br><h2 class="text-center" id="examHeader">' . str_replace('_', ' ', $exam['exam_name']) . '</h2><br>';


    // Get Answers for the student from the file
    $answer_location = 'answers/'.$student_se[0].'/'.$exam_id.'/'.$student_id.'.php';
    $file_content = include_once $answer_location;
    $file_content = stripslashes($file_content);
    $answers = unserialize($file_content);
    
    // Get the exam question grom the file
    $exam_location = $student_se[0].'/'.$exam_id.'.php';
    $exam_content  = include_once $exam_location; 
    $exam_content = stripslashes($exam_content);
    $exam1 = unserialize($exam_content);

 
    
    showExamAnsers($exam1, $answers, $student_id, $student_se, $db);
  
    include_once '../' .$footer;
}

}