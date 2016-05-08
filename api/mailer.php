<?php
require 'vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;

$httpAdapter = new Guzzle6HttpAdapter(new Client());
$sparky = new SparkPost($httpAdapter, ['key'=>'a80d70eef406932d9c48d13065a2e050a0b27817']);

try {
  // Build your email and send it!
  $results = $sparky->transmission->send([
    'from'=>'From Envelope <from@sparkpostbox.com>',
    'html'=>'<html><body><h1>Congratulations, {{name}}!</h1><p>You just sent your very first mailing!</p></body></html>',
    'text'=>'Congratulations, {{name}}!! You just sent your very first mailing!',
    'substitutionData'=>['name'=>'YOUR FIRST NAME'],
    'subject'=>'First Mailing From PHP',
    'recipients'=>[
      [
        'address'=>[
          'name'=>'YOUR FULL NAME',
          'email'=>'rameshkumar86@gmail.com'
        ]
      ]
    ]
  ]);
  echo 'Woohoo! You just sent your first mailing!';
} catch (\Exception $err) {
  echo 'Whoops! Something went wrong';
  var_dump($err);
}
