<?php
$counterFile = "counter.txt";
$file = 'game.zip';

if (!file_exists($file)) {
    http_response_code(404);
    exit("ファイルが見つかりません。");
}

// カウンター処理
$fp = fopen($counterFile, "c+");
if ($fp && flock($fp, LOCK_EX)) {
    $count = (int)fread($fp, filesize($counterFile));
    $count++;
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, $count);
    fflush($fp);
    flock($fp, LOCK_UN);
}
fclose($fp);

// ヘッダー送信
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="game.zip"');
header('Content-Length: ' . filesize($file));

ob_clean();
flush();
readfile($file);
exit;
