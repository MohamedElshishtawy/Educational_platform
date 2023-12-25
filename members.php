<?php 

ob_start();

session_start();

//if he has sessions
if ( isset($_SESSION['phone']) && isset($_SESSION['id']) && $_SESSION['id'] == '18542' ){ 
    
    if ( $_SESSION['id'] == '18542' && $_SESSION['state'] == '11' ) {

        include_once 'init.php';

        include_once $connect ;

        include_once $db_prog;

        include_once $functions;

        $title = 'الإدارة';
        include_once $header;
        
        //edit pahe
        
        
        if( isset($_GET['edit']) ){
          $edit_student_id = filter_var($_GET['edit'], FILTER_SANITIZE_NUMBER_INT);
          $selected = select_info('*','students','id',$edit_student_id);
          if ($selected == false){
            echo '<br><br><div class="alert alert-success">هذا الطالب ليس موجودا في الموقع</div>';
            header('Refresh: 1; url=mr.php?to=students_s');
            exit();
          } else {
            foreach ( $selected as $editing_student ) {
              //start edit pahe
              ?>
              <form method="post" class="back">
                  <button type="submit" name="back_member" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
              </form>
              <form method="post" class="add-form">
                <h2 class="title">تعديل عضو</h2>
                <div class="add-groub">
                  <lable class="txt">الأسم كاملا</lable>
                  <input type="text" class="input" name="edit_ar_name" value="<?php echo $editing_student['ar_name'] ?>" placeholder="ضع الاسم العربي">
                  <i class="fa fa-user fa-fw icons"></i>
                </div>
                <hr>
                <div class="add-groub">
                  <lable class="txt">رقم الهاتف</lable>
                  <input type="text" class="input" name="edit_phone" value="<?php echo $editing_student['phone'] ?>" placeholder="رقم التلفون الخاص بالطالب">
                  <i class="fa fa-phone fa-fw icons"></i>
                </div>
                <hr>
                <div class="add-groub">
                  <lable class="txt">المجموعة</lable>
                  <input type="text" class="input" name="edit_groub" value="<?php echo $editing_student['groub'] ?>" placeholder="المجموعة">
                  <i class="fa fa-users fa-fw icons"></i>
                </div>
                <hr>
                <div class="add-groub">
                  <lable class="txt">الرمز السري الجديد</lable>
                  <input type="text" class="input" name="edit_password" placeholder="اتركه فارغا وسيبقي كما هو">
                  <i class="fa fa-lock fa-fw icons"></i>
                </div>
                <hr>
                <div class="add-groub">
                  <div class="txt">ختر الصف</div>
                  <div>
                    <div class="all-chek">
                      <input type="radio" name="edit_se" value="1se" id="1" <?php if($editing_student['se'] == '1se'){ echo 'checked'; } ?> ><label for="1" class="txt">الصف الاول الثانوي</label>
                    </div>
                    <div class="all-chek">
                      <input type="radio" name="edit_se" value="2se"  id="2" <?php if($editing_student['se'] == '2se'){ echo 'checked'; } ?>><label for="2" class="txt">الصف الثاني الثانوي</label>
                    </div>
                    <div class="all-chek">
                      <input type="radio" name="edit_se" value="3se" id="3" <?php if($editing_student['se'] == '3se'){ echo 'checked'; } ?>><label for="3" class="txt">الصف الثالث الثانوي</label>
                    </div>
                  </div>
                </div>
                <button type="submit" name="edit_student" class="btn btn-info btn-md add-btn"><i class="fa fa-edit"></i> تعديل</button>
              </form>
            <?php
          }
        }
        } elseif( isset($_GET['delete']) ) {

          $delete_student_id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);

          $is_student_here_delete = select_info('id','students','id',$delete_student_id);
          if ( $is_student_here_delete == false ){
            echo '<br><br><div class="alert alert-success">هذا الطالب ليس موجودا بالفعل</div>';
            header('Refresh:1; url=mr.php?to=students_s');
            exit();
          }
          else{
            echo '<script>'. 'window.alert("هل انت متأكد")' .'</script>';
            $delet_item = $db->prepare('DELETE FROM students WHERE id = ?');
            $delet_item->execute(array($delete_student_id));
            if( $delet_item ){
              echo '<br><br><div class="alert alert-success">تم حذف الطالب</div>';
              header('Refresh:1; url=mr.php?to=students_s');
              exit();
            }
            else{
              echo '<br><br><div class="alert alert-danger">حدثت مشكلة اثناء الحذف</div>';
              header('Refresh:1; url=mr.php?to=students_s');
              exit();
            }
          }
      } elseif ( isset($_GET['ch_stud_money']) ) {

        $student_money_id = filter_var($_GET['ch_stud_money'], FILTER_SANITIZE_NUMBER_INT);

        $select_students_db = select_info('money','students','id',$student_money_id);

        if ( $select_students_db != false ) {
          foreach ( $select_students_db as $select_student_db ) {
            if ( $select_student_db['money'] == 1 ) {
              update('students','money = 0','id',$student_money_id);
              echo '<br><br><div class="alert alert-success">تم تعديل دفع اشتراك هذا الطالب</div>';
              header('Refresh:1; url=mr.php?to=students_s');
              exit();
            } else {
              echo '<br><br><div class="alert alert-danger">هذا الطالب لم يدفع الأشتراك بعد</div>';
              header('Refresh:1; url=mr.php?to=students_s');
              exit();
            }
          }
        }

      } elseif ( isset($_GET['delet_vid']) ) {

        $vid_id = filter_var($_GET['delet_vid'], FILTER_SANITIZE_NUMBER_INT);

        $is_video_here = select_info('video_id,video','videos','video_id',$vid_id);
        if ( $is_video_here == false ) {
          echo '<br><br><div class="alert alert-success">هذا الفيديو ليس موجودا بالفعل</div>';
          header('Refresh:1; url=mr.php?to=add_video');
          exit();
        }
        else{
          foreach ($is_video_here as $vid) {
            $vid_lik = $vid['video'];
          }
          if ( file_exists($vid_lik) ) {
              echo '<script>window.alert("هل متأكد ان تحذف ذلك الفيديو")</script>';
              unlink($vid_lik);
              $delet_vid_db = $db->prepare('DELETE FROM videos WHERE video_id = ?');
              $delet_vid_db->execute(array($vid_id));
              if( $delet_vid_db ){
                echo '<br><br><div class="alert alert-success">تم حذف الفيديو</div>';
                header('Refresh:1; url=mr.php?to=add_video');
                exit();
              }
              else{
                echo '<br><br><div class="alert alert-danger">حدثت مشكلة اثناء الحذف</div>';
                header('Refresh:2; url=mr.php?to=students_s');
                exit();
              }
          } else {
            echo '<br><br><div class="alert alert-danger">هذا الفيديو ليس موجود ... اتصل بمبرج هذا الموقع للحذف</div>';
          }
        }
      } elseif ( isset($_GET['ch_valid']) ) {

        $vid_id = filter_var($_GET['ch_valid'], FILTER_SANITIZE_NUMBER_INT);

        $select_selc_vid = select_info('activity','videos','video_id',$vid_id);
        if ( $select_selc_vid != false ) {
          foreach ( $select_selc_vid as $validate_of_vid ) {
            if ( $validate_of_vid['activity'] == 1 ) {
              update('videos','activity = 0','video_id',$vid_id);
              echo '<br><br><div class="alert alert-success">تم إلغاء تفعيل الفيديو</div>';
              header('Refresh:2; url=mr.php?to=add_video');
              exit();
            } else {
              echo '<br><br><div class="alert alert-danger">هذا الفيديو غير مفعل بالفعل</div>';
              header('Refresh:2; url=mr.php?to=add_video');
              exit();
            }
          }
        }
      } elseif ( isset($_GET['del_exam']) ) {

        $exam_name = filter_var($_GET['del_exam'], FILTER_SANITIZE_STRING);

        $ex_file = $exam_name . '.php';
        $selects_ex = select2('exam_name,se','exams','exam_name',$exam_name);
        if ( $selects_ex != false ) {
          foreach ( $selects_ex as $select_ex ) {
            switch($select_ex['se']) {
              case '1se' : 
                $delet_ex_deg = $db->prepare("ALTER TABLE exams_for_1 DROP $exam_name ");
                $exam_file = $exams_for_1;
                $exam_ph = $ex_img_for_1;
              break;
              case '2se' : 
                $delet_ex_deg = $db->prepare("ALTER TABLE exams_for_2 DROP $exam_name ");
                $exam_file = $exams_for_2;
                $exam_ph = $ex_img_for_2;
              break;
              case '3se' : 
                $delet_ex_deg = $db->prepare("ALTER TABLE exams_for_3 DROP $exam_name ");
                $exam_file = $exams_for_3;
                $exam_ph = $ex_img_for_3;
              break;
            }
            $delet_ex_deg->execute();

            $dele_ex_info = $db->prepare("DELETE FROM exams WHERE exam_name = ?");
            $dele_ex_info->execute(array($exam_name));
            
            if ( file_exists($exam_file.$ex_file) ) {
              unlink($exam_file.$ex_file);
            }

            $all_files_in_ph = scandir($exam_ph);
            foreach( $all_files_in_ph as $img_in_ph ) {
              $img_array = explode('^',$img_in_ph);
              if ( in_array($exam_name,$img_array) ) {
                unlink($exam_ph.'/'.$img_in_ph);
              }
            }
          }
          echo '<br><br><div class="alert alert-success">تم حذف الأمتحان</div>';
          header('Refresh:1; url=mr.php?to=add_exam');
          exit();
        } else {
          echo '<br><br><div class="alert alert-danger">هذا الأمتحان ليس موجود ... اتصل بمبرج هذا الموقع للحذف</div>';
        }
        
      } elseif ( isset($_GET['ch_exam_vilab']) ) {
        
        $exam_name = filter_var($_GET['ch_exam_vilab'], FILTER_SANITIZE_STRING);

        $select_selc_ex = select_info('vilablility','exams','exam_name',$exam_name);

        if ( $select_selc_ex != false ) {
          foreach ( $select_selc_ex as $select_ex ) {
            if ( $select_ex['vilablility'] == 1 ) {
              update('exams','vilablility = 0','exam_name',$exam_name);
              echo '<br><br><div class="alert alert-success">تم إلغاء تفعيل الإمتحان</div>';
              header('Refresh:2; url=mr.php?to=add_exam');
              exit();

            } else {
              echo '<br><br><div class="alert alert-danger">هذا الإمتحان غير مفعل بالفعل</div>';
              header('Refresh:2; url=mr.php?to=add_exam');
              exit();

            }
          }
        } else {
          echo '<br><br><div class="alert alert-danger">حدث خطأ هذا الإمتحان ليس موجوداَ</div>';
        }

      } elseif ( isset($_GET['delet_img']) ) {
        
        $image_id = filter_var($_GET['delet_img'], FILTER_SANITIZE_NUMBER_INT);

        $selects_img = select_info('image_id,image,se','images','image_id',$image_id);
        if ( $selects_img != false ) {
          foreach ( $selects_img as $select_img ) {
            if ( file_exists($select_img['image']) ) {
              unlink($select_img['image']);
            }
          }
          $dele_img_db = $db->prepare("DELETE FROM images WHERE image_id = ?");
          $dele_img_db->execute(array($image_id));
          echo '<br><br><div class="alert alert-success">تم حذف الصورة</div>';
          header('Refresh:1; url=mr.php?to=add_photo');
          exit();
        } else {
          echo '<br><br><div class="alert alert-danger">هذا الأمتحان ليس موجود ... اتصل بمبرج هذا الموقع للحذف</div>';
        }

      } elseif ( isset($_GET['ch_img_valid']) ) {
        $img_id = filter_var($_GET['ch_img_valid'], FILTER_SANITIZE_NUMBER_INT);

        $select_selc_img = select_info('vialblity','images','image_id',$img_id);

        if ( $select_selc_img != false ) {
          foreach ( $select_selc_img as $select_img ) {
            if ( $select_img['vialblity'] == 1 ) {
              update('images','vialblity = 0','image_id',$img_id);
              echo '<br><br><div class="alert alert-success">تم إلغاء تفعيل الصورة</div>';
              header('Refresh:1; url=mr.php?to=add_photo');
              exit();

            } else {
              echo '<br><br><div class="alert alert-danger">هذه الصورة غير مفعل بالفعل</div>';
              header('Refresh:2; url=mr.php?to=add_photo');
              exit();

            }
          }
        }

      } elseif ( isset($_GET['delet_pdf']) ) {
        
        $pdf_id = filter_var($_GET['delet_pdf'], FILTER_SANITIZE_NUMBER_INT);

        $selects_pdf = select_info('pdf_id,pdf,se','pdf','pdf_id',$pdf_id);
        if ( $selects_pdf != false ) {
          foreach ( $selects_pdf as $selects_pdf ) {
          
            if ( file_exists($selects_pdf['pdf']) ) {
              unlink($selects_pdf['pdf']);
            }
          }
          
          $dele_pdf_db = $db->prepare("DELETE FROM pdf WHERE pdf_id = ?");
          $dele_pdf_db->execute(array($pdf_id));

          echo '<br><br><div class="alert alert-success">تم حذف الملف</div>';
          header('Refresh:1; url=mr.php?to=add_pdf');
          exit();

        } else {
          echo '<br><br><div class="alert alert-danger">هذا الملف ليس موجود ... اتصل بمبرج هذا الموقع للحذف</div>';
        }
      } elseif ( isset($_GET['ch_pdf_valid']) ) {
        $pdf_id = filter_var($_GET['ch_pdf_valid'], FILTER_SANITIZE_NUMBER_INT);

        $select_selc_pdf = select_info('vilablity','pdf','pdf_id',$pdf_id);

        if ( $select_selc_pdf != false ) {
          foreach ( $select_selc_pdf as $select_pdf ) {
            if ( $select_pdf['vilablity'] == 1 ) {
              update('pdf','vilablity = 0','pdf_id',$pdf_id);
              echo '<br><br><div class="alert alert-success">تم إلغاء تفعيل الملف</div>';
              header('Refresh:1; url=mr.php?to=add_pdf');
              exit();
            } else {
              echo '<br><br><div class="alert alert-danger">هذا الملف غير مفعل بالفعل</div>';
              header('Refresh:2; url=mr.php?to=add_pdf');
              exit();

            }
          }
        }

      }
      include_once $footer;
    }
    else {
      session_unset();
      session_destroy();
      header("location: code-log.php");
      exit();
    }
  }
else{
    header("location: code-log.php");
    exit();
}
ob_end_flush();
?>