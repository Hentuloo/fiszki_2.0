<?php
session_start();
$words_type = json_decode($_POST['words_type']);
require_once('../base.php');


$query="SELECT words.word, words.description FROM words,users_sections,sections_names WHERE users_sections.id_user=:user_id and users_sections.id_section_name = sections_names.id_section and sections_names.section_name=:words_type and words.section_name=sections_names.id_section";//i get words user;
$query2=" OR sections_names.general=1 and sections_names.section_name=:words_type2 and words.section_name=sections_names.id_section";
$result = $db->prepare($query.$query2);
$result->bindValue(':user_id',$_SESSION['active_user'],PDO::PARAM_INT);
$result->bindValue(':words_type',$words_type->val,PDO::PARAM_STR);
$result->bindValue(':words_type2',$words_type->val,PDO::PARAM_STR);
    $result->execute();

  $array_result=[];
    while($row=$result->fetch()){
    array_push($array_result,['word'=>$row['word'],'description'=>$row['description']]);
    }

$myJSON = json_encode($array_result);

echo $myJSON;