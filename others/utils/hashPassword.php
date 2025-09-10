<?php
class HashPassword {
    function hash($password) {
        // Use password_hash for secure password hashing
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function unHash($password, $hashedPassword) {
        // Use password_verify to check the password against the hash
        return password_verify($password, $hashedPassword);
    }
}