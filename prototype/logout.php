<?php
/**
 * logout.php
 *
 * Καταστρέφει το session και επιστρέφει τον χρήστη στη δημόσια σελίδα.
 */
require_once "includes/auth.php";

Auth::logout();

header("Location: index.php");
exit;
