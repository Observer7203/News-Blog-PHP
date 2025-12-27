<?php

namespace App\Core;

class Auth
{
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_PASSWORD = 'admin123';

    public static function attempt(string $username, string $password): bool
    {
        if ($username === self::ADMIN_USERNAME && $password === self::ADMIN_PASSWORD) {
            self::login();
            return true;
        }
        return false;
    }

    public static function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['admin_logged_in'] = true;
    }

    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['admin_logged_in']);
        session_destroy();
    }

    public static function check(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            header('Location: /admin/login');
            exit;
        }
    }
}
