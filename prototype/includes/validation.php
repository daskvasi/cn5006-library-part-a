<?php
/**
 * Συναρτήσεις ελέγχου εγκυρότητας στον server.
 * Οι ίδιοι κανόνες υπάρχουν και στο js/validation.js (browser),
 * ώστε ο έλεγχος να γίνεται και στις δύο πλευρές.
 */

/**
 * γινεται ελεγχος για το username 3-30 χαρακτήρες, λατινικά, αριθμοί ή _.
 */
function validate_username(string $username): bool
{
    return (bool) preg_match('/^[A-Za-z0-9_]{3,30}$/', $username);
}

/**
 * Ελέγχει αν το email έχει έγκυρη μορφή.
 */
function validate_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Ελέγχει το password: τουλάχιστον 8 χαρακτήρες.
 */
function validate_password(string $password): bool
{
    return strlen($password) >= 8;
}
