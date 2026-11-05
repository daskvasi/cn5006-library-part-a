<?php
/**
 * Κοινό header όλων των σελίδων.
 */
require_once __DIR__ . '/auth.php';
Auth::start();

$pageTitle = $pageTitle ?? 'Mitropolitiko Project Library';
$extraHead = $extraHead ?? '';
$homePage  = $homePage ?? false;
$isLogged  = Auth::check();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?> - Mitropolitiko Project Library</title>
    <link rel="stylesheet" href="css/style.css">
    <?php echo $extraHead; ?>
</head>
<body>

<header class="site-header">
    <h2><a href="index.php">Mitropolitiko Project Library</a></h2>

    <nav>
        <a href="index.php">Αρχική</a>

        <?php if ($homePage): ?>
            <a href="#about">Σχετικά</a>
            <a href="#location">Τοποθεσία</a>
        <?php endif; ?>

        <?php if ($isLogged): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout (<?php echo e(Auth::username()); ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<main<?php echo $homePage ? '' : ' class="container"'; ?>>
