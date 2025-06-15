<?php
$counterFile = "counter.txt";
$file = 'game.zip'; // ←ここを修正した！

// ファイル存在確認
if (!file_exists($file)) {
    http_response_code(404);
    exit("ファイルが見つかりません。");
}

// カウンター処理（排他ロック付き）
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, "0");
}
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

// ダウンロード用ヘッダー出力
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="game.zip"');
header('Content-Length: ' . filesize($file));

// 出力バッファのクリアとフラッシュ
ob_clean();
flush();
readfile($file);
exit;
