<?php

declare(strict_types=1);

// CSRF helpers are available on every page that starts the session.
require_once __DIR__ . '/csrf.inc.php';

// ---------------------------------------------------------------------------
// Session cookie hardening.
//
// The cookie is marked Secure ONLY on real HTTPS connections, and no explicit
// domain is set (the browser then scopes the cookie to the current host).
// That makes sessions work on http://localhost in development AND on a proper
// HTTPS domain in production.  SameSite=Lax adds a CSRF layer on top.
// ---------------------------------------------------------------------------
$isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
       || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');

session_set_cookie_params([
    'lifetime' => 86400,
    'path'     => '/',
    'secure'   => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Rotate the session id at most every 30 minutes (session-fixation hardening).
if (!isset($_SESSION['last_regeneration'])) {
    regenerate_session_id();
} elseif (time() - (int)$_SESSION['last_regeneration'] >= 60 * 30) {
    regenerate_session_id();
}