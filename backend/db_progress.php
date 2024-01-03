<?php

// use backend\models\Code;
/* 
---------------------------
*** DB progreser page
** All progreses as [ insert || select ] will be here 
---------------------------
*/

include_once 'functions.php';

/*//////////////////////////////////////////////////*/

/* start checking day of mounth to upgreade money data */
date_default_timezone_set('Africa/Cairo');
/* end checking day of mounth to upgreade money data */

/*//////////////////////////////////////////////////*/

/* btn for end session */
if (isset($_POST['out'])) {
  session_unset();
  session_destroy();
  header("location: code-log.php");
}
/* btn for end session */

/*//////////////////////////////////////////////////*/

/* start log in page */

if (isset($_POST['log_btn'])) {

  //get name and password
  $bad_phone     = $_POST['student_phone'];
  $bad_password = $_POST['student_password'];

  //filter name and password
  $bad_phone_f = filter_var($bad_phone, FILTER_SANITIZE_NUMBER_INT);
  $phone = filt($bad_phone_f);

  $bad_password_f = filter_var($bad_password, FILTER_SANITIZE_STRING);
  $password = filt($bad_password_f);

  //select data base
  $select = $db->prepare("SELECT * FROM students WHERE phone = ? && password = ? ");

  //fill the ? and excute
  $select->execute(array($phone, $password));

  //if student is here
  if ($select->rowCount() > 0) {

    //store data
    $rows_f = $select->fetchAll();

    //put data in sessions
    foreach ($rows_f as $row_f) {
      set_student_sessions(
        $row_f['id'],
        $row_f['ar_name'],
        $row_f['phone'],
        $row_f['parent_phone'],
        $row_f['money'],
        $row_f['se'],
        $row_f['code'],
        $row_f['group'],
        $row_f['state']
      );
    }

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
  } elseif ($select->rowCount() == 0) {

    echo '<div class="alert alert-danger die" style="position:absolute;top:10px;width:100%">اسم المستخدم او الباسورد خطأ</div>';
  }
}
/* end log in page */


/** Start log in with code */

