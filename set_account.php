<?php 
/*
----------------------------
*** sign in page
** if you don't have session will open
** if you have session reaturn for [ admin || *secoundry.php ]
----------------------------
*/

ob_start();

session_start();

// is make a code
if (!isset($_GET['code_id'])){
    header("location: code-log.php");
    exit();
}

//if he has session
if ( isset($_SESSION['phone']) && isset($_SESSION['id']) ) {
  //if he is student
  if ( $_SESSION['state'] == '10'/*student*/ ) {
    //go to your page
    if ( $_SESSION['se'] == '1se' ) {
      $to_1 = 'location: 1secoundry.php?id=' . $_SESSION['id'];
      header($to_1);
      exit();
    }
    elseif ( $_SESSION['se'] == '2se' ) {
      $to_2 = 'location: 2secoundry.php?id=' . $_SESSION['id'];
      header($to_2);
      exit();
    }
    elseif ( $_SESSION['se'] == '3se' ) {
      $to_3 = 'location: 3secoundry.php?id=' . $_SESSION['id'];
      header($to_3);
      exit();
    }
    else{
      session_unset();
      session_destroy();
      header("location: code-log.php");
      exit();
    }
  }
  //if he is damin
  elseif  ( $_SESSION['state'] == '11' /*admin*/ ){
    header('location: mr.php');
    exit();
  }
}
//if you don't have session
else {
  //open sign in page
  include_once 'init.php';
  include_once $connect ;
  include_once $functions;

  $title = 'Sign In | المفيد فى الفزياء';
  include_once $header;
  
  $code = select_info("*", "codes", "code", $_GET['code_id']) ;

  var_dump($code);
  $submit = false; // I use it to echo proccess cases when submit
  if ( isset($_POST['sign_in_code']) ) {
    $submit = true;
    $user_name       = filter_var($_POST['user_arabic_name'], FILTER_SANITIZE_STRING);
    $user_phone      = filter_var($_POST['user_phone'], FILTER_SANITIZE_NUMBER_INT);
    $parent_phone      = filter_var($_POST['parent_phone'], FILTER_SANITIZE_NUMBER_INT);
    $user_groub      = filter_var($_POST['user_groub'], FILTER_SANITIZE_STRING);
    $user_password_1 = filter_var($_POST['user_password_1'], FILTER_SANITIZE_STRING);
    $user_password_2 = filter_var($_POST['user_password_2'], FILTER_SANITIZE_STRING);
    $user_se         = filter_var($_POST['se_case'], FILTER_SANITIZE_STRING);
    $sign_err_array = array();
    if( empty($user_name) || empty($user_phone) ||empty($user_password_1) || empty($user_password_2) ){
      $sign_err_array[] = 'تأكد من ملئ جميع الحقول';
    } else {
      // regular exepretion for pure arabic name
      if(!preg_match("/^[^A-z0-9!@#$%^&*()|\/\"':;]+$/",$user_name)){
      $sign_err_array[] = 'اعد كتابه <b>اسمك</b> بصورة صحيحة';
      } else {
        if( strlen($user_name) > 80 ) {
          $sign_err_array[] = 'الأسم اكبر من <b>40</b> حرف';
        } elseif ( strlen($user_name) < 10 ) {
          $sign_err_array[] = 'الأسم اصغر من <b>10</b> حرف';
        }
      }
      // regular exepretion for pure phone number
      if(!preg_match("/^[0-9]{11}$/",$user_phone)) {
        $sign_err_array[] = 'اعد كتابه <b>رقمك</b> بصورة صحيحة';
      }
      // regular exepretion for pure phone number
      if(!preg_match("/^[0-9]{11}$/",$parent_phone)) {
        $sign_err_array[] = 'اعد كتابه <b>رقمك</b> بصورة صحيحة';
      }
      // regular exepretion for pure groub name
      if(!empty($user_groub)){
        if(!preg_match("/^[^!@#$%^&*()|\/\"':;]+$/",$user_groub)) {
          $sign_err_array[] = 'اعد كتابه <b>المجموعة</b> بصورة صحيحة';
        } else{
          if(strlen($user_groub) > 80){
          $sign_err_array[] = 'لا توجد مجموعة حروفها اكثر من <b>40</b>';
          }
        }
      }
      // pure password
      if ( $user_password_1 != $user_password_2 ) {
        $sign_err_array[] = 'الرمز الأول ليس مطابقا للأخر';
      } else {
        if( strlen($user_password_1) > 50 ) {
          $sign_err_array[] = "الرمز اكبر من <b>50</b> حروف";
        }elseif( strlen($user_password_1) < 5 ) {
          $sign_err_array[] = "الرمز اصغر من <b>5</b> حروف";
        }
      }
      // pure se case
      if(! preg_match('/([1-3][a-z]{2})/',$user_se ) || $user_se == '0' ){
        $sign_err_array[] = "الصف غير معروف";
      }
    }
    // pure id
    for ($z = 0; $z < 10; $z++) {
      //put arandeom
      $user_id = random_int(10, 99999);
      //select it in db
      $idDB = select_info('id', 'students', 'id', $user_id);
      //if isn't in db
      if ($idDB == false) {
        //stop loop
        $z = 11;
      }
      //if loop end and no id has been putten
      if ($z < 10 && $idDB == false) {
        //repeate the loop
        $z = 0;
      }
    }
    if ( empty($sign_err_array) ) {
      $is_phone_here = select_info('phone','students','phone',$user_phone);
      if ( $is_phone_here == false ) {
        // delete the code
        $delete = $db->prepare("DELETE FROM codes WHERE id = ?");
        $delete->execute(array($code[0]['id']));
        // Insert the user to db
        $insert_info = $db->prepare("INSERT INTO students(id,ar_name,phone,parent_phone,password,money,se,code,state,groub) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $insert_process = $insert_info->execute(array($user_id,$user_name,$user_phone,$parent_phone,$user_password_1,$code[0]['activate'],$user_se,$code[0]['code'],'10',$user_groub));
        echo $user_id . '<br>' . $user_se;
        if( $insert_process ) {
          // set sessions
          $_SESSION['id']    = $user_id;
          $_SESSION['phone']  = $user_phone;
          $_SESSION['money']  = $code[0]['activate'];
          $_SESSION['se']    = $user_se;
          $_SESSION['code']    = $code[0]['code'];
          $_SESSION['state'] = '10';
          $location = $user_se . 'coundry.php';
          header('location: '.$location);
        } else {
          $sign_err_array[] = 'حدث خطأ في التسجيل';
        }
      } else {
        $sign_err_array[] = 'هذا الرقم موجود من قبل';
      }
    }
  }
  var_dump($code);
  ?>
  <form action="" method="post" class="sign-form">
    <h2 class="text-center t1">Code: <?= $code[0]['code'] ?></h2>
    <div class="back"></div>
    <div class='sign-div'>
      <h1 class="text-center">حساب جديد</h1>
      <?php 
      if ( $submit ) {
        // proccess cases
        if (! empty($sign_err_array) ) {
          echo '<ul class="alert alert-danger" style=text-align:right;list-style:none>';
          foreach ( $sign_err_array as $sign_err ) {
            echo '<li>'. $sign_err .'</li>';
          }
          echo '</ul>';
        }
      }
      ?>
      <img src="<?php echo $imges . 'tt.svg' ?>" class="img" alt="book and pin img">
      <div class="field require">
        <div class="txt">أسمك كاملا باللغة العربية</div>
        <input type="text"
                id="arabicInput" 
                class="input" 
                name="user_arabic_name" 
                placeholder="ادخل اسمك ثلاثيا مستخدما اللغة العربية" 
                required 
                value="<?php if(isset($user_name)){echo $user_name;} ?>" >
        <i class="fa fa-user fa-fw icon"></i>
      </div>
      <div class="field require">
        <div class="txt">رقم هاتفك</div>
        <input type="text"
                id="phoneInput" 
                class="input input-phone" 
                name="user_phone" 
                placeholder="رقم هاتفك" 
                required value="<?php if(isset($user_phone)){echo $user_phone;}?>">
        <i class="fa fa-phone fa-fw icon"></i>
      </div>
      <div class="field require">
        <div class="txt">تلفون ولى الأمر</div>
        <input type="text"
                id="phoneInput" 
                class="input input-phone" 
                name="parent_phone" 
                placeholder="رقم هاتفك" 
                required value="<?php if(isset($user_phone)){echo $user_phone;}?>">
        <i class="fa fa-phone fa-fw icon"></i>
      </div>
      <div class="field">
        <div class="txt">المجموعة الخاصة بك</div>
        <i class="fa fa-users fa-fw icon"></i>
        <select name="user_groub" id="groubInput" class="input"value="<?php if(isset($user_groub)){echo $user_groub;}?>">
          <option value="ابوحماد">ابوحماد</option>
          <option value="الحلمية">الحلمية</option>
          <option value="العاشر">العاشر</option>
        </select>
        
        
      </div>
      <div class="field require">
        <div class="txt">الرمز السري</div>
        <input type="password" id="pass1" class="input input-pass" name="user_password_1" placeholder="ادخل رمز سري تستطيع تذكرة" required>
        <span class="show-pass"><i class="fa fa-eye-slash fa-fw"></i></span>
        <span class="hide-pass" style="display: none"><i class="fa fa-eye fa-fw"></i></span>
        <i class="fa fa-lock fa-fw icon"></i>
      </div>
      <div class="field require">
        <div class="txt">إعادة الرمز السري</div>
        <input type="password" id="pass2" class="input input-pass" name="user_password_2" placeholder="اعد كتابة الرمز" required>
        <i class="fa fa-lock fa-fw icon"></i>
      </div>
      <div class="field require">
        <div class="txt">أختر الصف</div>
        <select name="se_case" id="selectSe" class="select-se">
          <option value="0">أختر الصف</option>
          <option value="1se">الصف الأول(1) الثانوي</option>
          <option value="2se">الصف الثاني(2) الثانوي</option>
          <option value="3se">الصف الثالث(3) الثانوي</option>
        </select>
      </div>
      <br>
      <button type="submit" name="sign_in_code" id="log" class="btn btn-info btn-md">تسجيل الحساب <i class="fa fa-sign-in-alt fa-fw"></i></button>
    </div>
  </form>
	<footer class="sign-footer">
		<span class="my">BY => &hearts; <a href="#">Mohamed Elshishtawy</a></span>
		<span class="copy">all right are reseved &copy; 2021</span>
    </footer>
  
  <?php
  include_once $footer;
}
ob_end_flush();

?>