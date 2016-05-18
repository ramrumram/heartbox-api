<?php
require 'vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;


function send_mail($from, $to, $subject, $body) {
try {
  $httpAdapter = new Guzzle6HttpAdapter(new Client());
  $sparky = new SparkPost($httpAdapter, ['key'=>'318c09923d87c9db120a6ea0e49b5c14b9f9ea3d']);

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
