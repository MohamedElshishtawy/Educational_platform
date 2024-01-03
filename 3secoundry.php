<?php

/** MSH */
ob_start();

session_start();
include_once 'init.php';

include_once $connect;

include_once $functions;

include_once $db_prog;

echo $_SESSION['message'] ?? '';
$_SESSION['message'] = '';
/*
-------------------

*** Page for 3se v1.0
** can't open it with out $_SESSION

-------------------
*/
//if student has session and page has id in url and he is in 1se
if (isset($_SESSION['se']) && $_SESSION['se'] == '3se' && isset($_GET['id']) && $_GET['id'] == $_SESSION['id']) {

  //if student id in our db
  $here = select1('id', 'students', 'id', $_SESSION['id']);

  if ($here == 0) {
    session_unset();
    session_destroy();
    header("location: code-log.php");
    exit();
  }
  //if his id is in our db
  else {
    /* start the page */
    $title = 'الصف الثالث الثانوي';
    include_once $header;

?>

    <nav class="nav">
      <span class="student-name"><?php echo $_SESSION['phone'] ?></span>
      <span class="page-se"><?php echo $_SESSION['name']; ?></span>
    </nav>

    <div class="br"><br></div>
    <div class="br"><br></div>
    <div class="br"><br></div>

    <div class="text-center addr">
    <h2>المفيد فى الفيزياء</h2>
    </div>

    <img src="<?php echo $imges . 'test.svg' ?>" class="paper-img">

    <?php
    //if he isn't finish his money
    $monies = select2('money', 'students', 'id', $_SESSION['id'], '', '');
    if ($monies['0']['money'] == 0) {
      echo '<div class="alert alert-danger">' . 'انت لم تدفع الأشتراك بعد ' . '</div>';
      include_once $footer;
      exit();
    } elseif ($monies['0']['money'] == 1) {

      //open student page 
      if (!isset($_GET['to'])) { ?>

        <div class="group">

          <a class="to to-1" href="?id=<?php echo $_SESSION['id'] ?>&to=exams">
            <figure>
              <img src="<?php echo $imges . 'inesh.png' ?>" alt="you can't see this photo" class="se-img">
              <figcaption>
                <i class="fa fa-clipboard-list"></i> دخول امتحان
              </figcaption>
            </figure>
          </a>

          <a class="to to-2" href="?id=<?php echo $_SESSION['id'] ?>&to=video">
            <figure>
              <img src="<?php echo $imges . 'watchv.png' ?>" alt="you can't see this photo" class="se-img">
              <figcaption>
                <i class="fa fa-video"></i> مشاهدة الحصص
              </figcaption>
            </figure>
          </a>



          <a class="to to-4" href="?id=<?php echo $_SESSION['id'] ?>&to=pdf">
            <figure>
              <img src="<?php echo $imges . 'pdf.png' ?>" alt="study with pdf" class="se-img">
              <figcaption>
                <i class="fa fa-file-pdf"></i> المذكرات والمراجعات PDF
              </figcaption>
            </figure>
          </a>

          <a class="to to-5" href="?id=<?php echo $_SESSION['id'] ?>&to=images">
            <figure>
              <img src="<?php echo $imges . 'bo.jpg' ?>" alt="you can't see this photo" class="se-img">
              <figcaption>
                <i class="fa fa-camera-retro"></i> صور صبوة الحصص
              </figcaption>
            </figure>
          </a>

        </div>

        <?php include_once $body . 'black_small_footer.php'; ?>

        <?php
      } else {

        if ($_GET['to'] == 'video') {

          $no_vid_err = '<div class="alert alert-info">لا توجد فيديوهات حتي الان</div>';
          $videos_selected = select2('*', 'videos', 'se', '3se', ' && activity = 1', $no_vid_err);

          if ($videos_selected != $no_vid_err) {
            foreach ($videos_selected as $video_selected) {
              $fileTypePrepare_for_st = array_reverse(explode('.', $video_selected['video']));
              $fileType_for_st = $fileTypePrepare_for_st[0];
              if ($fileType_for_st == 'mp3') {
        ?>
                <div class="audio-div">
                  <audio controls class="audio o-r">
                    <source src="<?php echo $video_selected['video']; ?>">
                  </audio>
                  <hr>
                  <h3 class="audio header"><?php echo $video_selected['name']; ?></h3>
                  <hr>
                  <p class="audio discription"><?php echo $video_selected['description']; ?></p>
                </div>
              <?php
              } elseif ($fileType_for_st == 'mp4') {
              ?>
                <div class="video-div">
                  <video controls class="video v-r">
                    <source src="<?php echo $video_selected['video']; ?>">
                  </video>
                  <hr>
                  <h3 class="video header"><?php echo $video_selected['name']; ?></h3>
                  <hr>
                  <p class="video discription"><?php echo $video_selected['description']; ?></p>
                </div>
              <?php
              }
            }
          } else {
            echo $videos_selected;
          }
        } elseif ($_GET['to'] == 'images') {
          // the Gallary for images
          if (isset($_GET['img_dir'])) {
            $images_name = filter_var($_GET['img_dir'], FILTER_SANITIZE_STRING);
            $images_name = filt($images_name);
            $all_images = select_info('*', 'images', 'se', '3se', ' && vialblity = 1 && name = "' . $images_name . '"');
            if ($all_images != false) {
              echo '<h2 class="page-title">' . $images_name . '</h2>';
              foreach ($all_images as $image_selected) {
              ?>
                <div class="image-div">
                  <img src="<?php echo $image_selected['image'] ?>">
                  <hr>
                  <h3 class="image header"><?php echo $image_selected['name']; ?></h3>
                  <hr>
                  <p class="image discription"><?php echo $image_selected['description']; ?></p>
                </div>
              <?php
              }
            } else {
              echo '<div class="alert alert-danger">لا يوجد صورة بذلك الأسم للأسف</div>';
              header('Refresh:2 ; url=?');
              exit();
            }
            // Gallary for images names
          } else {
            echo '<h1 class="page-title">' . 'صور الحصص' . '</h1>';

            $images_selected = select_info('name', 'images', 'se', '3se', ' && vialblity = 1');

            // array for unique names and folders
            $unique_names = array();
            echo '<div class="img-btn-contaner">';
            foreach ($images_selected as $image) {
              if (!in_array($image['name'], $unique_names)) {
                $unique_names[] = $image['name'];
              ?>
                <a class="img-btn" href="<?php echo '?id=' . $_SESSION['id'] . '&to=images&img_dir=' . $image['name']; ?>">
                  <span>
                    <?php
                    echo $image['name'];
                    ?>
                  </span>
                </a>
          <?php
              }
            }
            echo '</div>';
          }
        } elseif ($_GET['to'] == 'exams') {

          ?>
          <table class="table  table-striped">
            <thead>
              <tr>
                <th colspan="4" class="text-center h4 cover">إختبارات متاحة</th>
              </tr>
              <tr>
                <th class="text-center">اسم الإختبار</th>
                <th class="text-center">دخول</th>
                <th class="text-center">متاح من</th>
                <th class="text-center">الى</th>
              </tr>
            </thead>
            <tbody>

          <?php
            $exam_db = $db->prepare("
              SELECT *
              FROM exams
              WHERE
                  vilablility = 1
                  AND se = '3se'
                  AND id NOT IN (SELECT exam_id FROM degrees WHERE student_id = ?)
                  AND (
                      (exams.start_date <= CURRENT_TIMESTAMP AND exams.end_date >= CURRENT_TIMESTAMP)
                      OR (exams.start_date  = '0000-00-00 00:00:00' OR exams.end_date = '0000-00-00 00:00:00')
                  )
            ");
            $exam_db->execute(array($_SESSION['id']));

            if ( $exam_db->rowCount() > 0 ) {

              $exam_db_data = $exam_db->fetchAll(PDO::FETCH_ASSOC);
              
              
              foreach ( $exam_db_data as $prepare_exam ) {
                ?>
                <tr>
                  <td class="text-center"><a class="" href="<?= "exams/exam.php?exam=". $prepare_exam['id']?>"><?=$prepare_exam['exam_name']?></a></td>
                  <td class="text-center"><a class="btn btn-success btn-sm" href="<?= "exams/exam.php?exam=" . $prepare_exam['id']?>">دخول</a></td>
                  <td class="text-center"><?= $prepare_exam['start_date'] ?></td>
                  <td class="text-center"><?= $prepare_exam['end_date'] ?></td>
                </tr>
                <?php
              }
              $exam_db->closeCursor();
         
              }
            
             else {
            echo '<tr><td colspan="4" class="text-center">' . 'لا يوجد امتحانات لك الان' . '</td></tr>';
          }
          ?>

            </tbody>
          </table> 
          <table class="table table-striped">
            <thead>
              <tr>
                <th colspan="4" class="text-center cover h4">امتحانات مجتازة</th>
              </tr>
              <tr>
                <th>الاسم</th>
                <th>الدرجة</th>
                <th>مراجعة</th>
                <th>التاريخ</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $passed_exams = $db->prepare("SELECT degrees.*, exams.exam_name, exams.see_degree
              FROM degrees JOIN exams ON degrees.exam_id = exams.id WHERE student_id = ?");
              $passed_exams->execute(array($_SESSION['id']));
              
              if( $passed_exams->rowCount() > 0  ){
                  

                $passed_exams = $passed_exams->fetchAll(PDO::FETCH_ASSOC);
                foreach($passed_exams as $pass_exam){
                  ?>
                  <tr>
                    <td><?=$pass_exam['exam_name']?></td>
                    <td><?=$pass_exam['see_degree']==1?$pass_exam['degree']:'غير متاح' ?></td>
                    <td>
                      <?php if($pass_exam['see_degree']==0):?>
                        <a href="#" class="btn btn-success btn-sm disabled">مراجعة</a></td>
                      <?php else:?>
                        <!-- <div class="text-success">المراجعة ستتاح قريبا</div> -->
                        <a href="exams/show_answers.php?student=<?=$_SESSION['id']?>&exam_id=<?=$pass_exam['id']?>" class="btn btn-success btn-sm">مراجعة</a>

                        <?php endif;?>
                    <td><?=$pass_exam['end_at']?></td>
                  </tr>
                  <?php
                }
              }else{
                ?>
                <tr><td colspan=4 class=text-center>لا يوجد امتحانات سابقة</td></tr>
                <?php
              }
              ?>
            </tbody>
          </table>
          <?php
        } elseif ($to == 'pdf') {
          if (isset($_GET['pdf'])) {
            $pdf_id = filter_var($_GET['pdf'], FILTER_SANITIZE_NUMBER_INT);
            $get_pdf = select2('*', 'pdf', 'pdf_id', $pdf_id, ' && se = "3se"');
            if ($get_pdf != false) {
              foreach ($get_pdf as $the_pdf) {
                $pdf_link = $the_pdf['pdf'];
              }
              echo '<iframe src="' . $pdf_link . '" width="100%" height="100%"></iframe>';
            } else {
              echo '<div class="alert alert-info text-center">' . 'لا يوجد مذكرات لك الان' . '</div>';
              header('Refresh:2; url=?');
              exit();
            }
          } else {
            echo '<h1 class="page-title text-center">المذكرات و المراجعات PDF</h1>';
            $select_pdf = select2('pdf_id,pdf,name', 'pdf', 'se', '3se', ' && vilablity = 1');
            if ($select_pdf != false) {
              // if condition for style only
              $push_pdf = 1;
              $col_pdf = 5;
              if (count($select_pdf) == 1) {
                $col_pdf = 6;
                $push_pdf = 3;
              }
              foreach ($select_pdf as $pdf) {
          ?>
                <a class="ex-btn col-lg-<?php echo $col_pdf ?>
                            col-lg-push-<?php echo $push_pdf ?>
                            col-md-<?php echo $col_pdf ?>
                            col-md-push-<?php echo $push_pdf ?> 
                            col-sm-<?php echo $col_pdf ?> 
                            col-sm-push-1 col-xs-10 col-xs-push-1" href="<?php echo '?id=' . $_SESSION['id'] . '&to=pdf&pdf=' . $pdf['pdf_id']; ?>">
                  <span>
                    <?php
                    echo $pdf['name'];
                    ?>
                  </span>
                </a>
<?php
              }
            } else {
              echo '<div class="alert alert-info text-center">' . 'لا يوجد مذكرات لك الان' . '</div>';
            }
          }
        } else {
          header('location: ?');
        }
      }
    } else {
      header("location: code-log.php");
    }


    include_once $footer;
    /* end the page */
  }
} else {
  header("location: code-log.php");
  exit();
}

ob_end_flush();
?>