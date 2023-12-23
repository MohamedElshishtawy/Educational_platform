<?php 

$db_info = 'mysql:host=localhost;dbname=isef';//id15885295_maky id15885295_maky
$u_name = 'root'; // root id15885295_medoelmasri 
$u_pass = ''; // root )FxN-2i3eb8(rVXp
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAME utf8');
try{
    $db = new PDO($db_info,$u_name,$u_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo'<div style="color:red;background:black;padding:5px;position:fixed;z-index:9999">';
    echo'ERROR IN DB => ' . $e->getMessage();
    echo'</div>';
}
?>