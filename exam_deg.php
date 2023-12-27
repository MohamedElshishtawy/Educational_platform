<?php


ob_start();

session_start();
//if he has sessions
if ( !isset($_GET['exam']) ){
    header('location: code-log.php');
    exit();
}
if (isset($_SESSION['se']) && $_SESSION['se'] == 'AD' && $_SESSION['id'] == '18542') {

  include_once 'init.php';

  include_once $connect;

  include_once $functions;

  include_once $db_prog;

  $title = 'الإدارة';

  include_once $header;
?>

  <form method="post" class="back" enctype="multipart/form-data">
  <button type="submit" name="back_ad" class="btn btn-success"><i class="fa fa-chevron-left"></i></button>
</form>

  <h2 class="title text-center">الدرجات</h2>
    <table class="table ">
        <thead>
            <tr>
                <th class="text-center">الإسم</th>
                <th class="text-center">الدرجة</th>
                <th class="text-center">التاريخ</th>
                <th class="text-center">الإمتحان</th>
            </tr>
        </thead>
        <tbody>

        
  <?php
  
    if ( isset($_GET['exam']) ){
        $exam = $db->prepare("
        SELECT
        students.ar_name AS student_name,
        exams.exam_name AS exam_name,
        degrees.degree ,
        degrees.end_at 
    FROM
        degrees
    JOIN
        students ON degrees.student_id = students.id
    JOIN
        exams ON degrees.exam_id = exams.id
    WHERE 
        exam_id = ?    
    ");

        $exam->execute(array($_GET['exam']));
        if( $exam->rowCount() > 0 )
            $exam = $exam->fetchAll(PDO::FETCH_ASSOC);
            foreach($exam as $ex){
                ?>
                <tr>
                <td class="text-center"><?= $ex['student_name']?></td>
                <td class="text-center"><?= $ex['degree']?></td>
                <td class="text-center"><?= $ex['end_at']?></td>
                <td class="text-center"><?= $ex['exam_name']?></td>
                </tr>
                <?php
            }
        }
    }
  
  ?>
  </tbody>
    </table>

<?php
  include_once $footer;