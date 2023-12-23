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
if ( isset($_SESSION['name']) && isset($_SESSION['id']) ) {
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
      header('location: index.php');
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

  $title = 'تسجيل الدخول';
  include_once $header;
  ?>
  <div class="welc-div">
    <div class="welc-div welc-div-2">
      <div class="txt txt-1">
        المنصة التعليمية
      </div>
      <div class="txt txt-2">
        للبروفسير في الفزياء
      </div>
      <div class="txt txt-3">
        للدخول لمنصة البروف محمد مكي <i class="fa fa-angle-double-left"></i><br>
        ادخل اسمك و الباسورد بالأسفل
        نأمل دائماَ التفوق <br>
        لجيع طلابنا <br>
        الأطباء والمهندسين
      </div>
      <div class="txt txt-4">
        سجل الدخول <br>
        <i class="fa fa-angle-double-down down-i"></i>
      </div>
    </div>
  </div>
  <form action="" method="post" class="log-form">
    <div class='log-div'>
      <h2 class="text-center">تسجيل الدخول</h2>
      <img src="<?php echo $imges . 'test.svg' ?>" class="img" alt="book and pin img">
      <div class="name-filed">
        <div class="txt">أسم المستخدم</div>
        <input type="text" id="input" class="input" name="student_name" placeholder="ادخل هنا اسم المستخدم...">
        <i class="fa fa-user icon-1"></i>
      </div>
      <div class="pass-field">
        <div class="txt">الرمز السري</div>
        <input type="password" id="input" class="input input-pass" name="student_password" placeholder="ادخل هنا اسم المستخدم...">
        <span class="show-pass"><i class="fa fa-eye-slash"></i></span>
        <span class="hide-pass" style="display: none"><i class="fa fa-eye"></i></span>
        <i class="fa fa-lock icon-2"></i>
      </div>
      <br>
      <button type="submit" name="log_btn" class="btn btn-info btn-md">سجل <i class="fa fa-sign-in-alt"></i></button>
    </div>
  </form>
	<!-- <footer class="footer">
		<span class="my">BY -> &hearts; <a href="#">MEDO ELSHISHTAWY</a></span>
		<span class="copy">all right are reseved &copy; 2021</span>
    </footer> -->
  
  <?php
  include_once $footer;
}
?>