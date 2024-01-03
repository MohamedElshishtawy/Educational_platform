<?php

/**
 * To Do
 * Change the id to the exam name in if there is two exams in the same window
 */
ob_start();
session_start();
//go to index page
if (!isset($_SESSION['phone']) || !$_SESSION['se'] == '1se' || !$_SESSION['se'] == '2se' || !$_SESSION['se'] == '3se') {
    session_destroy();
    header('location: ../');
    exit();
}
/** @var STRING $connect */
/** @var String $functions */
//prepare page
include_once '../init.php';

include_once '../' . $connect;
include_once '../' . $functions;

$title = 'امتحان';
/** @var string $header */
include_once '../' . $header;

date_default_timezone_set('Africa/Cairo');

$student_id = $_SESSION['id'];


// Check the GET 
$exam_id = $_GET['exam'] ?? false;
if (!$exam_id) {
    session_destroy();
    header("location: ../");
    exit();
}

// Get Exam data
/** @var object $db */
$exam_db = $db->prepare('SELECT * FROM exams WHERE id = ?');
$exam_db->execute(array($exam_id));
if ($exam_db->rowCount() > 0) {
    $exam = $exam_db->fetch(PDO::FETCH_ASSOC);
} else {
    message("الإمتحان لم يعد متاحا", "danger", "../");
}

// If all is wright check the file first of making decisions with local storage
try {
  global $exam1;
    $exam_file = include_once $exam['se'][0] . "/" . $exam['id'] . ".php";
    $exam1 = stripslashes($exam_file);
    $exam1 = unserialize($exam1);
} catch (Exception $e) {
    message("الللإمتحان لم يعد متاحا <br>" . $e, "danger", "../");
}


// check if it is the first time only
$check = $db->prepare("SELECT * FROM degrees WHERE exam_id = ? && student_id = ?");
$check->execute(array($exam_id, $student_id));
if ($check->rowCount() > 0) {
    message("تم حل الإمتحان من قبل", "waring", "../");
    header('location: ../../');
    exit();
}

// if your http referer is included to="exams" => open the exam to solute Or includ exam id
$http_referer = $_SERVER['HTTP_REFERER']  ??  '';
$last_value_http    = strstr($http_referer, '&');
$last_value_my_link = array_reverse(explode('/', $_SERVER['PHP_SELF']));
if ($last_value_http != '&to=exams' /*|| $last_value_my_link[0] != $exam_id*/) {
    header('location: ../index.php');
}
$open_exam = true;
// Check The timer
$time_history  = select_info('*', 'timer', 'student_id', $student_id);
$duration = (int)$exam['duration'] * 60; // sec

if ($time_history) { // There is Time in history
    $started_time = strtotime($time_history[0]['start_time']);
    $time_now = new DateTime();
    if ($time_history[0]['exam_id'] != $exam_id) { // There is data for another Exam in the localstorage and Time db;
    $open_exam = false;

      ?>
        <form method="POST" class="message col-lg-6 col-lg-push-3 col-md-6 col-md-push-3 col-sm-6 col-sm-push-3 col-xs-10 col-xs-push-1">
            <h2 class="text-center">تحذير</h2>
            <section>
                <div><span>*</span> هناك امتحان لا تزال تمتحنه</div>
                <div>الإمتحان: <b><?php echo str_replace('_', ' ', $time_history[0]['exam_id']); ?></b></div>
                <div>المعلومات</div>
                <ol>
                    <li>وقتك المتبقي لك</li>
                    <li>الأجابات التي اخترتها</li>
                    <li>لن يتم إزالة درجتك إذا تم إرسالها للمعلم من قبل</li>
                </ol>
            </section>
            <div>
                <button type="submit" name="delete_info" class="btn btn-danger">إزالة المعلومات</button>
                <button type="submit" name="out" class="btn btn-info">الخروج من هذا الإمتحان</button>
            </div>
            
          </form>
    <?php
        if (isset($_POST['delete_info'])) {
            $go_in_exam = true;
            echo '<script>localStorage.clear();</script>';
            $delete_timer_query = $db->prepare("DELETE FROM timer WHERE student_id = $student_id ");
            $delete_timer_query->execute();
        } elseif (isset($_POST['out'])) {
            header('location: ../');
        }
    } elseif (($duration -= $time_now->getTimestamp() - $started_time) <= 0) { // time run out
        $submit = true;
        $delet_time_history = $db->prepare("DELETE FROM timer WHERE student_id = $student_id");
        $delet_time_history->execute();
    }
    // Else is the time is running, and we have edit the duration var in the if(-) and the start date still in rhe database as the same
} else {
    $set_timer = $db->prepare("INSERT INTO timer (student_id,exam_id) VALUES (?,?) ");
    $set_timer->execute(array($student_id, $exam['id']));
}

if ($open_exam){
      // open 
    echo '<br><br><br><h2 class="text-center" id="examHeader">' . str_replace('_', ' ', $exam['exam_name']) . '</h2><br>';

    ?>
    <form method="POST" name="myform">
        <div class="exam-nav" id="timer">
            <span class="min" id="min"></span>
            <progress class="sec" id="sec" max="<?= $exam['duration'] /*sec*/ ?>" value="<?= $duration ?>"></progress>
        </div>
        <?php
        $x = 0;
        echo '<ol>';
        for ($x; $x < count($exam1); $x++) {
          $count_of_questions = count($exam1);  
          echo '<div class="all-q">';
            echo '<div class="qustion"><li>' . $exam1[$x]['q'] . '</li></div>';
            if (!$exam1[$x]['i'] == '') {
                echo '<img src="examph/' . $exam['se'][0] . '/' . $exam1[$x]['i'] . '" alt="Physics Image" class="exam-image">';
            }
            for ($y = 0; $y < 4; $y++) {
                echo '<span class="answer"><input  type="radio" id="q' . $x . 'a' . $y . '" name="q' . $x . '" value="a' . $y . '">';
                echo '<label for="q' . $x . 'a' . $y . '">' . $exam1[$x]['a' . $y] . '</label></span>';
            }
            echo '</div>';
        }
        echo '</ol>';
        echo '<button name="end"  id="form" type="submit" class="btn btn-info">done <i class="fa fa-clipboard-check"></i></button>';
        echo '</form>';

}

