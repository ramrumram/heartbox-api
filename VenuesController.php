<?php

use \Jacwright\RestServer\RestException;

include_once("MysqlClass.php");
include_once("PestJSON.php");
include_once("functions.php");

class VenuesController extends DB
{

      /**
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
     *
     * @url POST /history
     */
    public function history()
    {
	//prams ll,uid
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
            //  $this->log("UID :".$uid. " LL : ".$ll);

              $sql = 'INSERT INTO history (`id`, `venue_name`, `category`, `city`, `uid`, `ll`) VALUES
                      ("'.$name.'","'.$loc.'","'.$cat.'","'.$city.'","'.$uid.'","'.$ll.'");';
              if(mysqli_query($this->link,$sql)) {
                return array("success" => "data saved");
              }else {
                throw new RestException(401, "Error saving data");
              }

            //  break;
           }

          }
      }





    }




}
