<?php

echo "Hello Azure";

$stdout = fopen('php://stdout', 'a');
fwrite($stdout, "piyo");
fclose($stdout);
