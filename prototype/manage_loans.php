<?php
/**
 * manage_loans.php
 *
 * Placeholder σελίδα: Manage Loans.
 * Η λειτουργία θα υλοποιηθεί στο Μέρος Β'.
 */
require_once "includes/auth.php";

Auth::requireRole(Auth::ROLE_LIBRARIAN);

$pageTitle = "Manage Loans";
require "includes/header.php";
?>

<h1>Manage Loans</h1>
<p>Η λειτουργία αυτής της σελίδας θα υλοποιηθεί στο Μέρος Β'.</p>
<p><a class="btn" href="dashboard.php">Επιστροφή στο Dashboard</a></p>

<?php require "includes/footer.php"; ?>
