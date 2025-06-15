<?php
$counterFile = "counter.txt";
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, "0");
}
$count = (int)file_get_contents($counterFile);
$count++;
file_put_contents($counterFile, $count);

$file = 'games/super-danin-sanpo.zip';
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="super-danin-sanpo.zip"');
readfile($file);
?>