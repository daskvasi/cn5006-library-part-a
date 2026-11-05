<?php
/**
 * register.php
 *
 * Εγγραφή χρήστη (Μέλος ή Βιβλιοθηκονόμος) με ειδικό κωδικό εγγραφής.
 * Ο έλεγχος γίνεται και στον browser (js/validation.js) και στον server.
 */
require_once "config/database.php";
require_once "includes/auth.php";
require_once "includes/validation.php";
require_once "includes/User.php";

// Οι συνδεδεμένοι χρήστες δεν χρειάζεται να εγγραφούν ξανά
if (Auth::check()) {
    header("Location: dashboard.php");
    exit;
}

// Ειδικοί κωδικοί εγγραφής ανά ρόλο (παρέχονται από τη Διεύθυνση)
$registrationCodes = [
    Auth::ROLE_MEMBER    => "MEMB2026",
    Auth::ROLE_LIBRARIAN => "LIBR2026",
];

$errors   = [];
$username = "";
$email    = "";
$roleId   = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $roleId   = (int) ($_POST["role_id"] ?? 0);
    $code     = trim($_POST["registration_code"] ?? "");

    // Έλεγχος εγκυρότητας πεδίων στον server
    if (!validate_username($username)) {
        $errors[] = "Το username πρέπει να έχει 3-30 χαρακτήρες (λατινικά, αριθμοί ή _).";
    }

    if (!validate_email($email)) {
        $errors[] = "Το email δεν είναι έγκυρο.";
    }

    if (!validate_password($password)) {
        $errors[] = "Το password πρέπει να έχει τουλάχιστον 8 χαρακτήρες.";
    }

    if (!isset($registrationCodes[$roleId])) {
        $errors[] = "Παρακαλώ επιλέξτε έγκυρο ρόλο.";
    } elseif (!hash_equals($registrationCodes[$roleId], $code)) {
        $errors[] = "Λανθασμένος ειδικός κωδικός εγγραφής.";
    }

    // Έλεγχος μοναδικότητας και αποθήκευση
    if (empty($errors)) {
        try {
            if (User::exists($pdo, $username, $email)) {
                $errors[] = "Το username ή το email χρησιμοποιείται ήδη.";
            } else {
                User::create($pdo, $username, $email, $password, $roleId);
                header("Location: login.php?registered=1");
                exit;
            }
        } catch (PDOException $ex) {
            $errors[] = "Παρουσιάστηκε σφάλμα κατά την εγγραφή.";
        }
    }
}

$pageTitle = "Εγγραφή";
$extraHead = '<script src="js/validation.js" defer></script>';
require "includes/header.php";
?>

<div class="form-card">
    <h1>Εγγραφή Χρήστη</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST" novalidate data-validate>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   value="<?php echo e($username); ?>"
                   data-rules="required|username">
            <div class="form-hint">3-30 χαρακτήρες: λατινικά, αριθμοί ή _</div>
            <div class="field-error" id="err-username"></div>
        </div>

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
                   data-rules="required|min:8">
            <div class="form-hint">Τουλάχιστον 8 χαρακτήρες</div>
            <div class="field-error" id="err-password"></div>
        </div>

        <div class="form-group">
            <label for="role_id">Ρόλος</label>
            <select id="role_id" name="role_id" data-rules="required">
                <option value="">Επιλέξτε ρόλο</option>
                <option value="1" <?php echo $roleId === Auth::ROLE_MEMBER ? "selected" : ""; ?>>Μέλος</option>
                <option value="2" <?php echo $roleId === Auth::ROLE_LIBRARIAN ? "selected" : ""; ?>>Βιβλιοθηκονόμος</option>
            </select>
            <div class="field-error" id="err-role_id"></div>
        </div>

        <div class="form-group">
            <label for="registration_code">Ειδικός κωδικός εγγραφής</label>
            <input type="password" id="registration_code" name="registration_code"
                   data-rules="required">
            <div class="field-error" id="err-registration_code"></div>
        </div>

        <button type="submit">Εγγραφή</button>
    </form>

    <p class="form-footer">
        Έχετε ήδη λογαριασμό; <a href="login.php">Σύνδεση</a>
    </p>
</div>

<?php require "includes/footer.php"; ?>
