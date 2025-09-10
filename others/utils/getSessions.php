<?php

session_start();

class GetSessions {
    function getRol() {
        return $_SESSION['rolUser'] ?? null;
    }

    function getEmail() {
        return $_SESSION['emailUser'] ?? null;
    }
}