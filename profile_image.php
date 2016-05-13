<?php

      include_once("api/MysqlClass.php");

      $mysql = new DB();
      print_r($_FILES);
      $ser = addslashes(serialize($_FILES));


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



      $target_dir = "uploads/profiles";


      $target_dir = $target_dir . "/" . ($_FILES["file"]["name"]);
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
