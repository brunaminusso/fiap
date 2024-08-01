<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('MYAPP_SESSION');
    session_start([
        'cookie_lifetime' => 86400,
        'gc_maxlifetime' => 86400,
        'cookie_secure' => true,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict',
        'use_strict_mode' => true,
    ]);
}
