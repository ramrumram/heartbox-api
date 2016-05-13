<?php
include_once("MysqlClass.php");
include_once("PestJSON.php");
include_once("functions.php");
include_once("../mailer.php");
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

     $sql = 'select * from users where `id` = "'.$uid.'"';

     if ($result=mysqli_query($this->link,$sql))
       {
         $obj=mysqli_fetch_object($result);

     }


    $recps = array(
      array('address' => array('name'=> 'dfdf','email'=> 'rameshkumar86@gmail.com')),
      array('address' => array('name'=> 'jakko','email'=> 'ramrumram@gmail.com'))
  );

  //  $from = 'App user <'.$obj->email.'>';
    $from = 'App user <from@sparkpostbox.com>';

    $subject = ($subject)?$subject:"no subject";
    $body = $message;

    send_mail($from, $recps, $subject, $body);




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

      $sql = 'select * from messages where `from_uid` = "'.$uid.'" ORDER BY created_at DESC';

     if ($result=mysqli_query($this->link,$sql))
       {

         while ($obj=mysqli_fetch_object($result))
           {
               $date = date("d-m h:i A", strtotime($obj->created_at));
               $messages [] = array('to' => $obj->to, 'subject' => $obj->subject, 'message' => $obj->message,
                                'date' => $date, 'id' => $obj->id);
           }

           return array('data' => $messages);
     } else {
       throw new RestException(401, "Error fetching data!");
     }
    }


}
