<?php 


include_once 'connect.php';

/* my functions */

/*
-- Select Function v2.0 { in v2.0 -> added $eals }
-- This function acsept parameters :
---- $selection => what you want to select
---- $from => the table in database
---- $where => the field you want to select
---- $val => the value include the field
---- $eals => i can add any thing in this
-- [select] Function reterns $rows_f
-- $rows_n -> number of rows for the selection
*/
function select1($selection,$from,$where,$val,$eals="") {
    global $db;
    
    $select = $db->prepare("SELECT $selection FROM $from WHERE $where = ? $eals ");
    $select->execute(array($val));
    
    $rows_n = $select->rowCount();

    return $rows_n;
    
}

//----------------------------------------------

/*
-- Select Function v2.0 [ v2.0 -> error parameter ]
-- This function acsept parameters :
---- $selection => what you want to select
---- $from => the table in database
---- $where => the field you want to select
---- $val => the value include the field
---- $eals => i can add any thing in this
---- $error => to put error function
-- [select] Function reterns $rows_f
-- $rows_f -> rows data for the selection
*/
function select2($selection,$from,$where,$val,$eals='',$error=false) {
    global $db;
    
    $select2 = $db->prepare("SELECT $selection FROM $from WHERE $where = ? $eals ");
    $select2->execute(array($val));
    $select2->rowCount();
    if ( $select2->rowCount() > 0 ){
    $rows_f = $select2->fetchAll();
    return $rows_f;
    }
    elseif( $select2->rowCount() == 0 ){
        return $error;
    }
}

//----------------------------------------------

/*
-- Select Function v1.0
-- This function accept parameters :
---- $selections => what you want to select from DB
---- $table => the table in database
---- $condition_field => the field you want to point
---- $condition => the value include the field
---- $else => I can add any thing in this
---- $error => to put error function
-- [select] Function reterns $rows
-- $rows -> rows data for the selection
*/
function select_info_no_where($selections,$table,$error_ms=false) {
  global $db;
  
  $select_procc = $db->prepare("SELECT $selections FROM $table  ");
  $select_procc->execute();
  if ( $select_procc->rowCount() > 0 ){
  $rows = $select_procc->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
  }
  
  return $error_ms;
  
}
function select_info($selections,$table,$condition_field,$condition,$else='',$error_ms=false) {
  global $db;
  
  $select_procc = $db->prepare("SELECT $selections FROM $table WHERE $condition_field = ? $else ");
  $select_procc->execute(array($condition));
  if ( $select_procc->rowCount() > 0 ){
  $rows = $select_procc->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
  }
  
  return $error_ms;
  
}

//----------------------------------------------

/*
--- Function to filter text from [ / \ - * ; ( ) ] v1.0
-- Function acsept parametrs
- $text => the text you want to sanitize
-- Function return the var with out [ / \ - * ; ( ) [ ] ]
- return => $txt
*/

function filt($text) {
    
    $txt = str_replace('/','',$text);
    $txt1 = str_replace('%','',$txt);
    $txt2 = str_replace('-','',$txt1);
    $txt3 = str_replace('*','',$txt2);
    $txt4 = str_replace(';','',$txt3);
    $txt5 = str_replace('(','',$txt4);
    $txt6 = str_replace(')','',$txt5);
    $txt7 = str_replace('[','',$txt6);
    $txt8 = str_replace(']','',$txt7);
    $txt9 = str_replace('{','',$txt8);
    $txt10 = str_replace('}','',$txt9);
    $txt11 = str_replace('<','',$txt10);
    $txt12 = str_replace('>','',$txt11);
    $txt13 = str_replace('?','',$txt12);
    $txt14 = str_replace('؟','',$txt13);
    $txt15 = str_replace('\\','',$txt14);
    $txt16 = str_replace('|','',$txt15);
    $txt17 = str_replace('$','',$txt16);
    $txt18 = str_replace('&','',$txt17);
    $txt19 = str_replace('#','',$txt18);
    $txt20 = str_replace('^','',$txt19);
    $txt21 = str_replace('_','',$txt20);
    $txt22 = str_replace(',','',$txt21);
    
    return $txt22;
}

//----------------------------------------------

/*
*** UPDATE fnction v1.0
** acsept parameters:
* $table        => the table you chose
* $old_new_vals => the old data and new data -> [ money = '15' , id = '700' ]
* $field        => where the tr you want
* $field_val    => field value
** NO RETURNS
*/

