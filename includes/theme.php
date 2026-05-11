<?php
require_once __DIR__ . '/functions.php';

function get_theme_settings() {
    $defaults = [
        'app_name' => 'socialTeam',
        'theme' => 'sunset'
    ];
    $path = __DIR__ . '/../data/settings.json';
    $settings = read_json($path);
    if (!is_array($settings)) return $defaults;
    return array_merge($defaults, $settings);
}

function theme_css_vars($theme) {
    $themes = [
        'sunset' => '--bg:#0f1020;--panel:#171933;--panel2:#202445;--line:#333860;--text:#f8f8ff;--muted:#a8add4;--accent1:#ff5f6d;--accent2:#ffc371;',
        'ocean' => '--bg:#07131f;--panel:#0f2438;--panel2:#16334d;--line:#285173;--text:#edf9ff;--muted:#9fbece;--accent1:#00c6ff;--accent2:#0072ff;',
        'forest' => '--bg:#0c1913;--panel:#14281f;--panel2:#1c372b;--line:#335845;--text:#effff5;--muted:#9fbea8;--accent1:#56ab2f;--accent2:#a8e063;'
    ];
    return $themes[$theme] ?? $themes['sunset'];
}
