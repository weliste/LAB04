<?php

echo "Hello Azure";

$stdout = fopen('php://stdout', 'a');
fwrite($stdout, "アクセスしました。");
fclose($stdout);
