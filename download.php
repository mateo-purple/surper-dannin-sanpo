<?php
$counterFile = "counter.txt";
$file = 'game.zip'; // ← ここも game.zip に変更

if (!file_exists($file)) {
    http_response_code(404);
    echo "ファイルが見つかりません。";
    exit;
}

// カウンター処理（排他ロック付き）
$fp = fopen($counterFile, "c+");
if (flock($fp, LOCK_EX)) {
    $size = filesize($counterFile);
    $count = $size > 0 ? (int)fread($fp, $size) : 0;
    $count++;
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, $count);
    fflush($fp);
    flock($fp, LOCK_UN);
}
fclose($fp);

// ダウンロードヘッダー
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="game.zip"');
header('Content-Length: ' . filesize($file));
readfile($file);
exit;
?>
