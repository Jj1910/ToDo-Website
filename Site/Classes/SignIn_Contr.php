<?php

declare(strict_types=1);

class SignInContr extends SignInModel {
    // A real bcrypt hash, used only to keep response time identical for
    // unknown users (prevents username enumeration via timing attacks).
    private const DUMMY_PASSWORD_HASH = '$2y$10$JRjeq.kVXgzM47ZPaX4zB.B83cuWpiEm2jCEEIMHJsVw5p6YoroVO';

    private $username;
    private $pwd;

    public function __construct(string $username, string $pwd) {
        $this->username = $username;
        $this->pwd = $pwd;
    }

    private function is_input_empty() {
        return $this->username === '' || $this->pwd === '';
    }

    public function signInUser() {
        if ($this->is_input_empty()) {
            header("Location: ../index.php?error=inputempty");
            exit;
        }

        $result = parent::getUser($this->username);

        // Always run password_verify — even for unknown users — so an
        // attacker can't tell which usernames exist by timing responses.
        $storedHash = ($result !== null) ? (string)$result["pwd"] : self::DUMMY_PASSWORD_HASH;

        if ($result === null || !password_verify($this->pwd, $storedHash)) {
            header("Location: ../index.php?error=invalidlogon");
            exit;
        }

        // Success: keep identity data minimal, then rotate the session id.
        $_SESSION["user_id"] = (int)$result["id"];
        $_SESSION["user_username"] = (string)$result["username"];
        regenerate_session_id();

        // Straight to the dashboard (no extra bounce through index.php).
        header("Location: ../dashboard.php");
        exit;
    }
}