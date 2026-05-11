<?php
function read_json($path) {
    if (!file_exists($path)) return [];
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function write_json($path, $data) {
    $fp = fopen($path, 'c+');
    if ($fp === false) return false;
    flock($fp, LOCK_EX);
    ftruncate($fp, 0);
    fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}

function json_response($success, $data = null, $error = null, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'data' => $data, 'error' => $error]);
    exit;
}

function next_id($items) {
    if (empty($items)) return 1;
    return max(array_column($items, 'id')) + 1;
}
