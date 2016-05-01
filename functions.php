<?php
function random_string($length){

  return substr(str_shuffle("!@$^&0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

}
