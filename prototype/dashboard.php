<?php
/**
 * dashboard.php
 *
 * Κοινό dashboard για συνδεδεμένους χρήστες.
 * Το μενού διαφέρει ανά ρόλο (Member / Librarian).
 */
require_once "includes/auth.php";

Auth::requireLogin();

$roleId   = Auth::roleId();
$roleName = ($roleId === Auth::ROLE_LIBRARIAN) ? "Librarian" : "Member";

$pageTitle = "Dashboard";
require "includes/header.php";
?>

<h1 class="dashboard-title">Καλώς ήρθες, <?php echo e(Auth::username()); ?>!</h1>
<h2><?php echo e($roleName); ?> Dashboard</h2>

<div class="menu-grid">
    <?php foreach (Auth::menuFor($roleId) as $item): ?>
        <a class="menu-card" href="<?php echo e($item[1]); ?>">
            <?php echo e($item[0]); ?>
        </a>
    <?php endforeach; ?>
</div>

<?php require "includes/footer.php"; ?>
