<?php
/*
----------------------
*** Admin page
----------------------
*/

ob_start();

session_start();
//if he has sessions

if (isset($_SESSION['se']) && $_SESSION['se'] == 'AD' && $_SESSION['id'] == '18542') {

  include_once 'init.php';

  include_once $connect;

  include_once $functions;

  include_once $db_prog;

  $title = 'الإدارة';

  include_once $header;

  if (!isset($_GET['to'])) {
    //open main page
?>
    <!-- <form method="POST"><button class="btn btn-danger" type="submit" name="reset" style="position:absolute;left: 25px;top: 29px;">Logout</button></form> -->
    <?php if (isset($_POST['reset'])) {
      session_unset();
      session_destroy();
    } ?>
    <h2 class="prand">اهلا بعودتك مستر / احمد حامد النمر</h2>
    <form method="post" class="for-groub">
      <button type="submit" name="for_speshialists" class="fields feild-1"> <i class="fa fa-layer-group"></i> تقارير طلابي</button>
      <button type="submit" name="for_codes" class="fields feild-2"> <i class="fa fa-layer-group"></i>الأكواد</button>
      <button type="submit" name="for_add_exam" class="fields feild-3"> <i class="fa fa-clipboard-list"></i> إضافة امتحانات</button>
      <button type="submit" name="for_students_marks" class="fields feild-4"> <i class="fa fa-scroll"></i> درجات الطلاب</button>
      <button type="submit" name="for_students_add_video" class="fields feild-5"> <i class="fa fa-video"></i> إضافة فيديو</button>
      <button type="submit" name="for_students_message" class="fields feild-6"> <i class="fa fa-envelope"></i> إرسال رسالة</button>
      <button type="submit" name="for_add_student" class="fields feild-7"> <i class="fa fa-plus"></i> إضافة طلاب</button>
      <form method="POST">
        <button class="fields feild-8 btn btn-danger" type="submit" name="reset" > <i class="fa fa-door-open"></i>  Logout</button>
      </form>
      <!-- <button type="submit" name="for_add_photo" class="fields feild-8"> <i class="fa fa-camera"></i> إضافة صورة</button> -->
      <!-- <button type="submit" name="for_pdf" class="fields feild-9"> <i class="fa fa-file-pdf"></i> إضافة PDF</button> -->
      <!-- <a href="https://www.webex.com" target="_blank"><button type="button" name="for_live" class="fields feild-9"> <i class="fa fa-file-video"></i> موقع البث المباشر</button></a> -->
    </form>
    <?php
    if (isset($_POST['for_speshialists'])) {
      header('location: ?to=students_s');
    } elseif (isset($_POST['for_codes'])) {
      header('location: ?to=codes');
    } elseif (isset($_POST['for_add_exam'])) {
      header('location: ?to=add_exam');
    } elseif (isset($_POST['for_students_marks'])) {
      header('location: ?to=marks');
    } elseif (isset($_POST['for_students_add_video'])) {
      header('location: ?to=add_video');
    } elseif (isset($_POST['for_students_message'])) {
      header('location: ?to=send_message');
    } elseif (isset($_POST['for_add_student'])) {
      header('location: mr.php?to=add_student');
    } elseif (isset($_POST['for_add_photo'])) {
      header('location: ?to=add_photo');
    } elseif (isset($_POST['for_pdf'])) {
      header('location: ?to=add_pdf');
    }
  } else {
    // the branches of page
    if ($_GET['to'] == 'students_s') {
      //open speshial informaion for students
    ?>
      <h2 class="page-title">التقارير</h2>
      <form method="post" class="back">
        <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
      </form>
      <div class="student-s-div">
        <div class="all-se-btn">
          <span class="se-btn se-btn-1 se-btn-active">الصف الأول</span>
          <span class="se-btn se-btn-2">الصف الثاني</span>
          <span class="se-btn se-btn-3">الصف الثالث</span>
        </div>
        <?php
        // set button if we in 1
        date_default_timezone_set('Africa/Cairo');
        $today = date('d');
        if ($today == 1) {
        ?>
          <form method="post">
            <button type="submit" class="btn btn-danger mony-down" name="re_mony">$ إفلاس الشهور</button>
          </form>
        <?php
          if (isset($_POST['re_mony'])) {
            $update_all_students_money = $db->prepare("UPDATE students SET money = 0 WHERE state = 10 ");
            $update_all_students_money->execute();
          }
        }
        ?>
        <form method="post">
          <!-- start 1 secoundry table -->
          <div class="se-div se-1-div active-table">
            <table id="table-1" border="1">
              <tbody>
                <tr>
                  <th colspan="6">
                    <h3>1ث</h3>
                  </th>
                  <th colspan="1">
                    <button type="button" class="btn btn-primary print-btn print-1" id='printFirstSeStudent'><i class="fa fa-print"></i> طباعة</button>
                  </th>
                  <th colspan="1">
                    <button type="button" class="btn btn-primary search-btn-1"><i class="fa fa-search"></i> بحث</button>
                  </th>
                  <th colspan="1">
                    <button type="submit" name="save_money" class="btn btn-success"><i class="fa fa-save"></i> حفظ</button>
                  </th>
                </tr>
                <tr>
                  <th colspan="7">
                    <input type="search" class="form-control search-1" id="search-1" placeholder="ابحث عما تريد في طلابك">
                  </th>
                </tr>
                <tr>
                  <th>الكود</th>
                  <th>الأسم</th>
                  <th>هاتف الطالب</th>
                  <th>هاتف ولى الأمر</th>
                  <th>الرمز</th>
                  <th>المجموعة</th>
                  <th>تعديل</th>
                  <th>حذف</th>
                  <th>الأشتراك</th>
                </tr>
                <?php
                //select all students ha 1se
                $students_selected = select_info('code,ar_name,phone,parent_phone,password,groub,money,id', 'students', 'se', '1se', 'ORDER BY ar_name');
                if ($students_selected != false) {
                  foreach ($students_selected as $student_1) {
                    //get all information for 1se
                ?>
                    <tr>
                      <td><?php echo $student_1['code']; ?></td>
                      <td><?php echo $student_1['ar_name']; ?></td>
                      <td><?php echo $student_1['phone']; ?></td>
                      <td><?php echo $student_1['parent_phone']; ?></td>
                      <td><?php echo $student_1['password']; ?></td>
                      <td><?php if (!empty($student_1['groub'])) {
                            echo $student_1['groub'];
                          } else {
                            echo 'غير معروف';
                          } ?></td>
                      <td><a class="btn btn-info" href="members.php?edit=<?php echo $student_1['id']; ?>"><i class="fa fa-edit"></i> تعديل</a></td>
                      <td><a class="btn btn-danger" href="members.php?delete=<?php echo $student_1['id']; ?>"><i class="fa fa-eraser"></i> حذف</a></td>
                      <td>
                        <?php
                        if ($student_1['money'] == '0') {
                          echo '<input type="checkbox" name="students[]" value="' . $student_1['id'] . '">';
                        } elseif ($student_1['money'] == '1') {
                          echo '<i class="fa fa-check-circle true-check"></i>';
                          echo '<a class="btn btn-primary valid-btn" href="members.php?ch_stud_money=' . $student_1['id'] . '">تعديل الشهر</a>';
                        } else {
                          echo '<span style="color:red">غير معروف</span>';
                        }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- end 1 secoundry table -->

          <!-- start 2 secoundry table -->
          <div class="se-div se-2-div">
            <table id="table-2" border="1">
              <tbody>
                <tr>
                  <th colspan="6">
                    <h3>2ث</h3>
                  </th>
                  <th colspan="1">
                    <button type="button" class="btn btn-primary print-btn print-2" id='printSecoundSeStudent'><i class="fa fa-print"></i> طباعة</button>
                  </th>
                  <th colspan="1">
                    <button type="button" class="btn btn-primary search-btn-2"><i class="fa fa-search"></i> بحث</button>
                  </th>
                  <th colspan="1">
                    <button type="submit" name="save_money" class="btn btn-success"><i class="fa fa-save"></i> حفظ</button>
                  </th>
                </tr>
                <tr>
                  <th colspan="7">
                    <input type="search" class="form-control search-2" id="search-2" placeholder="ابحث عما تريد في طلابك">
                  </th>
                </tr>
                <tr>
                <th>الكود</th>
                  <th>الأسم</th>
                  <th>هاتف الطالب</th>
                  <th>هاتف ولى الأمر</th>
                  <th>الرمز</th>
                  <th>المجموعة</th>
                  <th>تعديل</th>
                  <th>حذف</th>
                  <th>الأشتراك</th>
                </tr>
                <?php
                //select all students ha 2se
                $students_2_selected = select_info('code,ar_name,phone,parent_phone,password,groub,money,id', 'students', 'se', '2se', 'ORDER BY ar_name');
                if ($students_2_selected != false) {
                  foreach ($students_2_selected as $student_2) {
                    //get all information for 2se
                ?>
                    <tr>
                      <td><?php echo $student_2['code']; ?></td>
                      <td><?php echo $student_2['ar_name']; ?></td>
                      <td><?php echo $student_2['phone']; ?></td>
                      <td><?php echo $student_2['parent_phone']; ?></td>
                      <td><?php echo $student_2['password']; ?></td>
                      <td><?php if (!empty($student_2['groub'])) {
                            echo $student_2['groub'];
                          } else {
                            echo 'غير معروف';
                          }  ?></td>
                      <td><a class="btn btn-info" href="members.php?edit=<?php echo $student_2['id']; ?>"><i class="fa fa-edit"></i> تعديل</a></td>
                      <td><a class="btn btn-danger" href="members.php?delete=<?php echo $student_2['id']; ?>"><i class="fa fa-eraser"></i> حذف</a></td>
                      <td>
                        <?php
                        if ($student_2['money'] == '0') {
                          echo '<input type="checkbox" name="students[]" value="' . $student_2['id'] . '">';
                        } elseif ($student_2['money'] == '1') {
                          echo '<i class="fa fa-check-circle true-check"></i>';
                          echo '<a class="btn btn-primary valid-btn" href="members.php?ch_stud_money=' . $student_2['id'] . '">تعديل الشهر</a>';
                        } else {
                          echo '<span style="color:red">غير معروف</span>';
                        }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- end 2 secoundry table -->

          <!-- start 3 secoundry table -->
          <div class="se-div se-3-div">
            <table id="table-3" border="1">
              <tbody>
                <tr>
                  <th colspan="6">
                    <h3>3ث</h3>
                  </th>
                  <th colspan="1">
                    <button type="button" class="btn btn-primary print-btn print-3" id='printThirdSeStudent'><i class="fa fa-print"></i> طباعة</button>
                  </th>
                  <th colspan="1">
                    <button type="button" class="btn btn-primary search-btn-3"><i class="fa fa-search"></i> بحث</button>
                  </th>
                  <th colspan="1">
                    <button type="submit" name="save_money" class="btn btn-success"><i class="fa fa-save"></i> حفظ</button>
                  </th>
                </tr>
                <tr>
                  <th colspan="7">
                    <input type="search" class="form-control search-3" id="search-3" placeholder="ابحث عما تريد في طلابك">
                  </th>
                </tr>
                <tr>
                <th>الكود</th>
                  <th>الأسم</th>
                  <th>هاتف الطالب</th>
                  <th>هاتف ولى الأمر</th>
                  <th>الرمز</th>
                  <th>المجموعة</th>
                  <th>تعديل</th>
                  <th>حذف</th>
                  <th>الأشتراك</th>
                </tr>
                <?php
                //select all students ha 3se
                $students_3_selected = select_info('code,ar_name,phone,parent_phone,password,groub,money,id', 'students', 'se', '3se', 'ORDER BY ar_name');

                if ($students_3_selected != false) {
                  foreach ($students_3_selected as $student) {
                    //get all information for 1se
                ?>
                    <tr>
                    <td><?php echo $student['code']; ?></td>
                      <td><?php echo $student['ar_name']; ?></td>
                      <td><?php echo $student['phone']; ?></td>
                      <td><?php echo $student['parent_phone']; ?></td>
                      <td><?php echo $student['password']; ?></td>
                      <td><?php if (!empty($student['groub'])) {
                            echo $student['groub'];
                          } else {
                            echo 'غير معروف';
                          }  ?></td>
                      <td><a class="btn btn-info" href="members.php?edit=<?php echo $student['id']; ?>"><i class="fa fa-edit"></i> تعديل</a></td>
                      <td><a class="btn btn-danger" href="members.php?delete=<?php echo $student['id']; ?>"><i class="fa fa-eraser"></i> حذف</a></td>
                      <td>
                        <?php
                        if ($student['money'] == '0') {
                          echo '<input type="checkbox" name="students[]" value="' . $student['id'] . '">';
                        } elseif ($student['money'] == '1') {
                          echo '<i class="fa fa-check-circle true-check"></i>';
                          echo '<a class="btn btn-primary valid-btn" href="members.php?ch_stud_money=' . $student['id'] . '">تعديل الشهر</a>';
                        } else {
                          echo '<span style="color:red">غير معروف</span>';
                        }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- start 3 secoundry table -->
        </form>
      </div>
    <?php
    } elseif ($_GET['to'] == "codes") {
      $codes = select_info_no_where("*", "codes");
      $code  = '';
      $n = 1;
    ?>

      <form method="post" class="back">
        <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
      </form>

      <form method="post">

        <h2 class="page-title">أكواد الطلاب</h2>

        <div class="code-div">

          <div class="all-se-btn">
            <span class="se-btn se-btn-1 se-btn-active">الصف الأول</span>
            <span class="se-btn se-btn-2">الصف الثاني</span>
            <span class="se-btn se-btn-3">الصف الثالث</span>
          </div>

          <div class="se-div se-1-div active-table">
            <table class="table text-center table-deg-1" border="1" dir="rtl">
              <tr>
                <th colspan="3" class="text-center">1 ث</th>
              </tr>
              <tr>
                <th class="text-center">الرقم</th>
                <th class="text-center">الكود</th>
                <th class="text-center">الباسورد</th>
              </tr>
              <?php if ($codes) {
                foreach ($codes as $code) { 
                  if ($code['se']!= "1se"){
                    continue;
                  }?>
                  <tr>
                    <td><?= $n++;; ?></td>
                    <td><?= $code['code'] ?></td>
                    <td><?= $code['password'] ?></td>
                  </tr>
              <?php }
              } ?>
              <tr>
                <td colspan="3">
                  <div class="add-code-g">
                    <input type="text" name="code1" placeholder="الكود  ####" class="code-inp">
                    <button type="submit" name="generate_code1"  value="1se" class="btn btn-success">إضافة +</button>
                  </div>
                </td>
              </tr>
            </table>
          </div>

          <div class="se-div se-2-div">
            <table class="table text-center table-deg-2" border="1" dir="rtl">
              <tr>
                <th colspan="3" class="text-center">2 ث</th>
              </tr>
              <tr>
                <th class="text-center">الرقم</th>
                <th class="text-center">الكود</th>
                <th class="text-center">الباسورد</th>
              </tr>
              <?php if ($codes) {
                foreach ($codes as $code) { 
                  if ($code['se']!= "2se"){
                    continue;
                  }?>
                  <tr>
                    <td><?= $n++;; ?></td>
                    <td><?= $code['code'] ?></td>
                    <td><?= $code['password'] ?></td>
                  </tr>
              <?php }
              } ?>
             <tr>
                <td colspan="3">
                  <div class="add-code-g">
                    <input type="text" name="code2" placeholder="الكود  ####" class="code-inp">
                    <button type="submit" name="generate_code2" value="2se" class="btn btn-success">إضافة +</button>
                  </div>
                </td>
              </tr>>
            </table>
          </div>

          <div class="se-div se-3-div">
            <table class="table text-center table-deg-3" border="1" dir="rtl">
              <tr>
                <th colspan="3" class="text-center">3 ث</th>
              </tr>
              <tr>
                <th class="text-center">الرقم</th>
                <th class="text-center">الكود</th>
                <th class="text-center">الباسورد</th>
              </tr>
              <?php if ($codes) {
                foreach ($codes as $code) { 
                  if ($code['se']!= "3se"){
                    continue;
                  }?>
                  <tr>
                    <td><?= $n++;; ?></td>
                    <td><?= $code['code'] ?></td>
                    <td><?= $code['password'] ?></td>
                  </tr>
              <?php }
              } ?>
              <tr>
                <td colspan="3">
                  <div class="add-code-g">
                    <input type="text" name="code3" placeholder="الكود  ####" class="code-inp">
                    <button type="submit" name="generate_code3" value="3se" class="btn btn-success">إضافة +</button>
                  </div>
                </td>
              </tr>
            </table>
          </div>

        </div>
      </form>
    <?php

    }
    // add exam page...
    elseif ($_GET['to'] == 'add_exam') {
      //open add exams for students
    ?>
      <form method="post" class="back">
        <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
      </form>
      <form method="POST" class="quis-fr" enctype="multipart/form-data">
        <h2 class="title">اضافة امتحان</h2>
        <div class="se-chose">
          <div class="se-title"> <i class="fa fa-users"></i> الامتحان للصف:</div>
          <div><input type="radio" name="se" id="se11" value="1se"> <label for="se11" class="se-value">الصف الاول الثانوي</label></div>
          <div><input type="radio" name="se" id="se22" value="2se"> <label for="se22" class="se-value">الصف الثاني الثانوي</label></div>
          <div><input type="radio" name="se" id="se33" value="3se"> <label for="se33" class="se-value">الصف الثالث الثانوي</label></div>
        </div>
        <div class="exam-mains">
          <div class="main-title"> <i class="fa fa-users"></i> المعلومات الاساسية للامتحان</div>
          <hr>
          <div>
            <label class="exam-txt"> <i class="fa fa-edit"></i> عنوان الامتحان</label>
            <input type="text" name="exam_name" id="exam_name" class="input" placeholder="عنوان ليتمكن طلابك من معرفة محتوي الامتحان">
            <i class="fa fa-edit icons"></i>
          </div>
          <hr>
          <div>
            <label class="exam-txt"> <i class="fa fa-stopwatch "></i> عدد الدقائق</label>
            <input type="number" min="0" value="1" name="exam_time" id="exam_time" class="input input-num">
          </div>
          <hr>
          <div>
            <label class="exam-txt"> <i class="fa fa-stopwatch "></i> الفترة المتاحة</label>
            <label for="start_date">من</label>
            <input type="datetime-local" name="exam_date_start" id="start_date" class="date-input">
            <label for="end_date">الى</label>
            <input type="datetime-local" name="exam_date_end" id="end_date" class="date-input">
          </div>
        </div>
        <div class="exam-div" id="examDiv">
          <div id="ex" class="ex">
            <h2 id="nameEx"></h2>
          </div>
          <hr>
          <div class="btn-div">
            <div class="btn btn-success add-qustion" id="addQustion">
              <i class="fa fa-plus"></i>
              أضف سؤالا
            </div>
            <span class="badge"><input type="number" min="0" value="1" class="num-of-qus-inp" id="numOFq"></span>
          </div>
          <div class="btn btn-danger delete-btn" id="deleteQustion"><i class="fa fa-times"></i> إزالة اخر سؤال</div>
          <button type="submit" class="btn btn-info add-ex-btn" name="upload_exam">
            <i class="fa fa-upload"></i> رفع لامتحان
          </button>
        </div>
      </form>
      <form method="post" class="add-form activ-form">
        <table border="1">
          <tbody>
            <tr>
              <th>إسم الإمتحان</th>
              <th>تاريخ التنزيل</th>
              <th>الصف</th>
              <th>من</th>
              <th>الى</th>
              <th>حذف</th>
              <th>الفاعلية <button type="submit" name="save_exam_avilability" class="btn btn-success">حفظ <i class="fa fa-save"></i></button></th>
              <th>ظهور الدرجة <button type="submit" name="save_exam_degree_avilability" class="btn btn-success">حفظ <i class="fa fa-save"></i></button></th>
            </tr>
            <?php
            $exams_select = select_info('*', 'exams', 'vilablility', '0', ' OR vilablility = 1 ORDER BY se, exam_name');
            if ($exams_select) {
              foreach ($exams_select as $exam_select) {
            ?>
                <tr>
                  <td><?php echo str_replace('_', ' ', $exam_select['exam_name']); ?></td>
                  <td><?php echo $exam_select['date']; ?></td>
                  <td><?php echo $exam_select['se']; ?></td>
                  <td><?php echo $exam_select['start_date']; ?></td>
                  <td><?php echo $exam_select['end_date']; ?></td>
                  <td><a href="members.php?del_exam=<?php echo str_replace(' ', '_', $exam_select['exam_name']); ?>" class="btn btn-danger">حذف</a></td>
                  <td>
                    <?php
                    if ($exam_select['vilablility'] == 1) {
                      echo '<i class="fa fa-check-circle true-check"></i>';
                      echo '<a class="btn btn-info valid-btn" href="members.php?ch_exam_vilab=' . str_replace(' ', '_', $exam_select['exam_name']) . '">إلغاء التفعيل</a>';
                    } else {
                      echo '<input type="checkbox" name="exams[]" value="' . str_replace('_', ' ', $exam_select['exam_name']) . '">';
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    if ($exam_select['see_degree'] == 1) {
                      echo '<i class="fa fa-check-circle true-check"></i>';
                      echo '<a class="btn btn-info valid-btn" href="members.php?ch_exam_deg_vilab=' . str_replace(' ', '_', $exam_select['exam_name']) . '">إلغاء التفعيل</a>';
                    } else {
                      echo '<input type="checkbox" name="deg_exams[]" value="' . str_replace('_', ' ', $exam_select['exam_name']) . '">';
                    }
                    ?>
                  </td>
                </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>
      </form>
    <?php
      /* end add exam page */

      //uploda exam progress

    } elseif ($_GET['to'] == 'marks') {
      //open marks for students
    ?>
      <h2 class="page-title">درجات وحضور الطلاب</h2>
      <form method="post" class="back">
        <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
      </form>
      <div class="student-s-div">
        <div class="all-se-btn">
          <span class="se-btn se-btn-1 se-btn-active">الصف الأول</span>
          <span class="se-btn se-btn-2">الصف الثاني</span>
          <span class="se-btn se-btn-3">الصف الثالث</span>
        </div>
        <form method="post" class="students-marks">
          <!-- start 1 secoundry table for marks -->
          <div class="se-div se-1-div active-table">
            <table border="1" class="table-deg-1">
              <tbody>
                <?php
                $select_columns_1 = $db->prepare("SHOW COLUMNS FROM exams_for_1");
                $select_columns_1->execute();
                ?>
                <tr>
                  <td colspan="<?php echo $select_columns_1->rowCount() - 1; ?>">
                    <h3>1ث</h3>
                  </td>
                  <td>
                    <div id="print1" class="btn btn-success"><i class="fa fa-print"></i> Print</div>
                  </td>
                </tr>
                <tr>
                  <th colspan="<?php echo $select_columns_1->rowCount(); ?>">
                    <input type="search" class="form-control search-deg-1" id="search-deg-1" placeholder="ابحث عما تريد في طلابك">
                  </th>
                </tr>
                <tr>
                  <?php
                  if ($select_columns_1->rowCount() > 0) {
                    $columns_1 = $select_columns_1->fetchAll();
                    foreach ($columns_1 as $column_1) {
                      for ($colum_count_1 = 0; $colum_count_1 < count($column_1); $colum_count_1 += 20) {
                        if ($column_1[$colum_count_1] == 'student_id') {
                          echo '<th>' . 'اسم الطالب' . '</th> ';
                        } else {
                          echo '<th>' . str_replace('_', ' ', $column_1[$colum_count_1]) . '</th> ';
                        }
                      }
                    }
                  }
                  ?>
                </tr>
                <?php
                // select all information about student [ar_name-marks..]
                $select_student_marks_information_1 = $db->prepare("SELECT s.ar_name,e.* FROM students s LEFT JOIN exams_for_1 e ON e.student_id = s.id WHERE s.se = '1se' ORDER BY s.ar_name ");
                $select_student_marks_information_1->execute();
                // if there is a student here
                if ($select_student_marks_information_1->rowCount() > 0) {
                  // if there is exams
                  if ($select_columns_1->rowCount() > 0) {
                    // fetch the student information
                    $marks_informations_1 = $select_student_marks_information_1->fetchAll();
                    foreach ($marks_informations_1 as $mark_information_1) {
                      echo '<tr>';
                      for ($tr_1 = 0; $tr_1 < count($mark_information_1) / 2; $tr_1++) {
                        if ($tr_1 != 1 && $mark_information_1[$tr_1] == '') {
                          echo '<td style="color:red">' . '<i class="fa fa-times"</i>' . '</td>';
                        } elseif ($tr_1 == 0) {
                          echo '<td>' . $mark_information_1[$tr_1]  . '</td>';
                        } elseif ($tr_1 == 1) {
                          // don't do think
                        } else {
                          echo '<td>';
                          $mark = strstr($mark_information_1[$tr_1], '@', true);
                          $mark_date = str_replace('@', '', strstr($mark_information_1[$tr_1], '@', false));
                          echo '<div class="mark">' . $mark . '</div>';
                          echo '<div class="mark-date">' . $mark_date . '</div>';
                          echo '</td>';
                        }
                      }
                      echo '</tr>';
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- end 1 secoundry table for marks -->

          <!-- start 2 secoundry table for marks -->
          <div class="se-div se-2-div">
            <table border="1" class="table-deg-2">
              <tbody>
                <?php
                $select_columns_2 = $db->prepare("SHOW COLUMNS FROM exams_for_2");
                $select_columns_2->execute();
                ?>
                <tr>
                  <td colspan="<?php echo $select_columns_2->rowCount() - 1; ?>">
                    <h3>2ث</h3>
                  </td>
                  <td>
                    <div id="print2" class="btn btn-success"><i class="fa fa-print"></i> Print</div>
                  </td>
                </tr>
                <tr>
                  <th colspan="<?php echo $select_columns_2->rowCount(); ?>">
                    <input type="search" class="form-control search-deg-2" id="search-deg-2" placeholder="ابحث عما تريد في طلابك">
                  </th>
                </tr>
                <tr>
                  <?php
                  if ($select_columns_2->rowCount() > 0) {
                    $columns_2 = $select_columns_2->fetchAll();
                    foreach ($columns_2 as $column_2) {
                      for ($colum_count_2 = 0; $colum_count_2 < count($column_2); $colum_count_2 += 20) {
                        if ($column_2[$colum_count_2] == 'student_id') {
                          echo '<th>' . 'اسم الطالب' . '</th> ';
                        } else {
                          echo '<th>' . str_replace('_', ' ', $column_2[$colum_count_2]) . '</th> ';
                        }
                      }
                    }
                  }
                  ?>
                </tr>
                <?php
                // select all information about student [ar_name-marks..]
                $select_student_marks_information_2 = $db->prepare("SELECT s.ar_name,e.* FROM students s LEFT JOIN exams_for_2 e ON e.student_id = s.id WHERE s.se = '2se' ORDER BY s.ar_name ");
                $select_student_marks_information_2->execute();
                // if there is a student here
                if ($select_student_marks_information_2->rowCount() > 0) {
                  // if there is exams
                  if ($select_columns_2->rowCount() > 0) {
                    // fetch the student information
                    $marks_informations_2 = $select_student_marks_information_2->fetchAll();
                    foreach ($marks_informations_2 as $mark_information_2) {
                      echo '<tr>';
                      for ($tr_2 = 0; $tr_2 < count($mark_information_2) / 2; $tr_2++) {
                        if ($tr_2 != 1 && $mark_information_2[$tr_2] == '') {
                          echo '<td style="color:red">' . '<i class="fa fa-times"></i>' . '</td>';
                        } elseif ($tr_2 == 0) {
                          echo '<td>' . $mark_information_2[$tr_2]  . '</td>';
                        } elseif ($tr_2 == 1) {
                          // don't do think
                        } else {
                          echo '<td>';
                          $mark_2 = strstr($mark_information_2[$tr_2], '@', true);
                          $mark_date_2 = str_replace('@', '', strstr($mark_information_2[$tr_2], '@', false));
                          echo '<div class="mark">' . $mark_2 . '</div>';
                          echo '<div class="mark-date">' . $mark_date_2 . '</div>';
                          echo '</td>';
                        }
                      }
                      echo '</tr>';
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- end 2 secoundry table for marks -->

          <!-- start 3 secoundry table for marks -->

          
          <div class="se-div se-3-div">
              <table class="table">
                <thead>
                  <tr>
                    <th class="text-center">الإمتحانات</th>
                  </tr>
                </thead>
                <tbody>
                <?php $exams = $db->prepare("SELECT * FROM exams WHERE se = '3se'");
                $exams->execute();
                if($exams->rowCount() > 0){
                  $exams = $exams->fetchAll(PDO::FETCH_ASSOC);
                  foreach($exams as $exam){
                    echo "<tr>";
                    echo "<td class='text-center'>";
                    echo '<a href="exam_deg.php?exam='.$exam["id"].'">'. $exam["exam_name"] .'</a></td>';
                    echo "</tr>";
                  }
                } ?>
                </tbody>
              </table>
              
          </div>
          <!-- end 3 secoundry table for marks -->
        <?php

      } elseif ($_GET['to'] == 'add_video') {
        //open upload video for students          
        ?>
          <form method="post" class="back">
            <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
          </form>
          <form method="post" class="add-form" enctype="multipart/form-data">
            <h2 class="title">اضافة فيديو</h2>
            <div class="add-groub">
              <lable class="txt">اسم الفيديو</lable>
              <input type="text" class="input" name="add_name_for_v" placeholder="عنوان الفيديو">
              <i class="fa fa-video fa-fw icons"></i>
            </div>
            <hr>
            <div class="add-groub">
              <lable class="txt">صف الفيديو</lable>
              <input type="text" class="input" name="add_dis_for_v" placeholder="ضع وصفا يفهم منه الطلاب الاشياء المهمه">
              <i class="fa fa-cogs fa-fw icons"></i>
            </div>
            <hr>
            <div class="add-groub">
              <div class="txt">ختر الصف</div>
              <div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_v" value="1se" id="1"><label for="1" class="txt">الصف الاول الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_v" value="2se" id="2"><label for="2" class="txt">الصف الثاني الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_v" value="3se" id="3"><label for="3" class="txt">الصف الثالث الثانوي</label>
                </div>
              </div>
            </div>
            <hr>
            <div class="add-groub">
              <div class="txt">اختر الفيديو</div>
              <input type="file" name="file">
            </div>
            <hr>
            <div class="add-groub">
              <div class="txt">او ضع رابطا الفيديو</div>
              <input type="text" class="input" name="video_link" placeholder="ليس اجباري...">
            </div>
            <hr>
            <button type="submit" name="up" class="btn btn-info btn-md add-btn"><i class="fa fa-upload"></i> رفع الفيديو</button>
          </form>
          <form method="post" class="add-form activ-form">
            <table border="1">
              <tbody>
                <tr>
                  <th>الفيديو</th>
                  <th>إسم الفيديو</th>
                  <th>وصف الفيديو</th>
                  <th>الصف</th>
                  <th>حذف</th>
                  <th>الفاعلية <button type="submit" name="save_vid_activity" class="btn btn-success">حفظ <i class="fa fa-save"></i></button></th>
                </tr>
                <?php
                $select_vids = $db->prepare("SELECT * from videos ORDER BY se,name");
                $select_vids->execute();
                if ($select_vids->rowCount() > 0) {
                  $all_vids = $select_vids->fetchAll();
                  foreach ($all_vids as $vid) {
                ?>
                    <tr>
                      <td><a href="<?php echo $vid['video']; ?>" target="_blank"><i class="fa fa-video"></i></a></td>
                      <td><?php echo $vid['name']; ?></td>
                      <td><?php echo $vid['description']; ?></td>
                      <td><?php echo $vid['se']; ?></td>
                      <td><a href="members.php?delet_vid=<?php echo $vid['video_id']; ?>" class="btn btn-danger">حذف</td>
                      <td>
                        <?php
                        if ($vid['activity'] == 1) {
                          echo '<i class="fa fa-check-circle true-check"></i>';
                          echo '<a class="btn btn-info valid-btn" href="members.php?ch_valid=' . $vid['video_id'] . '">إلغاء التفعيل</a>';
                        } else {
                          echo '<input type="checkbox" name="videoes[]" value="' . $vid['video_id'] . '">';
                        }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </form>
        <?php

      } elseif ($_GET['to'] == 'send_message') {

        //open send a message



        ?>

          <form method="post" class="back">

            <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>

          </form>

          <form method="post" class="add-form">

            <h2 class="title">ارسال رسالة</h2>





            <!-- start se -->

            <div class="add-groub">

              <div class="txt"><i class="fa fa-users" style="color:#5bc0de"></i> الي</div>

              <div>

                <div class="all-chek">

                  <input type="radio" name="to_se" value="1se" id="1"><label for="1" class="txt">الصف الاول الثانوي</label>

                </div>

                <div class="all-chek">

                  <input type="radio" name="to_se" value="2se" id="2"><label for="2" class="txt">الصف الثاني الثانوي</label>

                </div>

                <div class="all-chek">

                  <input type="radio" name="to_se" value="3se" id="3"><label for="3" class="txt">الصف الثالث الثانوي</label>

                </div>

              </div>

            </div>

            <!-- end se -->

            <hr>



            <!-- start message -->

            <div class="add-groub">

              <lable class="txt">الرسالة</lable>

              <textarea type="text" class="input" name="message" maxlength="300" style="height:200px"></textarea>

              <i class="fa fa-comment-dots fa-fw icons"></i>

            </div>

            <!-- end message-->



            <hr>



            <!-- start send btn -->

            <button type="submit" name="send" class="btn btn-info btn-md add-btn"><i class="fa fa-envelope"></i> ارسال</button>

            <!-- end send btn -->

          </form>

        <?php



      } elseif ($_GET['to'] == 'add_student') {
        //open add student
        ?>
          <form method="post" class="back">
            <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
          </form>
          <form method="post" class="add-form">
            <h2 class="title">تسجيل عضو جديد</h2>
            <?php
            //set up an password
            ?>
            <!-- start arabic name -->
            <div class="add-groub">
              <lable class="txt">الأسم كاملا</lable>
              <input type="text" class="input" name="add_ar_name" placeholder="ضع الاسم العربي">
              <i class="fa fa-user fa-fw icons"></i>
            </div>
            <!-- end arabic name -->
            <hr>
            <!-- start user name -->
            <div class="add-groub">
              <lable class="txt">رقم الهاتف</lable>
              <input type="text" class="input" name="add_phone" placeholder="رقم هاتف الطالب">
              <i class="fa fa-phone fa-fw icons"></i>
            </div>
            <!-- end user name -->
            <hr>
            <!-- start user groub -->
            <div class="add-groub">
              <lable class="txt">groub</lable>
              <input type="text" class="input" name="add_groub" placeholder="المحموعة">
              <i class="fa fa-comment-dots fa-fw icons"></i>
            </div>
            <!-- end user name -->
            <hr>
            <!-- start user password -->
            <div class="add-groub">
              <lable class="txt">الرمز السري</lable>
              <input type="text" class="input" name="add_password" placeholder="ضع رقم سري">
              <i class="fa fa-lock fa-fw icons"></i>
            </div>
            <!-- end user password -->
            <hr>
            <!-- start se -->
            <div class="add-groub">
              <div class="txt">ختر الصف</div>
              <div>
                <div class="all-chek">
                  <input type="radio" name="add_se" value="1se" id="1"><label for="1" class="txt">الصف الاول الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se" value="2se" id="2"><label for="2" class="txt">الصف الثاني الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se" value="3se" id="3"><label for="3" class="txt">الصف الثالث الثانوي</label>
                </div>
              </div>
            </div>
            <!-- end se -->
            <!-- start money -->
            <div class="add-groub">
              <div class="txt">حالة الشهر</div>
              <div class="all-chek">
                <input type="checkbox" name="money" id="money">
                <label for="money" class="txt">دافع الشهر</label>
              </div>
            </div>
            <!-- end money -->
            <!-- start add btn -->
            <button type="submit" name="add_student" class="btn btn-info btn-md add-btn"><i class="fa fa-plus"></i> اضافة</button>
            <!-- end add btn -->
          </form>
        <?php

      } elseif ($_GET['to'] == 'add_photo') {
        //open upload photo for students 
        ?>
          <form method="post" class="back" enctype="multipart/form-data">
            <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
          </form>
          <form method="post" class="add-form" enctype="multipart/form-data">
            <h2 class="title">اضافة صورة</h2>
            <?php
            // is errors arrey is not impty
            if (isset($uploading_errors) && $uploading_errors == true && isset($img_uploading_err)) {
              echo '<div class="alert alert-danger">';
              foreach ($img_uploading_err as $upload_err) {
                echo $upload_err . '<br>';
              }
              echo '</div>';
            }
            ?>
            <div class="add-groub">
              <lable class="txt">عنوان عام للصورة</lable>
              <input type="text" class="input" name="add_name_for_image" placeholder="عنوان للصورة التي ستظهر للطلاب كملف للصور..." value="<?php if (isset($name_for_image)) {
                                                                                                                                              echo $name_for_image;
                                                                                                                                            } ?>">
              <i class="fa fa-photo-video fa-fw icons"></i>
            </div>
            <hr>
            <div class="add-groub">
              <lable class="txt">وصف دقيق للصورة</lable>
              <input type="text" class="input" name="add_dis_for_image" placeholder="ضع وصفا يفهم منه الطلاب الاشياء المهمه" value="<?php if (isset($disc_for_image)) {
                                                                                                                                      echo $disc_for_image;
                                                                                                                                    } ?>">
              <i class="fa fa-cogs fa-fw icons"></i>
            </div>
            <hr>
            <div class="add-groub">
              <div class="txt">ختر الصف</div>
              <div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_image" value="1se" id="1"><label for="1" class="txt">الصف الاول الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_image" value="2se" id="2"><label for="2" class="txt">الصف الثاني الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_image" value="3se" id="3"><label for="3" class="txt">الصف الثالث الثانوي</label>
                </div>
              </div>
            </div>
            <hr>
            <div class="add-groub">
              <div class="txt">اختر الصورة</div>
              <input type="file" name="image_file[]" multiple>
            </div>
            <hr>
            <button type="submit" name="photo_up" class="btn btn-info btn-md add-btn"><i class="fa fa-upload"></i> رفع الصورة</button>
          </form>
          <form method="post" class="add-form activ-form">
            <table border="1">
              <tbody>
                <tr>
                  <th>الصورة</th>
                  <th>عنوان الصورة</th>
                  <th>وصف الصورة</th>
                  <th>الصف</th>
                  <th>حذف</th>
                  <th>الفاعلية <button type="submit" name="save_img_vilability" class="btn btn-success">حفظ <i class="fa fa-save"></i></button></th>
                </tr>
                <?php
                $select_img = $db->prepare("SELECT * from images ORDER BY se,name");
                $select_img->execute();
                if ($select_img->rowCount() > 0) {
                  $all_imgs = $select_img->fetchAll();
                  foreach ($all_imgs as $the_img) {
                ?>
                    <tr>
                      <td><a href="<?php echo $the_img['image']; ?>" target="_blank"><i class="fa fa-photo-video"></i></a></td>
                      <td><?php echo $the_img['name']; ?></td>
                      <td><?php echo $the_img['description']; ?></td>
                      <td><?php echo $the_img['se']; ?></td>
                      <td><a href="members.php?delet_img=<?php echo $the_img['image_id']; ?>" class="btn btn-danger">حذف</td>
                      <td>
                        <?php
                        if ($the_img['vialblity'] == 1) {
                          echo '<i class="fa fa-check-circle true-check"></i>';
                          echo '<a class="btn btn-info valid-btn" href="members.php?ch_img_valid=' . $the_img['image_id'] . '">إلغاء التفعيل</a>';
                        } else {
                          echo '<input type="checkbox" name="images[]" value="' . $the_img['image_id'] . '">';
                        }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </form>
        <?php

      } elseif ($_GET['to'] == 'add_pdf') {
        //open upload PDF for students          
        ?>
          <form method="post" class="back">
            <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
          </form>
          <form method="post" class="add-form" enctype="multipart/form-data">
            <h2 class="title">اضافة ملف PDF</h2>
            <!-- start PDF name -->
            <div class="add-groub">
              <lable class="txt">عنوان الملف</lable>
              <input type="text" class="input" name="add_name_for_pdf" placeholder="عنوان الملف الذي سيظهر للطلاب">
              <i class="fa fa-file-pdf fa-fw icons"></i>
            </div>
            <!-- end PDF name -->
            <hr>
            <!-- start se for pdf -->
            <div class="add-groub">
              <div class="txt">ختر الصف</div>
              <div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_pdf" value="1se" id="1"><label for="1" class="txt">الصف الاول الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_pdf" value="2se" id="2"><label for="2" class="txt">الصف الثاني الثانوي</label>
                </div>
                <div class="all-chek">
                  <input type="radio" name="add_se_for_pdf" value="3se" id="3"><label for="3" class="txt">الصف الثالث الثانوي</label>
                </div>
              </div>
            </div>
            <!-- end se for pdf -->
            <hr>
            <!-- start file btn -->
            <div class="add-groub">
              <div class="txt">اختر PDF</div>
              <input type="file" name="PDF_file">
            </div>
            <!-- end file btn -->
            <hr>
            <!-- start add btn -->
            <button type="submit" name="uploading_pdf" class="btn btn-info btn-md add-btn"><i class="fa fa-upload"></i> رفع الملف</button>
            <!-- end add btn -->
          </form>
          <form method="post" class="add-form activ-form">
            <table border="1">
              <tbody>
                <tr>
                  <th>pdf</th>
                  <th>عنوان الملف</th>
                  <th>الصف</th>
                  <th>حذف</th>
                  <th>الفاعلية <button type="submit" name="save_pdf_vilability" class="btn btn-success">حفظ <i class="fa fa-save"></i></button></th>
                </tr>
                <?php
                $select_pdf = $db->prepare("SELECT * from pdf ORDER BY se,name");
                $select_pdf->execute();
                if ($select_pdf->rowCount() > 0) {
                  $all_pdfs = $select_pdf->fetchAll();
                  foreach ($all_pdfs as $the_pdf) {
                ?>
                    <tr>
                      <td><a href="<?php echo $the_pdf['pdf']; ?>" target="_blank"><i class="fa fa-file-pdf"></i></a></td>
                      <td><?php echo $the_pdf['name']; ?></td>
                      <td><?php echo $the_pdf['se']; ?></td>
                      <td><a href="members.php?delet_pdf=<?php echo $the_pdf['pdf_id']; ?>" class="btn btn-danger">حذف</td>
                      <td>
                        <?php
                        if ($the_pdf['vilablity'] == 1) {
                          echo '<i class="fa fa-check-circle true-check"></i>';
                          echo '<a class="btn btn-info valid-btn" href="members.php?ch_pdf_valid=' . $the_pdf['pdf_id'] . '">إلغاء التفعيل</a>';
                        } else {
                          echo '<input type="checkbox" name="pdf[]" value="' . $the_pdf['pdf_id'] . '">';
                        }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </form>
    <?php
      } else {
        header('location: ?');
      }
    }
    include_once $footer;
  } else {
    session_unset();
    session_destroy();
    header("location: code-log.php");
    exit();
  }

  ob_end_flush();

    ?>