function update($table,$feled_equal_new_val,$field,$field_val) {
    global $db;
    
    $update = $db->prepare("UPDATE $table SET $feled_equal_new_val WHERE $field = '$field_val' ");
    
    $update->execute();
}

//----------------------------------------------

/*
*** CHEKING if student is here function v1.0
** This function acsept parameters :
* $selection => what you want to select
* $from      => the table in database
* $where     => the field you want to select
* $val       => the value include the field
* $eals      => i can add any thing in this
* $error     => to put error function
** Function reterns $rows_count
*/
function is_here($select,$from,$where,$val) {
    global $db;

    $select = $db->prepare("SELECT $select FROM $from WHERE $where ");
    
    $select->execute(array($val));
    
    $rows_count = $select->rowCount();
    
    return $rows_count;
}

//----------------------------------------------
/**
 * function syple2html v1.0
 * accept parameter
 * [$word] => the text you want
 * returns the word you wabt by changing syplosto html tags
 */
function sympole2html($word) {
  $word1 = str_replace('^^','<sup>',$word);
  $word2 = str_replace('**','</sup>',$word1);
  $word3 = str_replace('--','<sub>',$word2);
  $word4 = str_replace('__','</sub>',$word3);
  return $word4;
}

/** if_here_return() v1.0
 *  If Isset($Var) : Return It
 * Accept parameters => $variable you want to check
 */
function if_here_echo($var) {
  if ( isset($var) ) {
    return $var;
  } else{
    return '';
  }
}


/** Redirect with Post 24/12/2023
 * Input: 
 *  - URL you want to visit
 *  - Data* you want to save in the post
 * Note: the kry of the post will be numbers
 */
function redirect_wtih_post($url, ...$data){
  // Data
  $postData = [];
  $n = 0;

  foreach($data as $info){
    $postData[$n++] = $info;
  }

  // Redirect to another page with POST data
  echo '<form id="redirectForm" action="'.$url.'" method="post">';
  foreach ($postData as $key => $value) {
      echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
  }
  echo '</form>';
  echo '<script>document.getElementById("redirectForm").submit();</script>';
  exit();
}



function set_session_redirect($id,$name,$phone,$money,$se,$code,$state){
  $_SESSION['id']    = $id;
  $_SESSION['name']  = $name;
  $_SESSION['phone']  = $phone;
  $_SESSION['money']  = $money;
  $_SESSION['se']    = $se;
  $_SESSION['code']    = $code;
  $_SESSION['state'] = $state;
  //if is student
  if ($_SESSION['state'] == '10') {

      //go to your page
      if ($_SESSION['se'] == '1se') {
        $to_1 = 'location: 1secoundry.php?id=' . $_SESSION['id'];
        header($to_1);
        exit();
      } elseif ($_SESSION['se'] == '2se') {
        $to_2 = 'location: 2secoundry.php?id=' . $_SESSION['id'];
        header($to_2);
        exit();
      } elseif ($_SESSION['se'] == '3se') {
        $to_3 = 'location: 3secoundry.php?id=' . $_SESSION['id'];
        header($to_3);
        exit();
      } else {
        session_unset();
        session_destroy();
        header("location: code-log.php");
        exit();
      }
  }
  // if is admin
  elseif ($_SESSION['state'] == '11' && $_SESSION['id'] == '18542') {
    $to_ad = 'location: mr.php';
    header($to_ad);
    exit();
  } else {
      session_unset();
      session_destroy();
      header("location: code-log.php");
      exit();
  }
  
}

