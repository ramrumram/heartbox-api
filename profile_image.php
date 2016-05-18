<?php

      include_once("api/MysqlClass.php");
      // params############## uid, F_ILES['file']

    //  $mysql = new DB();
//      $ser = addslashes(serialize($_FILES));

/*
      $sql = 'INSERT INTO log (description) VALUES ("'.$ser.'");';
      if(mysqli_query($mysql->link,$sql)) {
      //  json_encode([
    //"Message" => "lllalading your file."]);
      }else {
      //  echo $sql;
        //  return json_encode([
  //  "Message" => ".... your file."]);
       // throw new RestException(401, "Error saving data");
      }


*/
      $target_dir = "uploads/profiles";
      extract($_POST);

      $target_dir = $target_dir . "/" . $uid. ".jpg";
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir))
      {
      echo json_encode([
      "Status" => "OK",
      ]);

      } else {

      echo json_encode([
      "Status" => "Error",
      ]);

      }

/*

      $sql = 'INSERT INTO log (description) VALUES ("'.$ser.'");';
      if(mysqli_query($mysql->link,$sql)) {
        return json_encode([
"Message" => "lllalading your file."]);
      }else {
      //  echo $sql;
          return json_encode([
"Message" => ".... your file."]);
       // throw new RestException(401, "Error saving data");
      }