if (isset($_POST['end'])) {

            // delete answers info
            echo '<script>localStorage.clear();</script>';

            // delet his time history
            $student_id = $_SESSION['id'];
            $time_history1 = $db->prepare("DELETE FROM timer WHERE student_id = $student_id");
            $time_history1->execute();
            $score = 0;
            $ans_count = 0;

            $student_answers = array();


            for ($ques = 0; $ques < count($exam1); $ques++) {

                $ans_round = 'q' . $ans_count;

                if (isset($_POST[$ans_round])) {
                    $answer_you_choese = filter_var($_POST[$ans_round], FILTER_SANITIZE_STRING);
                } else {
                    $answer_you_choese = '';
                }

                // store the answer
                $student_answers[$ans_count] = $answer_you_choese;

                //if answer of the qustio is correct
                if ($answer_you_choese == $exam1['at']) {
                    $score++;
                }

                $ans_count++;
            }

            // prepare deg for DB
            $deg = $score . ' / ' . $ans_count;
            $save_deg = $db->prepare("INSERT INTO degrees (student_id, exam_id, degree) 
                                                  VALUES (? , ? , ?)");
            $save_deg->execute(array($student_id, $exam_id, $deg));

            // upload file for answers
            
            saveAnswersFile($student_id, $exam_id, $_SESSION['se'], $student_answers);



            $_SESSION['message'] = '<span class="alert alert-success" style="position:absolute;top:10px;right:5px;z-index:1000">بالتوفيف تم تخزين درجتك مع المعلم</span>';
            header('location: ../');
            exit();
        } else {
            //open the exam
            if (true) {
        ?>
                <script>
                    <?php

                    // now I will place a js submit prosess when $submit is true 
                    if (isset($submit) && $submit ) {
                        echo 'document.getElementById("form").click();';
                        echo 'localStorage.clear();';
                    } else {
                    ?>
                        // localStorage settings
                        let local = localStorage,
                            exam_in_local = local.getItem('examName'),
                            this_exam = document.getElementById('examHeader').innerHTML;

                        if (exam_in_local == 'null' || exam_in_local !== this_exam) {
                            localStorage.clear();
                            localStorage.setItem('examName', this_exam);
                        }
                        <?php
                        /**
                         * observation !!
                         * $min_you_have_js => get all min you have from db
                         * $min2sec_you_have_js => it change $min_you_have_js to sec [I use this var in progresses bar]
                         * $sec_you_have_js => it is the realy secounds you have from the moment min
                         */
                        
                        
                        /** @var INT $diff_sec */
                        $sec_you_have_js     = $duration; // I time it with 60 because I return $diff_sec to min in formating progress
                        ?>
                        let minYouHave = <?php echo floor($duration/60 ); ?>,
                            secYouHave = <?php echo getFirstTwoDecimalDigits($duration/60) ; ?>,
                            min2sec = minYouHave * 60,
                            timerCounterSpan = document.getElementById('min'),
                            counterBar = document.getElementById('sec'),
                            secCgounter = setInterval(function() {

                                if (min2sec <= 0) {
                                    document.getElementById("form").click();
                                    timerCounterSpan.innerHTML = 'Done';
                                    clearInterval(secCgounter);
                                } else {
                                    secYouHave--;
                                    min2sec--;
                                }

                                if (secYouHave <= 0) {
                                    secYouHave = 60;
                                    minYouHave--;
                                }

                                if (minYouHave < 10) {
                                    if (secYouHave < 10) {
                                        timerCounterSpan.innerHTML = '0' + minYouHave + ':' + '0' + secYouHave;
                                    } else {
                                        timerCounterSpan.innerHTML = '0' + minYouHave + ':' + secYouHave;
                                    }
                                    timerCounterSpan.style.color = 'red';
                                    counterBar.style.background = 'red';
                                    // document.getElementsByTagName('prodresess[value]').style.background = 'red';
                                } else {
                                    if (secYouHave < 10) {
                                        timerCounterSpan.innerHTML = minYouHave + ':' + '0' + secYouHave;
                                    } else {
                                        timerCounterSpan.innerHTML = minYouHave + ':' + secYouHave;
                                    }
                                }

                                counterBar.setAttribute('max', <?= $exam['duration'] * 60   ?>);
                                counterBar.setAttribute('value', ((minYouHave*60)+secYouHave) );
                            }, 1000);

                    <?php
                    }
                    ?>
                </script>
                <?php

                ?>
                <script>
                    // localStorage settings
                    let local = localStorage,
                        exam_in_local = local.getItem('examName'),
                        this_exam = document.getElementById('examHeader').innerHTML;

                    
                    if ( ! exam_in_local || exam_in_local !== this_exam) {
                        localStorage.clear();
                        localStorage.setItem('examName', this_exam);
                        window.alert('haell');
                    }
                </script>
        <?php
            }
        }


        /** @var STRING $footer */
include_once '../' . $footer;

        ob_end_flush();
