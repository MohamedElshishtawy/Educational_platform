<?php 
/*
----------------------------
*** index page
** if you don't have session will open
** if you have session reaturn for [ admin || *secoundry.php ]
----------------------------
*/
session_start();

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
  //open log in page
  include_once 'init.php';
  include_once $connect ;
  include_once $functions;
  include_once $db_prog ;

  $title = 'المفيد فى الفزياء';
  include_once $header;
  ?>
  <form action="" method="post" class="log-form">
    <h2 class="text-center t1">المفيد فى الفزياء</h2>
    <div class="back"></div>
    <div class='log-div'>
      <h1 class="text-center">تسجيل الدخول</h1>
      <img src="<?php echo $imges . 'tt.svg' ?>" class="img" alt="book and pin img">
      <div class="name-filed require">
        <div class="txt">رقم الهاتف</div>
        <input type="text" id="input1" class="input" name="student_phone" placeholder="ادخل هنا اسم المستخدم...">
        <i class="fa fa-phone icon-1"></i>
      </div>
      <div class="pass-field require">
        <div class="txt">الرمز السري</div>
        <input type="password" id="input2" class="input input-pass" name="student_password" placeholder="ادخل هنا اسم المستخدم...">
        <span class="show-pass"><i class="fa fa-eye-slash"></i></span>
        <span class="hide-pass" style="display: none"><i class="fa fa-eye"></i></span>
        <i class="fa fa-lock icon-2"></i>
      </div>
      <br>
      <button type="submit" name="log_btn" id="log" class="btn btn-info btn-md">سجل <i class="fa fa-sign-in-alt"></i></button>
      <div class="sign-in-div text-center">
          <a href="sign-up.php" class="sign-up">عمل حساب جديد</a>
        </div>
        <div class="sign-in-div text-center">
          <a href="code-log.php" class="sign-up">التسجيل بالكود</a>
        </div>
    </div>
  </form>
	<footer class="footer">
		<span class="my">BY => &hearts; <a href="#">Mohamed Elshishtawy</a></span>
		<span class="copy">all right are reseved &copy; 2021</span>
    </footer>
  
  <?php
  include_once $footer;
}
?>