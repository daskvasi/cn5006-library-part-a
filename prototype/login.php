<?php
/**
 * login.php
 *
 * Σύνδεση χρήστη: έλεγχος email/password, δημιουργία session
 * (user_id, username, role_id) και ανακατεύθυνση στο dashboard.
 */
require_once "config/database.php";
require_once "includes/auth.php";
require_once "includes/validation.php";
require_once "includes/User.php";

// Αν ο χρήστης είναι ήδη συνδεδεμένος, πάει κατευθείαν στο dashboard
if (Auth::check()) {
    header("Location: dashboard.php");
    exit;
}

$errors = [];
$email  = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Έλεγχος εγκυρότητας στον server
    if (!validate_email($email)) {
        $errors[] = "Το email δεν είναι έγκυρο.";
    }

    if ($password === "") {
        $errors[] = "Το password είναι υποχρεωτικό.";
    }

    // Έλεγχος διαπιστευτηρίων
    if (empty($errors)) {
        $user = User::findByEmail($pdo, $email);

        if ($user && password_verify($password, $user["password"])) {
            Auth::login($user);
            header("Location: dashboard.php");
            exit;
        }

        $errors[] = "Λανθασμένο email ή password.";
    }
}

$justRegistered = isset($_GET["registered"]);

$pageTitle = "Σύνδεση";
$extraHead = '<script src="js/validation.js" defer></script>';
require "includes/header.php";
?>

<div class="form-card">
    <h1>Σύνδεση Χρήστη</h1>

    <?php if ($justRegistered): ?>
        <div class="alert alert-success">
            Η εγγραφή ολοκληρώθηκε επιτυχώς! Μπορείτε να συνδεθείτε.
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST" novalidate data-validate>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="<?php echo e($email); ?>"
                   data-rules="required|email">
            <div class="field-error" id="err-email"></div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   data-rules="required">
            <div class="field-error" id="err-password"></div>
        </div>

        <button type="submit">Σύνδεση</button>
    </form>

    <p class="form-footer">
        Δεν έχετε λογαριασμό; <a href="register.php">Εγγραφή</a>
    </p>
</div>

<?php require "includes/footer.php"; ?>
