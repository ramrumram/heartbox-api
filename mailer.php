<?php
require 'vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;


function send_mail($from, $to, $subject, $body) {
try {
  $httpAdapter = new Guzzle6HttpAdapter(new Client());
  $sparky = new SparkPost($httpAdapter, ['key'=>'a80d70eef406932d9c48d13065a2e050a0b27817']);

  // Build your email and send it!
  $results = $sparky->transmission->send([
    'from'=>$from,
    'html'=>'<html><body>'.$body.'</body></html>',
    'subject'=>$subject,
    'recipients'=> $to
  ]);
//  echo 'Woohoo! You just sent your first mailing!';
} catch (\Exception $err) {
//  echo 'Whoops! Something went wrong';
  var_dump($err);
}

}
