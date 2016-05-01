<?php

use \Jacwright\RestServer\RestException;

include_once("MysqlClass.php");
include_once("PestJSON.php");
include_once("functions.php");

class MessagesController extends DB
{


  /**
   *
   * @url POST /suggestion
   */
  public function suggestion()
  {
    //params uid, to, subject , message
     extract ($_POST);


        //just save it in log for ref
      //  $this->log("UID :".$uid. " LL : ".$ll);

        $sql = 'INSERT INTO `messages` (`to`, `subject`, `message`, `from_uid`) VALUES ("'.$to.'", "'.$subject.'", "'.$message.'", "'.$uid.'");';

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
     * @url GET /fetch/$uid
     */
    public function fetch($uid=null)
    {
      //params uid, to, subject , message

      $sql = 'select * from messages where `from_uid` = "'.$uid.'"';

     if ($result=mysqli_query($this->link,$sql))
       {

         while ($obj=mysqli_fetch_object($result))
           {
               $messages [] = $obj;
           }

           return array('data' => $messages);
     } else {
       throw new RestException(401, "Error fetching data!");
     }
    }


}
