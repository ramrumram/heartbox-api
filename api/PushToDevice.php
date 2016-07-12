<?php
class PushToDevice {
public function perform()
    {
        // Work work work
//        echo $this->args['name'];
$fp = fopen('/var/www/test/data.txt', 'w');
fwrite($fp, '1');
fwrite($fp, '23');
fclose($fp);

//fwrite(fopen("dfd.txt"), "w");
    }
}
