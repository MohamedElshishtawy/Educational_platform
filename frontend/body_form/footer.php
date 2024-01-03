<?php
  if($title=='المفيد فى الفزياء'){
  ?>
  <script src="<?php echo $jquery;?>"></script>
  <script src="<?php echo $bootstrap_js;?>"></script>
  <script src="<?php echo $fontawesome_js;?>"></script>
  <script src="<?php echo $js.'all_js.js';?>"></script>
  <script src="<?php echo $js.'loader.js';?>"></script>
  <?php
  }
  elseif($title=="Sign In | المفيد فى الفزياء"){
  ?>
  <script src="<?php echo $jquery;?>"></script>
  <script src="<?php echo $bootstrap_js;?>"></script>
  <script src="<?php echo $fontawesome_js;?>"></script>
  <script src="<?php echo $js.'sign.js';?>"></script>
  <script src="<?php echo $js.'loader.js';?>"></script>
  <?php
  }
  elseif($title=='الإدارة'){
  ?>
  <script src="<?php echo $jquery;?>"></script>
  <script src="<?php echo $bootstrap_js;?>"></script>
  <script src="<?php echo $fontawesome_js;?>"></script>
  <script src="<?php echo $js.'all_js.js';?>"></script> 
  <script src="<?php echo $js.'add_ex.js';?>"></script>
  <?php
  }
  elseif($title=="امتحان"){
    ?>
    <script src="<?php echo '../'.$jquery;?>"></script>
    <script src="<?php echo '../'.$bootstrap_js;?>"></script>
    <script src="<?php echo '../'.$fontawesome_js;?>"></script>
    <script src="<?php echo '../'.$js.'all_js.js';?>"></script>
    <?php
    }
  ?>
  
</body>
</html>