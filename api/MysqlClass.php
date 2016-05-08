<?php
class DB {
    function __construct() {
 	$link = mysqli_connect("localhost", "root", "password", "heartboxx");
	$this->link = $link;
      }
}
