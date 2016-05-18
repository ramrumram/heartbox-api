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


  /**
   *
   * @url GET /getbackgroundlocationstatus
   */
 function getBackgroundLocationStatus() {
   // /users/getBackgroundLocationStatus
   //params uid
    extract ($_GET);

    $sql = 'select background_status from users where `id` = "'.$uid.'"';

    if ($result=mysqli_query($this->link,$sql))
      {
        $obj=mysqli_fetch_object($result);

     }
     return $obj;

 }


 /**
  *
  * @url POST /savebackgroundlocationstatus
  */
 public function savebackgroundlocationstatus()
 {
   //params uid, status

    extract ($_POST);




       $sql = 'UPDATE `users` SET background_status = "'.$status.'" where id = "'.$uid.'";';
       mysqli_query($this->link,$sql);

       if(mysqli_query($this->link,$sql)) {


         return array("success" => "saved");
       }else {
         echo $sql;
         throw new RestException(401, "Error saving data");
       }

     //  break;


 }


}
