<?php 

$db_info = 'mysql:host=localhost;dbname=id20345313_mohamed_fajr';//id15885295_maky id15885295_maky
$u_name = 'id20345313_fajr_user'; // root id15885295_medoelmasri 
$u_pass = 'medoex010$M'; // root )FxN-2i3eb8(rVXp
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