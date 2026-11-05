<?php

class Auth
{
    const ROLE_MEMBER = 1;

    const ROLE_LIBRARIAN = 2;


    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(array $user): void
    {
        self::start();
        session_regenerate_id(true);

        $_SESSION['user_id']  = (int) $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role_id']  = (int) $user['role_id'];
    }

    public static function logout(): void
    {
        self::start();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }

        session_destroy();
    }

    public static function check(): bool
    {
        self::start();
        return isset($_SESSION['user_id']);
    }

    public static function roleId(): ?int
    {
        self::start();
        return isset($_SESSION['role_id']) ? (int) $_SESSION['role_id'] : null;
    }

    public static function username(): ?string
    {
        self::start();
        return $_SESSION['username'] ?? null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: login.php');
            exit;
        }
    }

    public static function requireRole(int $roleId): void
    {
        self::requireLogin();

        if (self::roleId() !== $roleId) {
            self::forbidden();
        }
    }

    public static function forbidden(): void
    {
        http_response_code(403);

        $pageTitle = 'Forbidden Action';
        require __DIR__ . '/header.php';

        echo '<div class="alert alert-error">';
        echo '<h2>Forbidden Action</h2>';
        echo '<p>Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα.</p>';
        echo '<p><a class="btn" href="dashboard.php">Επιστροφή στο Dashboard</a></p>';
        echo '</div>';

        require __DIR__ . '/footer.php';
        exit;
    }

    public static function menuFor(?int $roleId): array
    {
        if ($roleId === self::ROLE_MEMBER) {
            return [
                ['View Books',        'books.php'],
                ['My Reservations',   'my_reservations.php'],
                ['My Loans',          'my_loans.php'],
            ];
        }

        if ($roleId === self::ROLE_LIBRARIAN) {
            return [
                ['Manage Books',        'manage_books.php'],
                ['Manage Reservations', 'manage_reservations.php'],
                ['Manage Loans',        'manage_loans.php'],
            ];
        }

        return [];
    }
}

function e(?string $text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}
