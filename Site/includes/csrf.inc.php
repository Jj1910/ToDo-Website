<?php

declare(strict_types=1);

/**
 * Lightweight CSRF protection.
 *
 * A per-session token is generated lazily and embedded in every
 * state-changing form (see csrf_field()).  Handlers must call
 * verify_csrf() before acting on a POST.  The session cookie is also
 * SameSite=Lax (see config_session.inc.php) as a second layer.
 *
 * Requires an active session (config_session.inc.php is loaded first).
 */

function csrf_token(): string {
    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Render the hidden input to include inside a <form>. */
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="'
         . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/** Abort the request when the submitted token is missing or wrong. */
function verify_csrf(): void {
    $sent   = $_POST['csrf_token'] ?? '';
    $stored = $_SESSION['csrf_token'] ?? '';

    $valid = is_string($sent) && $sent !== ''
          && is_string($stored)
          && hash_equals($stored, $sent);

    if (!$valid) {
        http_response_code(403);
        error_log('CSRF verification failed from ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
        exit('Invalid or missing security token. Please go back, refresh the page and try again.');
    }
}