<?php
use \Jacwright\RestServer\RestException;

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
        array('address' => array('name'=> 'Jordan','email'=> 'jjordan@bayareaseoservices.net')),
      array('address' => array('name'=> 'Jordan','email'=> 'ray@raydesign.com')),
  );

  //  $from = 'App user <'.$obj->email.'>';
    $from = 'Heartboxx App user <from@heartboxx.com>';

    $subject = ($subject)?$subject:"no subject";
    $body = $message;

    send_mail($from, $recps, $subject, $body);





      //this table will be revampled completely if approving suggestoins comes

      $sql = 'INSERT INTO `suggestions` (`uid`, `no_of_sug`) VALUES ( "'.$uid.'",  1)
        ON DUPLICATE KEY UPDATE `no_of_sug` = `no_of_sug` + 1';
        mysqli_query($this->link,$sql);


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
     * @url GET /getsugcnt/$uid
     */
    public function getsugcnt($uid=null)
    {
      //messages/getsugcnt/$uid
      //params uid

      $sql = 'select `no_of_sug` from suggestions where `uid` = "'.$uid.'"';

     if ($result=mysqli_query($this->link,$sql))
       {
          $obj=mysqli_fetch_object($result);
           return array('data' => $obj->no_of_sug);
     } else {
       throw new RestException(401, "Error fetching data!");
     }
    }



        /**
         *
         * @url GET /fetch/$uid
         */
        public function fetch($uid=null)
        {
          //params uid, to, subject , message

          $sql = 'select * from messages where `from_uid` = "'.$uid.'" ORDER BY created_at DESC LIMIT 30';

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
