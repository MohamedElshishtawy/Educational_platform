<?php
namespace backend\models;

include_once 'connect.php';


class Code{
    
    public $id, $code, $se;
    private $password;

    static public function generate($_code, $_se){
        $code = $_code;
        $password = random_int(100, 2000);
        $se   = $_se;
        $code_db = $db->prepare("INSERT INTO codes (code, password, se) VALUES (?, ? ,?)");
        $code_db->execute(array($code, $password, $se));
    }
}