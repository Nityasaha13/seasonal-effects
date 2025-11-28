<?php

if (!defined('ABSPATH')) {
    exit;
}

// Convert hex color to RGB
function seasonal_effects_hex_to_rgb($hex) {
    $hex = ltrim($hex, '#');
    return array(
        'r' => hexdec(substr($hex, 0, 2)),
        'g' => hexdec(substr($hex, 2, 2)),
        'b' => hexdec(substr($hex, 4, 2))
    );
}