if ( isset( $_POST['log_code'] ) ){
    if (isset($_SESSION['phone']) && isset($_SESSION['id'])) {
      //if he is student
      if ($_SESSION['state'] == '10' /*student*/) {
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
      //if he is damin
      elseif ($_SESSION['state'] == '11' /*admin*/) {
          header('location: mr.php');
          exit();
      }
  }
  //if you don't have session
  else {
    if (isset($_POST['code']) && isset($_POST['password'])) {

        //get name and password
        $bad_phone = $_POST['code'];
        $bad_password = $_POST['password'];
        //filter name and password
        $bad_phone_f = filter_var($bad_phone, FILTER_SANITIZE_NUMBER_INT);
        $code = filt($bad_phone_f);
        $bad_password_f = filter_var($bad_password, FILTER_SANITIZE_STRING);
        $password = filt($bad_password_f);

        //select student frome database
        $student = $db->prepare("SELECT * FROM students WHERE code = ? && password = ? ");
        $student->execute(array($code, $password));

        if ($student->rowCount() > 0) {
          $student = $student->fetch(PDO::FETCH_ASSOC);
          set_session_redirect($student['id'],$student['ar_name'],$student['phone'],$student['money'],$student['se'],$student['code'],$student['state']);
        
        }else{
          $code_db = $db->prepare("SELECT * FROM codes WHERE code = ? && password = ? ");
          $code_db->execute(array($code, $password));
          if ( $code_db->rowCount() > 0){
            header("location: set_account.php?code_id=".$code);
          }
          else{
            echo '<div class="alert alert-danger die" style="position:absolute;top:10px;width:100%">الكود المستخدم او الباسورد خطأ</div>';
          }
        }
    }
  }
}



/** End log in with code */

/*//////////////////////////////////////////////////*/

/* start back botton */
if (isset($_POST['back_ad'])) {
  header('location: ?');
}
if (isset($_POST['back_member'])) {
  header('location: mr.php?to=students_s');
}
/* end back botton */

/*//////////////////////////////////////////////////*/

/* start save cash */
//on click save btn
if (isset($_POST['save_money'])) {
  //if you click any chek box
  if (isset($_POST['students'])) {
    //save it as a variable
    $money_students_id = $_POST['students'];
    //extend the aray to values
    foreach ($money_students_id as $money_student_id) {

      $update_function = update('students', 'money = 1', 'id', $money_student_id);
    }
  }
}
/* end save cash */

/*////////////////////////////////////////////////////////*/

/* start insert student */
if (isset($_POST['add_student'])) {

  /* start put an id */

  //set random id for student
  for ($z = 0; $z < 10; $z++) {
    //put arandeom
    $id_rand = random_int(10, 99999);
    //select it in db
    $idDB = select1('id', 'students', 'id', $id_rand);
    //if isn't in db
    if ($idDB == 0) {
      //stop loop
      $z = 11;
    }
    //if loop end and no id has been putten
    if ($z < 10 && $idDB > 0) {
      //repeate the loop
      $z = 0;
    }
  }
  /* end put an id */
  $id       = $id_rand;
  $ar_name  = filter_var($_POST['add_ar_name'], FILTER_SANITIZE_STRING);
  $phone    = filter_var($_POST['add_phone'], FILTER_SANITIZE_NUMBER_INT);
  $groub    = strstr(filt($_POST['add_groub']), '@', true);
  $password = filt($_POST['add_password']);
  $se       = filt($_POST['add_se']);
  if ( isset($_POST['money']) ) {
    $money = 1;
  } else {
    $money = 0;
  }
  //select new item in db
  $selectitem = $db->prepare("SELECT * FROM students WHERE id = ? && phone = ? ");

  $selectitem->execute(array($id, $phone));

  $itemDB = $selectitem->rowCount();

  if ($itemDB > 0 || empty($id) || empty($ar_name) || empty($phone) || empty($password) || empty($se)) {
    echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">قد تركت شيأً ناقصاً أو هذا الأسم موجود من قبل</span>';
  } else {
    $insert_st = $db->prepare("INSERT INTO students (id,ar_name,phone,password,money,se,groub) VALUES (?,?,?,?,?,?,?) ");
    $insert_st->execute(array($id, $ar_name, $phone, $password, $money, $se, $groub));
    echo '<span class="alert alert-success die" style="position: absolute;top:10px;right:5px;z-index:100">تمت الاضافة بنجاح</span>';
  }
}
/* end insert student */

/*////////////////////////////////////////////////////////*/

/* start edit student */
if (isset($_POST['edit_student'])) {

  $edit_ar_name  = filt($_POST['edit_ar_name']);

  $edit_phone     = filt($_POST['edit_phone']);

  $edit_groub    = filt($_POST['edit_groub']);

  $edit_password = filt($_POST['edit_password']);

  $edit_se       = filt($_POST['edit_se']);

  if (!empty($edit_ar_name) || !empty($edit_phone) || !empty($edit_se)) {

    if (strlen($edit_ar_name) < 35 || strlen($edit_phone) < 11 || strlen($edit_password) < 50) {

      if (empty($edit_password)) {

        $edit_id_student =  filter_var($_GET['edit'], FILTER_SANITIZE_NUMBER_INT);

        $updateStudent = $db->prepare("UPDATE students SET ar_name=?,phone=?,groub=?,se=? WHERE id = ?");

        $updateStudent->execute(array($edit_ar_name, $edit_phone, $edit_groub, $edit_se,$edit_id_student));

        if ($updateStudent) {
          echo '<span class="alert alert-success die" style="position: absolute;top:10px;right:5px;z-index:100">تمت التعديل بنجاح سبتم توجيهك إلي صفحة الخصوصيات</span>';
          header('Refresh:3; url=mr.php?to=students_s');
        } else {
          echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">حدث خطأ اثناء التعديل</span>';
        }
      } else {

        $edit_id_student = filter_var($_GET['edit'], FILTER_SANITIZE_NUMBER_INT);

        $updateStudent = $db->prepare("UPDATE students SET ar_name=?,phone=?,groub=?,password=?,se=? WHERE id = $edit_id_student ");

        $updateStudent->execute(array($edit_ar_name, $edit_phone, $edit_groub, $edit_password, $edit_se));

        if ($updateStudent) {
          echo '<span class="alert alert-success die" style="position: absolute;top:10px;right:5px;z-index:100">تمت التعديل بنجاح سبتم توجيهك إلي صفحة الخصوصيات</span>';
          header('Refresh:3; url=mr.php?to=students_s');
        } else {
          echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">حدث خطأ اثناء التعديل</span>';
        }
      }
    } else {
      echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">عدد الحروف اكبر من اللازم</span>';
    }
  } else {
    echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">هناك احدي الخانات فارغة</span>';
  }
}
/* end edit student */

/*////////////////////////////////////////////////////////*/

/** Start Generate Code */
if ( isset($_POST['generate_code1']) ){
  $se = $_POST['generate_code1'];
  $code = $_POST['code1'];
  $password = random_int(100, 2000);
  $code_db = $db->prepare("INSERT INTO codes (code, password, se) VALUES (?, ? ,?)");
  $code_db->execute(array($code, $password, $se));
}
if ( isset($_POST['generate_code2']) ){
  $se = $_POST['generate_code2'];
  $code = $_POST['code2'];
  $password = random_int(100, 2000);
  $code_db = $db->prepare("INSERT INTO codes (code, password, se) VALUES (?, ? ,?)");
  $code_db->execute(array($code, $password, $se));
}
if ( isset($_POST['generate_code3']) ){
  $se = $_POST['generate_code3'];
  $code = $_POST['code3'];
  $password = random_int(100, 2000);
  $code_db = $db->prepare("INSERT INTO codes (code, password, se) VALUES (?, ? ,?)");
  $code_db->execute(array($code, $password, $se));
}
/** End Generate Code */

/*////////////////////////////////////////////////////////*/
function uploadExam($db) {
  if (isset($_POST['upload_exam'])) {
      
  }
}



// Example usage
uploadExam($db);
/* start upload an exam */
if (isset($_POST['upload_exam'])) {
  /**
   * EXAM Array Structure:
   * [
    * 0 => [
      *  "q" => "Question",
      *  "i" => "Image Source",
      *  "a1" => "answer 1",
      *  "a2" => "answer 2",
      *  "a3" => "answer 3",
      *  "a4" => "answer 4",
      *  "ta" //////////////////////
      *  "n"  => "your Note"
    * ]
   * ]
   */

  // Validate and sanitize input
  $exam_name_with_space = filter_var($_POST['exam_name'], FILTER_SANITIZE_STRING);
  $exam_name = str_replace(' ', '_', $exam_name_with_space);
  $time_of_exam = filter_var($_POST['exam_time'], FILTER_SANITIZE_STRING);
  $start_date = filter_var($_POST['exam_date_start'], FILTER_SANITIZE_STRING) ?? NULL;
  $end_date = filter_var($_POST['exam_date_end'], FILTER_SANITIZE_STRING) ?? NULL;
  $for_se = filter_var($_POST['se'], FILTER_SANITIZE_STRING);

  try {
      // Insert The Exam to the Exam Table
      $insert_exam = $db->prepare("INSERT INTO exams (exam_name, duration, se, start_date, end_date, vilablility, date) VALUES (?, ?, ?, ?, ?, 0, CURRENT_DATE)");
      $insert_exam->execute(array($exam_name, $time_of_exam, $for_se, $start_date, $end_date));

      $exam_id = $db->lastInsertId();

      $amount_of_qustions = filter_var($_POST['qustions_count'], FILTER_SANITIZE_STRING);

      $exam = array();

      for ($qcount = 0; $qcount < $amount_of_qustions; $qcount++) {
          // Collect the Question data
          $qustion_no_br = filter_var($_POST['q' . $qcount], FILTER_SANITIZE_STRING);
          $qustion = nl2br($qustion_no_br);
          $a0 = filter_var($_POST['a0' . $qcount], FILTER_SANITIZE_STRING);
          $a1 = filter_var($_POST['a1' . $qcount], FILTER_SANITIZE_STRING);
          $a2 = filter_var($_POST['a2' . $qcount], FILTER_SANITIZE_STRING);
          $a3 = filter_var($_POST['a3' . $qcount], FILTER_SANITIZE_STRING);
          $at = filter_var($_POST['true_for_q_' . $qcount], FILTER_SANITIZE_STRING);
          $qus_img = $_FILES['image_for_q_' . $qcount];
          $ob_no_br = filter_var($_POST['observation' . $qcount], FILTER_SANITIZE_STRING);
          $ob = nl2br($ob_no_br);

          $newIMGname = $qus_img["size"] == 0 ? false : $exam_id . '_' . time() . '_' . pathinfo($qus_img['name'], PATHINFO_FILENAME);

          // store the data in the exam array
          $exam[$qcount] = [
              "q" => $qustion,
              "i" => $newIMGname,
              "a0" => $a0,
              "a1" => $a1,
              "a2" => $a2,
              "a3" => $a3,
              "at" => $at,
              "n" => $ob
          ];

          // Upload the image 
          if ($qus_img["size"] > 0 && $qus_img['error'] == 0) {
            $img_se = str_replace('se', '', $for_se);
            $qustion_img_upload = move_uploaded_file($qus_img['tmp_name'], 'exams/examph/' . $img_se . '/' . $newIMGname);
          } elseif ($qus_img["size"] > 0) {
              // Only handle errors if a file was attempted to be uploaded
              handleImageUploadError($qus_img['error'], $qus_img['name']);
          }
      }

      // start to save the exam in file
      $exam_to_serialize = serialize($exam);
      $exam_location = 'exams/' . $for_se[0] . '/' . $exam_id . '.php';
      file_put_contents($exam_location, "<?php return '" . addslashes($exam_to_serialize) . "';");
      echo '<span class="alert alert-success" style="position:absolute;top:10px;right:5px;z-index:1000">تم الحفظ بنجاح الحمد لله</span>';
  } catch (Exception $e) {
      // Log the exception details
      error_log("Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());

      echo '<span class="alert alert-success" style="position:absolute;top:10px;right:5px;z-index:1000">';
      echo "هناك خطأ ما<br> يرجى التكرم بالتقاط صورة لهذه الرسالة والتواصل مع المبرمج لحل هذه المشكلة بيسر وسهولة.<br> يرجى أن تكون على يقين أننا هنا لدعمك وضمان حلاً سريعًا لهذا الأمر.";
      echo "<hr>";
      echo $e->getMessage() . '</span>';
  }
}
/* end upload an exam */

/*////////////////////////////////////////////////////////*/

/* start save avilability for exam */

if ( isset($_POST['save_exam_avilability']) ) {
  if ( isset($_POST['exams']) ) {
    foreach ( $_POST['exams'] as $selected_exam ) {
      $ex_name = str_replace(' ','_',$selected_exam);
      $select_selc_exam = select2('vilablility','exams','exam_name',$ex_name);
      if ( $select_selc_exam != false ) {
        foreach ( $select_selc_exam as $validate_of_ex ) {
          if ( $validate_of_ex['vilablility'] == 0 ) {
            update('exams','vilablility = 1','exam_name',$ex_name);
          }
        }
      }
    }
  }
}

if ( isset($_POST['save_exam_degree_avilability']) ) {
  if ( isset($_POST['deg_exams']) ) {
    foreach ( $_POST['deg_exams'] as $selected_exam ) {
      $ex_name = str_replace(' ','_',$selected_exam);
      $select_selc_exam = select2('see_degree','exams','exam_name',$ex_name);
      if ( $select_selc_exam != false ) {
        foreach ( $select_selc_exam as $validate_of_ex ) {
          if ( $validate_of_ex['see_degree'] == 0 ) {
            update('exams','see_degree = 1','exam_name',$ex_name);
          }
        }
      }
    }
  }
}

/* end save avilability for exam */

/*////////////////////////////////////////////////////////*/

/* start upload a video */
if (isset($_POST['up'])) {
  //if you place an se
  if (empty($_POST['add_name_for_v']) || empty($_POST['add_dis_for_v']) || empty($_POST['add_se_for_v'])) {
    echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">لقد نسيت وضع اسم او وصف او صف </span>';
  } else {
    if(!empty($_POST['video_link'])){
      if(filter_var($_POST['video_link'], FILTER_VALIDATE_URL)) {
        $video_url  = filter_var($_POST['video_link'], FILTER_SANITIZE_URL);
        $name_for_v = filter_var($_POST['add_name_for_v'], FILTER_SANITIZE_STRING);
        $disc_for_v = filter_var($_POST['add_dis_for_v'], FILTER_SANITIZE_STRING);
        $seco_for_v = filter_var($_POST['add_se_for_v'], FILTER_SANITIZE_STRING);
        //set random id for the video
        for ($y = 0; $y < 10; $y++) {
          //put arandeom
          $vid_id_rand = random_int(0, 9999999);
          //select it in db
          $vid_id_DB = select1('video_id', 'videos', 'video_id', $vid_id_rand);
          //if isn't in db
          if ($vid_id_DB == 0) {
            //stop loop
            $z = 11;
          }
          //if loop end and no id has been putten
          if ($y < 10 && $vid_id_DB > 0) {
            //repeate the loop
            $z = 0;
          }
        }
        $insert_video = $db->prepare("INSERT INTO videos (video_id,video,name,description,se) VALUES (?,?,?,?,?) ");
        $insert_video->execute(array($vid_id_rand,$video_url, $name_for_v, $disc_for_v, $seco_for_v));
        if($insert_video){
          echo '<span class="alert alert-success die" style="position:absolute;top:10px;right:5px">تم الرفع بنجاح بنجاح</span>';
        } else{
          echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">*حدثت مشكلة في قواعد البيانات*</span>';
        }
      } else{
        echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">اللنك غير صحيح</span>';
      }
    } else{
      $fileSelected = $_FILES['file'];
      if ($fileSelected['error'] > 0) {
        echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">حدث خطأ..! ربما انت لم تختر ملفا</span>';
      } else {
        $fileTypePrepare = array_reverse(explode('.', $fileSelected['name']));
        $fileType = $fileTypePrepare[0];
        if (!$fileType == 'mp3' || !$fileType == 'mp4' || !$fileType == 'rm' || !$fileType == 'FLV') {
          echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">(المطلوب mp3 او mp4) الملف غير صحيح</span>';
        } else {
          if ($_POST['add_se_for_v'] == '1se') {
            $to_video_file = $videoes_for_1;
          } elseif ($_POST['add_se_for_v'] == '2se') {
            $to_video_file = $videoes_for_2;
          } elseif ($_POST['add_se_for_v'] == '3se') {
            $to_video_file = $videoes_for_3;
          }
          $all_in_video_dir = scandir($to_video_file);
          //if no one as same as the new file
          $video_name = random_int(1,9999) .'^'. $fileSelected['name'];
          if (in_array($video_name, $all_in_video_dir)) {
            echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">اسم هذا الملف موجود من قبل</span>';
          } else {
            //upload the video in $to_video_file
            $video_nameANDdir = $to_video_file . '/' . $video_name;
            $upload_video = move_uploaded_file($fileSelected['tmp_name'], $video_nameANDdir);
            if ($upload_video) {
  
              $name_for_v = filter_var($_POST['add_name_for_v'], FILTER_SANITIZE_STRING);
              $disc_for_v = filter_var($_POST['add_dis_for_v'], FILTER_SANITIZE_STRING);
              $seco_for_v = filter_var($_POST['add_se_for_v'], FILTER_SANITIZE_STRING);
              //set random id for the video
              for ($y = 0; $y < 10; $y++) {
                //put arandeom
                $vid_id_rand = random_int(0, 9999999);
                //select it in db
                $vid_id_DB = select1('video_id', 'videos', 'video_id', $vid_id_rand);
                //if isn't in db
                if ($vid_id_DB == 0) {
                  //stop loop
                  $z = 11;
                }
                //if loop end and no id has been putten
                if ($y < 10 && $vid_id_DB > 0) {
                  //repeate the loop
                  $z = 0;
                }
              }
              $insert_video = $db->prepare("INSERT INTO videos (video_id,video,name,description,se) VALUES (?,?,?,?,?) ");
              $insert_video->execute(array($vid_id_rand,$video_nameANDdir, $name_for_v, $disc_for_v, $seco_for_v));
  
              if ($insert_video) {
                echo '<span class="alert alert-success die" style="position:absolute;top:10px;right:5px">تم الرفع بنجاح بنجاح</span>';
              } else {
                unlink($video_nameANDdir);
                echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">*حدثت مشكلة في قواعد البيانات*</span>';
              }
            } else {
              echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">*لم يتم رفع الملف*</span>';
            }
          }
        }
      }
    }
  }
}

/* /////////////////////////////////////////////////////// */

if ( isset($_POST['save_vid_activity']) ) {
  if ( isset($_POST['videoes']) ) {
    foreach ( $_POST['videoes'] as $selected_video ) {
      $select_selc_vid = select2('activity','videos','video_id',$selected_video);
      if ( $select_selc_vid != false ) {
        foreach ( $select_selc_vid as $validate_of_vid ) {
          if ( $validate_of_vid['activity'] == 0 ) {
            update('videos','activity = 1','video_id',$selected_video);
          }
        }
      }
    }
  }
}

/* /////////////////////////////////////////////////////// */

/* start send message */
if (isset($_POST['send'])) {

  if (empty($_POST['to_se'])) {
    echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">انت لم تحدد الصف</span>';
  } else {

    if (empty($_POST['message'])) {
      echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">الرسالة فارغة</span>';
    } else {

      $message_sanitized = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

				$to = 'hmhnd8324@gmail.com';
				$subject = 'mr mohamed maky';
				$message_sanitized = 'hello iam mohamed';
				
				mail($to,$subject,$message_sanitized);
				
    }
  }
}
/* end send message */

/* /////////////////////////////////////////////////////// */

/** start upload image */
if ( isset($_POST['photo_up']) ) {
  // array stores all form errors
  $img_uploading_err = array();
  //if any file is empty
  
  if(empty($_POST['add_name_for_image'])){
    $img_uploading_err[] = 'لقد تركت إسم الصورة فارغاَ';
  } else{
    $name_for_image = filter_var($_POST['add_name_for_image'], FILTER_SANITIZE_STRING);
  }
  if(empty($_POST['add_dis_for_image'])){
    $img_uploading_err[] = 'لقد تركت وصف الصورة فارغاَ';
  } else{
    $disc_for_image = filter_var($_POST['add_dis_for_image'], FILTER_SANITIZE_STRING);
  }
  if(empty($_POST['add_se_for_image'])){
    $img_uploading_err[] = 'لم تختار صف للصورة';
  } else{
    $seco_for_image = filter_var($_POST['add_se_for_image'], FILTER_SANITIZE_STRING);
  }
  $imageSelected = $_FILES['image_file'];
  $imagesCount = count($_FILES['image_file']['name']);
  if($imagesCount < 0){
    $img_uploading_err[] = 'لم تختار صورة!';
  } else{
    for ( $n = 0 ; $n < $imagesCount ; $n++ ) {
      if($imageSelected['error'][$n] > 0){
        $img_uploading_err[] = 'حدث خطأ..! ربما انت لم تختر صورة';
      } else{
        if ( $imageSelected['size'][$n] > 512000000 ) {
          $img_uploading_err[] = 'للأسف الصورة <b>'. $imageSelected['name'][$n] . '</b>';
        } else{
          $imageType = strstr($imageSelected['type'][$n], '/', true);
          if ( $imageType != 'image' ) {
            $img_uploading_err[] = 'للأسف هذه ليست صورة <b>' . $imageSelected['name'][$n] . '</b>';
          }
        }
      }
      // check all errors is empty
      if(empty($img_uploading_err)){
        // prepare the image for uploading proccess
        $se_dir_val = str_replace('se','',$_POST['add_se_for_image']);
        $to_image_file = 'images/'.$se_dir_val;
        // get all images in se dir
        $all_images_in_dir = scandir($to_image_file);
        // prapare name for image
        for($random_count=0; $random_count<10; $random_count++){
          $image_name = random_int(0,99999) . '^' . $imageSelected['name'][$n];
          if (!in_array($image_name, $all_images_in_dir)) {
            $random_count = 11;
          } elseif (in_array($image_name, $all_images_in_dir) && $random_count == 9){
            $random_count = 0;
          }
        }
        // start uploading the image
        $new_image_tmp = $to_image_file.'/'.$image_name;
        $upload_image_proccess = move_uploaded_file($imageSelected['tmp_name'][$n], $new_image_tmp);
        if($upload_image_proccess){
          // preparing random for image
          for($p = 0; $p < 10; $p++){
            $img_id_rand = random_int(0, 9999999);
            $img_id_DB = select_info('image_id', 'images', 'image_id', $img_id_rand);
            if ($img_id_DB == false){
              //stop loop
              $p = 11;
            }
            if ($p == 9 && $img_id_DB != false ) {
              //repeate the loop
              $p = 0;
            }
          }
          $insert_image = $db->prepare("INSERT INTO images (image_id,image,name,description,se,vialblity) VALUES (?,?,?,?,?,?) ");
          $insert_image->execute(array($img_id_rand,
                                        $new_image_tmp,
                                        $name_for_image,
                                        $disc_for_image, 
                                        $seco_for_image,
                                        0));

          if ($insert_image) {
            echo '<span class="alert alert-success die" style="position:absolute;top:10px;right:5px">تم رفع الصور بنجاح</span>';
            $name_for_image = '';
            $disc_for_image = '';
          } else {
            unlink($new_image_tmp);
            echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">*حدثت مشكلة في قواعد البيانات*</span>';
          }
        } else {
          echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">*لم يتم رفع الصورة*</span>';
        }
      } else{
        // if in error array some errors
        $uploading_errors = true; // I use it to echo alert messages in mr.php page > form
      }
    }
  }
}
/** end upload image */

/* /////////////////////////////////////////////////////// */

/* start valibility for video */
if ( isset($_POST['save_img_vilability']) ) {
  if ( isset($_POST['images']) ) {
    foreach ( $_POST['images'] as $selected_images ) {
      $select_selc_img = select2('vialblity','images','image_id',$selected_images);
      if ( $select_selc_img != false ) {
        foreach ( $select_selc_img as $validate_of_img ) {
          if ( $validate_of_img['vialblity'] == 0 ) {
            update('images','vialblity = 1','image_id',$selected_images);
          }
        }
      }
    }
  }
}
/* start valibility for video */

/* /////////////////////////////////////////////////////// */

/* start upload pdf */
if ( isset($_POST['uploading_pdf']) ) {
  //if you place an se
  if (empty($_POST['add_name_for_pdf']) || empty($_POST['add_se_for_pdf'])) {
    echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">لقد نسيت وضع اسم او صف للملف</span>';
  } else {
    $pdfSelected = $_FILES['PDF_file'];
    if ($pdfSelected['error'] > 0) {
      echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">حدث خطأ..! ربما انت لم تختر ملفا</span>';
    } else {
      if ( $pdfSelected['size'] > 100000000 ) {
        echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">الملف اكبر من 100 MG</span>';
      } else {
      $pdfTypePrepare = array_reverse(explode('.', $pdfSelected['name']));
      $pdfType = $pdfTypePrepare[0];
      if ($pdfType != 'pdf') {
        echo '<span class="alert alert-danger die" style="position: absolute;top:10px;right:5px;z-index:100">(المطلوب pdf) الملف غير صحيح</span>';
      } else {
        if ($_POST['add_se_for_pdf'] == '1se') {
          $to_pdf_file = $pdf_for_1;
        } elseif ($_POST['add_se_for_pdf'] == '2se') {
          $to_pdf_file = $pdf_for_2;
        } elseif ($_POST['add_se_for_pdf'] == '3se') {
          $to_pdf_file = $pdf_for_3;
        }
        $all_in_pdf_dir = scandir($to_pdf_file);
        $pdf_name = random_int(0,9999) . '^' . $pdfSelected['name']; 
        //if no one as same as the new file
        if (in_array($pdf_name, $all_in_pdf_dir)) {
          echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">اسم هذا الملف موجود من قبل</span>';
        } else {
          //upload the pdf in pdf directory
          $pdf_nameANDdir = $to_pdf_file . '/' . $pdf_name;
          $upload_pdf = move_uploaded_file($pdfSelected['tmp_name'], $pdf_nameANDdir);
          if ($upload_pdf) {
            for ($pp = 0; $pp < 10; $pp++) {
              //put arandeom
              $pdf_id_rand = random_int(0, 9999999);
              //select it in db
              $pdf_id_DB = select1('pdf_id', 'pdf', 'pdf_id', $pdf_id_rand);
              //if isn't in db
              if ($pdf_id_DB == 0) {
                //stop loop
                $pp = 11;
              }
              //if loop end and no id has been putten
              if ($pp < 10 && $pdf_id_DB > 0) {
                //repeate the loop
                $pp = 0;
              }
            }
            $name_for_pdf = filter_var($_POST['add_name_for_pdf'], FILTER_SANITIZE_STRING);
            $seco_for_pdf = filter_var($_POST['add_se_for_pdf'], FILTER_SANITIZE_STRING);

            $insert_pdf = $db->prepare("INSERT INTO pdf (pdf_id,pdf,name,se,vilablity) VALUES (?,?,?,?,?) ");
            $insert_pdf->execute(array($pdf_id_rand,
                                          $pdf_nameANDdir,
                                          $name_for_pdf,
                                          $seco_for_pdf,
                                          0));

            if ($insert_pdf) {
              echo '<span class="alert alert-success die" style="position:absolute;top:10px;right:5px">تم الرفع بنجاح</span>';
            } else {
              unlink($pdf_nameANDdir);
              echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">*حدثت مشكلة في قواعد البيانات*</span>';
            }
          } else {
            echo '<span class="alert alert-danger die" style="position:absolute;top:10px;right:5px">*لم يتم رفع الملف*</span>';
          }
        }
      }
      }
    }
  }
}

/* end uploading pdf */

/* /////////////////////////////////////////////////////// */

/* start pdf is vilability */
if ( isset($_POST['save_pdf_vilability']) ) {
  if ( isset($_POST['pdf']) ) {
    foreach ( $_POST['pdf'] as $selected_pdf ) {
      $select_selc_pdf = select2('vilablity','pdf','pdf_id',$selected_pdf);
      if ( $select_selc_pdf != false ) {
        foreach ( $select_selc_pdf as $validate_of_pdf ) {
          if ( $validate_of_pdf['vilablity'] == 0 ) {
            update('pdf','vilablity = 1','pdf_id',$selected_pdf);
          }
        }
      }
    }
  }
}
/* end pdf is vilability */
