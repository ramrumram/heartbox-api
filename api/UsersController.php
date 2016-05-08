<?php

use \Jacwright\RestServer\RestException;

include_once("MysqlClass.php");
include_once("PestJSON.php");
include_once("functions.php");

class UsersController extends DB
{


  /**
   *
   * @url POST /profileimg
   */
  public function profileimg()
  {
    //params uid, $_FILE
    $s = serialize($_FILES);

     extract ($_POST);




        $sql = 'INSERT INTO `log` (`description`) VALUES ("'.$s.'");';
      //  mysqli_query($this->link,$sql);

        if(mysqli_query($this->link,$sql)) {


          return array("success" => "message sent");
        }else {
          echo $sql;
          throw new RestException(401, "Error saving data");
        }

      //  break;


  }






}
