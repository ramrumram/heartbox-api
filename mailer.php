<?php

require 'vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;


function send_mail($from, $to, $subject, $body) {
try {
  $httpAdapter = new Guzzle6HttpAdapter(new Client());


  $sparky = new SparkPost($httpAdapter, ['key'=>'3cdd8cbefe22442004bd0c54dbf1f927ebf5f89d']);

  // Build your email and send it!
  $results = $sparky->transmission->send([
    'from'=>$from,
    'html'=>'<html><body>'.$body.'</body></html>',
    'subject'=>$subject,
    'recipients'=> $to
  ]);

} catch (\Exception $err) {
//  echo 'Whoops! Something went wrong';
  var_dump($err);
}

}


/*
 $recps = array(
      array('address' => array('name'=> 'dfdf','email'=> 'bala223344@gmail.com'))

  );

  //  $from = 'App user <'.$obj->email.'>';
    $from = 'Heartboxx App user <from@heartboxx.com>';

    $subject = ($subject)?$subject:"no subject";


    send_mail($from, $recps, $subject, $body);
*/