<?php
/**
 * books.php
 *
 * Placeholder σελίδα: View Books.
 * Η λειτουργία θα υλοποιηθεί στο Μέρος Β'.
 */
require_once "includes/auth.php";

Auth::requireRole(Auth::ROLE_MEMBER);

$pageTitle = "View Books";
require "includes/header.php";
?>

<h1>View Books</h1>
<p>Η λειτουργία αυτής της σελίδας θα υλοποιηθεί στο Μέρος Β'.</p>
<p><a class="btn" href="dashboard.php">Επιστροφή στο Dashboard</a></p>

<?php require "includes/footer.php"; ?>
