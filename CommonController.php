<?php

use \Jacwright\RestServer\RestException;

include("MysqlClass.php");
include("PestJSON.php");

class TestController extends DB
{
    /**
     * Returns a JSON string object to the browser when hitting the root of the domain
     *
     * @url GET /
     */
    public function test()
    {




       return array("success" => "Logged in " );
    }

    /**
     * Logs in a user with the given username and password POSTed. Though true
     * REST doesn't believe in sessions, it is often desirable for an AJAX server.
     *
     * @url POST /login
     */
    public function login()
    {

	$sql = "select * from users;";

	if ($result=mysqli_query($this->link,$sql))
	  {
	  while ($obj=mysqli_fetch_object($result))
	    {
	    printf("%s \n",$obj->user_email);
	    }


	}

        $username = $_POST['username'];
        $password = $_POST['password']; //@todo remove since it is not needed anywhere
        return array("success" => "Logged in " . $password);
    }

    /**
     * Logs in a user with the given username and password POSTed. Though true
     * REST doesn't believe in sessions, it is often desirable for an AJAX server.
     *
     * @url POST /log
     */
    public function log()
    {

       $sql = 'INSERT INTO log (description) VALUES ("'.$_POST['description'].'");';
      if(mysqli_query($this->link,$sql)) {
        return array("success" => "data saved");
      }else {
        throw new RestException(401, "Error saving data");
      }
    }


    /**
     * Logs in a user with the given username and password POSTed. Though true
     * REST doesn't believe in sessions, it is often desirable for an AJAX server.
     *
     * @url POST /password
     */
    public function changepassword()
    {

       extract ($_POST);
       //$password = ;
	     $sql = 'select from users where uid = '".$uid."' and password ="'.md5($password).'"';

    	if ($result=mysqli_query($this->link,$sql))
    	  {
    	  while ($obj=mysqli_fetch_object($result))
    	    {
    	          $sql = 'update users set password ="'.md5($password).'" where uid = '".$uid."'';
                if(mysqli_query($this->link,$sql)) {
                  return array("success" => "password changed");
                }else {
                  echo $sql;
                  throw new RestException(401, "Error saving data");
                }
    	    }


    	}


    }

  /**
     * Logs in a user with the given username and password POSTed. Though true
     * REST doesn't believe in sessions, it is often desirable for an AJAX server.
     *
     * @url POST /history
     */
    public function history()
    {
    	$ll = $_POST['ll'];
      $uid = $_POST['uid'];
    	$pest = new PestJSON('https://api.foursquare.com');
    	// Retrieve and iterate over the list of all Users
    	$locs = $pest->get('/v2/venues/search?ll='.$ll.'&client_id=MNGNKO0QUJK2534VZKPGF5YD1NUW0AZM0F1YFJHIANYBAVJH&client_secret=2TIP4IONOYKBBTPYA1FGFARLY0JCVDCJIK3L1RG1N2NPJ21E&v='.date('Ymd'));
      //print_r ($locs);
      if ($locs['response']['venues']) {
          foreach ($locs['response']['venues'] as $key => $venue) {
            //echo $venue['categories'][0]['name'];
            //skip this non-prominent places
           if (in_array( $venue['categories'][0]['name'],  array('Parking','City','County','Country','Neighborhood','State','Town','Village','Road','Street','Intersection')) ) {
             continue;
           } else {
              $loc = $venue['name'];
              $city =  $venue['location']['city'];
              $cat = $venue['categories'][0]['name'];
              //just save it in log for ref
              $this->log("UID :".$uid. " LL : ".$ll);

              $sql = 'INSERT INTO history (`id`, `venue_name`, `category`, `city`, `uid`, `ll`) VALUES
                      ("'.$name.'","'.$loc.'","'.$cat.'","'.$city.'","'.$uid.'","'.$ll.'");';
              if(mysqli_query($this->link,$sql)) {
                return array("success" => "data saved");
              }else {
                echo $sql;
                throw new RestException(401, "Error saving data");
              }

            //  break;
           }

          }
      }





    }





    /**
     * Gets the user by id or current user
     *
     * @url GET /users/$id
     * @url GET /users/current
     */
    public function getUser($id = null)
    {
        // if ($id) {
        //     $user = User::load($id); // possible user loading method
        // } else {
        //     $user = $_SESSION['user'];
        // }

        return array("id" => $id, "name" => null); // serializes object into JSON
    }

    /**
     * Saves a user to the database
     *
     * @url POST /user
     */
    public function saveUser()
    {

      extract($_POST);
        //update
        if ($uid) {
          $sql = 'UPDATE `users` SET
                  `email` = "'.$email.'",
                  `fname` = "'.$fname.'",
                  `lname` = "'.$lname.'",
                  `gender` = "'.$gender.'",
                  `city` = "'.$city.'",
                  `bio` = "'.$bio.'"
                   WHERE `users`.`id` = "'.$uid.'";';

           if(mysqli_query($this->link,$sql)) {
             return array("status" => "success");
           }else {
             $error =  mysqli_error($this->link);

             if (stripos($error, "duplicate") !== false )
               throw new RestException(401, "Email has ben taken");
             else
               throw new RestException(401, "Error signing up. Please try again.");
           }

        }else {
          //save
          $sql = 'INSERT INTO users (`email`, `password`) VALUES
                  ("'.$email.'","'.md5($password).'");';
          if(mysqli_query($this->link,$sql)) {
            return array("uid" => mysqli_insert_id($this->link));
          }else {
            $error =  mysqli_error($this->link);

            if (stripos($error, "duplicate") !== false )
              throw new RestException(401, "Email already exists");
            else

              throw new RestException(401, "Error signing up. Please try again.");
          }
        }


      //  return $user; // returning the updated or newly created user object
    }

    /**
     * Get Charts
     *
     * @url GET /charts
     * @url GET /charts/$id
     * @url GET /charts/$id/$date
     * @url GET /charts/$id/$date/$interval/
     * @url GET /charts/$id/$date/$interval/$interval_months
     */
    public function getCharts($id=null, $date=null, $interval = 30, $interval_months = 12)
    {
        echo "$id, $date, $interval, $interval_months";
    }

    /**
     * Throws an error
     *
     * @url GET /error
     */
    public function throwError() {
        throw new RestException(401, "Empty password not allowed");
    }
}
