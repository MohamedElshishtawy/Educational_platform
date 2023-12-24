<?php 


include_once 'connect.php';

/* my functions */

/*
-- Select Function v2.0 { in v2.0 -> added $eals }
-- This function acsept parameters :
---- $selection => what you want to select
---- $from => the table in database
---- $where => the field you want to select
---- $val => the value include the field
---- $eals => i can add any thing in this
-- [select] Function reterns $rows_f
-- $rows_n -> number of rows for the selection
*/
function select1($selection,$from,$where,$val,$eals="") {
    global $db;
    
    $select = $db->prepare("SELECT $selection FROM $from WHERE $where = ? $eals ");
    $select->execute(array($val));
    
    $rows_n = $select->rowCount();

    return $rows_n;
    
}

//----------------------------------------------

/*
-- Select Function v2.0 [ v2.0 -> error parameter ]
-- This function acsept parameters :
---- $selection => what you want to select
---- $from => the table in database
---- $where => the field you want to select
---- $val => the value include the field
---- $eals => i can add any thing in this
---- $error => to put error function
-- [select] Function reterns $rows_f
-- $rows_f -> rows data for the selection
*/
function select2($selection,$from,$where,$val,$eals='',$error=false) {
    global $db;
    
    $select2 = $db->prepare("SELECT $selection FROM $from WHERE $where = ? $eals ");
    $select2->execute(array($val));
    $select2->rowCount();
    if ( $select2->rowCount() > 0 ){
    $rows_f = $select2->fetchAll();
    return $rows_f;
    }
    elseif( $select2->rowCount() == 0 ){
        return $error;
    }
}

//----------------------------------------------

/*
-- Select Function v1.0
-- This function accept parameters :
---- $selections => what you want to select from DB
---- $table => the table in database
---- $condition_field => the field you want to point
---- $condition => the value include the field
---- $else => I can add any thing in this
---- $error => to put error function
-- [select] Function reterns $rows
-- $rows -> rows data for the selection
*/
function select_info_no_where($selections,$table,$error_ms=false) {
  global $db;
  
  $select_procc = $db->prepare("SELECT $selections FROM $table  ");
  $select_procc->execute();
  if ( $select_procc->rowCount() > 0 ){
  $rows = $select_procc->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
  }
  
  return $error_ms;
  
}
function select_info($selections,$table,$condition_field,$condition,$else='',$error_ms=false) {
  global $db;
  
  $select_procc = $db->prepare("SELECT $selections FROM $table WHERE $condition_field = ? $else ");
  $select_procc->execute(array($condition));
  if ( $select_procc->rowCount() > 0 ){
  $rows = $select_procc->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
  }
  
  return $error_ms;
  
}

//----------------------------------------------

/*
--- Function to filter text from [ / \ - * ; ( ) ] v1.0
-- Function acsept parametrs
- $text => the text you want to sanitize
-- Function return the var with out [ / \ - * ; ( ) [ ] ]
- return => $txt
*/

function filt($text) {
    
    $txt = str_replace('/','',$text);
    $txt1 = str_replace('%','',$txt);
    $txt2 = str_replace('-','',$txt1);
    $txt3 = str_replace('*','',$txt2);
    $txt4 = str_replace(';','',$txt3);
    $txt5 = str_replace('(','',$txt4);
    $txt6 = str_replace(')','',$txt5);
    $txt7 = str_replace('[','',$txt6);
    $txt8 = str_replace(']','',$txt7);
    $txt9 = str_replace('{','',$txt8);
    $txt10 = str_replace('}','',$txt9);
    $txt11 = str_replace('<','',$txt10);
    $txt12 = str_replace('>','',$txt11);
    $txt13 = str_replace('?','',$txt12);
    $txt14 = str_replace('؟','',$txt13);
    $txt15 = str_replace('\\','',$txt14);
    $txt16 = str_replace('|','',$txt15);
    $txt17 = str_replace('$','',$txt16);
    $txt18 = str_replace('&','',$txt17);
    $txt19 = str_replace('#','',$txt18);
    $txt20 = str_replace('^','',$txt19);
    $txt21 = str_replace('_','',$txt20);
    $txt22 = str_replace(',','',$txt21);
    
    return $txt22;
}

//----------------------------------------------

/*
*** UPDATE fnction v1.0
** acsept parameters:
* $table        => the table you chose
* $old_new_vals => the old data and new data -> [ money = '15' , id = '700' ]
* $field        => where the tr you want
* $field_val    => field value
** NO RETURNS
*/

function update($table,$feled_equal_new_val,$field,$field_val) {
    global $db;
    
    $update = $db->prepare("UPDATE $table SET $feled_equal_new_val WHERE $field = '$field_val' ");
    
    $update->execute();
}

//----------------------------------------------

/*
*** CHEKING if student is here function v1.0
** This function acsept parameters :
* $selection => what you want to select
* $from      => the table in database
* $where     => the field you want to select
* $val       => the value include the field
* $eals      => i can add any thing in this
* $error     => to put error function
** Function reterns $rows_count
*/
function is_here($select,$from,$where,$val) {
    global $db;

    $select = $db->prepare("SELECT $select FROM $from WHERE $where ");
    
    $select->execute(array($val));
    
    $rows_count = $select->rowCount();
    
    return $rows_count;
}

//----------------------------------------------
/**
 * function syple2html v1.0
 * accept parameter
 * [$word] => the text you want
 * returns the word you wabt by changing syplosto html tags
 */
function sympole2html($word) {
  $word1 = str_replace('^^','<sup>',$word);
  $word2 = str_replace('**','</sup>',$word1);
  $word3 = str_replace('--','<sub>',$word2);
  $word4 = str_replace('__','</sub>',$word3);
  return $word4;
}

/** if_here_return() v1.0
 *  If Isset($Var) : Return It
 * Accept parameters => $variable you want to check
 */
function if_here_echo($var) {
  if ( isset($var) ) {
    return $var;
  } else{
    return '';
  }
}
?>