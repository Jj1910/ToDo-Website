<?php

declare(strict_types=1);

class SignInModel extends Dbh {

    /**
     * @return array<string, mixed>|null  null when the user does not exist
     */
    protected function getUser(string $username) {
        $query = "SELECT id, username, pwd FROM users WHERE username = :username;";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result === false ? null : $result;
    }
}