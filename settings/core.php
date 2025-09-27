<?php
// settings/core.php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(){
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isAdmin(){
    if (isLoggedIn()) {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1;
    }
    return false;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login/login.php');
        exit();
    }
}

function requireAdmin() {
    if (!isLoggedIn()) {
        header('Location: ../login/login.php');
        exit();
    }
    if (!isAdmin()) {
        header('Location: ../login/login.php');
        exit();
    }
}