function saveAnswersFile ($studentID, $examID,$se, $answers) {
  // Define the base directory
  $baseDir = '../answers/'.$se[0];

  // Create the exam directory if it doesn't exist
  $examDir = $baseDir . '/' . $examID;
  if (!file_exists($examDir)) {
      mkdir($examDir, 0777, true); // 0777 provides full permissions, adjust as needed
  }

  // Create the student's file
  $studentFile = $examDir . '/' . $studentID . '.php';

  // Serialize and save the answers to the file
  $serializedAnswers = serialize($answers);
  file_put_contents($studentFile, '<?php return \'' . addslashes($serializedAnswers) . '\';');

  // echo "Answers for Student ID $studentID in Exam ID $examID have been saved successfully.";
  return true;
}
function getAnswers($studentID, $examID, $se) {
  // Define the base directory
    $baseDir = '../answers/'.$se[0];


  // Check if the exam directory exists
  $examDir = $baseDir . '/' . $examID;
  if (!file_exists($examDir)) {
      return null; // Exam directory doesn't exist
  }

  // Check if the student's file exists
  $studentFile = $examDir . '/' . $studentID . '.php';
  if (!file_exists($studentFile)) {
      return null; // Student's file doesn't exist
  }

  // Read and unserialize the answers from the file
  $serializedAnswers = file_get_contents($studentFile);
  $answers = unserialize(stripslashes(substr($serializedAnswers, 12, -2))); // Remove '<?php return ' and ';'

  return $answers;
}

function showExamAnsers($exam1, $answers,$student_id ,$exam_se,$db){
  // delete answers info
    echo '<script>localStorage.clear();</script>';

    // delet his time history
    $score = 0;
    $ans_count = 0;

  for ($ques = 0; $ques < count($exam1); $ques += 5) {
      echo '<div class="all-q">';
      echo '<div class="qustion">' . $exam1[$ques] . '</div>';
      if (!$exam1[$ques + 3] == '') {
        if ($exam_se == '1se') {
          echo '<img src="../examph/1/' . $exam1[$ques + 3] . '" alt="your can\'t see this image becouse...." class="exam-image">';
          } elseif ($exam_se == '2se') {
          echo '<img src="../examph/2/' . $exam1[$ques + 3] . '" alt="your can\'t see this image becouse...." class="exam-image">';
          } elseif ($exam_se == '3se') {
          echo '<img src="../examph/3/' . $exam1[$ques + 3] . '" alt="your can\'t see this image becouse...." class="exam-image">';
          }
      }
      $ans_round = 'q' . $ans_count;
      

      $answer_you_choese = $answers[$ans_count] ?? '';
      

      //if answer of the qustio is correct
      if ($answer_you_choese == $exam1[$ques + 2]) {
        $score++;
        //palce all ansers but the true will be green background
        for ($ans = 0; $ans < count($exam1[$ques + 1]); $ans++) {
          //select good ans you chose
          if ('a' . $ans == $answer_you_choese) {
            echo '<span class="ans true">' . $exam1[$ques + 1][str_replace('a', '', $answer_you_choese)] . '</span>';
          } else {
            echo '<span class="ans">' . $exam1[$ques + 1][$ans] . '</span>';
          }
        }
      }

      //if answer you chose is wrrong
      else {

        //palce all ansers the true will be yellow background and wrrong will be red
        for ($ans = 0; $ans < count($exam1[$ques + 1]); $ans++) {

          //select wrrong ans you chose
          if ('a' . $ans == $answer_you_choese) {
            echo '<span class="ans wrrong">' . $exam1[$ques + 1][str_replace('a', '', $answer_you_choese)] . '</span>';
          } elseif ('a' . $ans == $exam1[$ques + 2]) {
            echo '<span class="ans the_true">' . $exam1[$ques + 1][str_replace('a', '', $exam1[$ques + 2])] . '</span>';
          } else {
            echo '<span class="ans">' . $exam1[$ques + 1][$ans] . '</span>';
          }
        }
      }
      if (!$exam1[$ques + 4] == '') {
        echo '<br><div class="alert alert-warning">*ملحوظة: <br>' . $exam1[$ques + 4] . '</div>';
      }
      echo '</div>';

      $ans_count++;
    }
    // place a btn [to go index] && the score he had
    echo '<form method="post" action="../../"><button type="submit" class="btn btn-info text-center"><i class="fa fa-thumbs-up"></i> حسنا</button></form>';
    echo '<hr>';
}


function set_student_sessions($user_id,$user_name,$user_phone,$parent_phone,$activate,$user_se,$code,$group,$state = '10'){
  $_SESSION['id']    = $user_id;
  $_SESSION['name']    = $user_name;
  $_SESSION['code']    = $code;
  $_SESSION['phone']  = $user_phone;
  $_SESSION['parent_phone']  = $parent_phone;
  $_SESSION['money']  = $activate;
  $_SESSION['se']    = $user_se;
  $_SESSION['state'] = $state;
  $_SESSION['groub'] = $group;
}
?>