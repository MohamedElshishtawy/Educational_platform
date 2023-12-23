<?php
  if($title=='التعليم في أي ظروف'){
  ?>
  <script src="<?php echo $jquery;?>"></script>
  <script src="<?php echo $bootstrap_js;?>"></script>
  <script src="<?php echo $fontawesome_js;?>"></script>
  <script src="<?php echo $js.'all.js';?>"></script>
  <?php
  }
  elseif($title=="Sign In | التعليم في أي ظروف"){
  ?>
  <script src="<?php echo $jquery;?>"></script>
  <script src="<?php echo $bootstrap_js;?>"></script>
  <script src="<?php echo $fontawesome_js;?>"></script>
  <script src="<?php echo $js.'sign.js';?>"></script>
  <?php
  }
  elseif($title=='الإدارة'){
  ?>
  <script src="<?php echo $jquery;?>"></script>
  <script src="<?php echo $bootstrap_js;?>"></script>
  <script src="<?php echo $fontawesome_js;?>"></script>
  <script src="<?php echo $js.'all.js';?>"></script> 
  <script src="<?php echo $js.'add_ex.js';?>"></script>
  <?php
  }
  elseif($title=="امتحان"){
    ?>
    <script src="<?php echo '../../'.$jquery;?>"></script>
    <script src="<?php echo '../../'.$bootstrap_js;?>"></script>
    <script src="<?php echo '../../'.$fontawesome_js;?>"></script>
    <script src="<?php echo '../../'.$js.'all.js';?>"></script>
    <?php
    }
  ?>
</body>
</html>