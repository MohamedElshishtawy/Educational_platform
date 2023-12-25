<!-- *** MEDO ELMASRI *** -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <?php
  if($title=='المفيد فى الفزياء'){
  ?>
  <link rel="icon" href="<?php echo $imges.'lamb.png';?>">
  <link rel="stylesheet" href="<?php echo $bootstrab_css;?>">
  <link rel="stylesheet" href="<?php echo $fontawesome_css;?>">
  <link rel="stylesheet" href="<?php echo $css.'framework.css';?>">
  <link rel="stylesheet" href="<?php echo $css . 'log-page.css' ?>">
  <?php
  }
  elseif($title=="Sign In | المفيد فى الفزياء"){
    ?>
    <link rel="icon" href="<?php echo $imges.'lamb.png';?>">
    <link rel="stylesheet" href="<?php echo $bootstrab_css;?>">
    <link rel="stylesheet" href="<?php echo $fontawesome_css;?>">
    <link rel="stylesheet" href="<?php echo $css.'framework.css';?>">
    <link rel="stylesheet" href="<?php echo $css . 'sign-in-page.css' ?>">
    <?php
  }
  elseif($title=='الإدارة'){
  ?>
  <link rel="icon" href="<?php echo $imges.'lamb.png';?>">
  <link rel="stylesheet" href="<?php echo $bootstrab_css;?>">
  <link rel="stylesheet" href="<?php echo $fontawesome_css;?>">
  <link rel="stylesheet" href="<?php echo $css.'framework.css';?>">
  <link rel="stylesheet" href="<?php echo $css.'mr1.css';?>">
  <link rel="stylesheet" href="<?php echo $css.'add_exam.css';?>">
  <?php
  }
  elseif($title=='الصف الأول الثانوي'||$title=='الصف الثاني الثانوي'||$title=='الصف الثالث الثانوي'){
  ?>
  <link rel="icon" href="<?php echo $imges.'lamb.png';?>">
  <link rel="stylesheet" href="<?php echo $bootstrab_css;?>">
  <link rel="stylesheet" href="<?php echo $fontawesome_css;?>">
  <link rel="stylesheet" href="<?php echo $css.'framework.css';?>">
  <link rel="stylesheet" href="<?php echo $css.'student.css';?>">
  <?php
  }
  elseif($title=='امتحان'){
  ?>
  <link rel="icon" href="<?php echo '../../'.$imges.'lamb.png';?>">
  <link rel="stylesheet" href="<?php echo '../../'.$bootstrab_css;?>">
  <link rel="stylesheet" href="<?php echo '../../'.$fontawesome_css;?>">
  <link rel="stylesheet" href="<?php echo '../../'.$css.'framework.css';?>">
  <link rel="stylesheet" href="<?php echo '../../'.$css.'exam.css';?>">
  <?php
  }
  ?>
</head>
  <body dir="rtl">