<?php

use \Jacwright\RestServer\RestException;

include_once("MysqlClass.php");
include_once("PestJSON.php");
include_once("functions.php");

class VenuesController extends DB
{



  /**
    *
    * @url GET /gethistory/$uid
    */
  public function gethistory($uid){

    $sql = 'SELECT DATE(created_at) AS visit_date, venue_name, category, cat_img from history
            WHERE uid = "'.$uid.'" order by DATE(created_at) DESC LIMIT 100;';


            if ($result=mysqli_query($this->link,$sql))
          	  {

            	  while ($obj=mysqli_fetch_object($result))
            	    {

                    $history [$obj->visit_date] [] = array('venue_name' => $obj->venue_name, 'category' => $obj->category, 'cat_img' => $obj->cat_img, 'visit_date' => $obj->visit_date);
                    //  return array("uid" => $obj->id);
            	    }


          	}else {
                $history = null;
              //throw new RestException(401, "Wrong credentials!");
            }

            if ($history != null) {
              $i = 0;
            //history is nicely formatted just make it a normal array  for tableview section processing

              foreach ( $history as $key => $val ) {
                  $temp [$i] = $val;
                  $i++;
              }

              $history = $temp;

            }
            return array('history' => $history);

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
              //take short name
              $cat = $venue['categories'][0]['shortName'];
              //just save it in log for ref
            //  $this->log("UID :".$uid. " LL : ".$ll);
              $pf = $venue["categories"][0]["icon"]["prefix"];
              $sf = $venue["categories"][0]["icon"]["suffix"];
              $timage = $pf."bg_32".$sf;

              $sql = 'INSERT INTO history (`id`, `venue_name`, `category`, `city`, `uid`, `ll`,`cat_img`) VALUES
                      ("'.$name.'","'.$loc.'","'.$cat.'","'.$city.'","'.$uid.'","'.$ll.'","'.$timage.'");';
                      echo $sql;
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
