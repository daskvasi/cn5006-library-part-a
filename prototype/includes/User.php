<?php
/**
 * User.php
 *
 * Πρόσβαση στον πίνακα users.
 */

class User
{
    /**
     * Βρίσκει χρήστη με βάση το email.
     */
    public static function findByEmail(PDO $pdo, string $email): ?array
    {
        $stmt = $pdo->prepare(
            "SELECT user_id, username, email, password, role_id
             FROM users WHERE email = :email"
        );
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Ελέγχει αν υπάρχει ήδη χρήστης με το ίδιο username ή email.
     */
    public static function exists(PDO $pdo, string $username, string $email): bool
    {
        $stmt = $pdo->prepare(
            "SELECT user_id FROM users
             WHERE username = :username OR email = :email"
        );
        $stmt->execute([':username' => $username, ':email' => $email]);

        return (bool) $stmt->fetch();
    }

    /**
     * Δημιουργεί νέο χρήστη και το password αποθηκεύεται ως hash.
     * $roleId   1 = Member, 2 = Librarian
     */
    public static function create(PDO $pdo, string $username, string $email,
                                  string $password, int $roleId): bool
    {
        $stmt = $pdo->prepare(
            "INSERT INTO users (username, email, password, role_id)
             VALUES (:username, :email, :password, :role_id)"
        );

        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role_id'  => $roleId,
        ]);
    }
}
