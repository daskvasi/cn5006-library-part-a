<?php
/**
 * index.php
 *
 * Δημόσια αρχική σελίδα της βιβλιοθήκης: πληροφορίες, εικόνες,
 * χάρτης Leaflet με marker και επιλογές Σύνδεσης / Εγγραφής.
 */
$pageTitle = "Αρχική";
$homePage  = true;
$extraHead = '
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="js/map.js" defer></script>';

require "includes/header.php";
?>

<div class="hero">
    <h1>Καλώς ήρθατε στη βιβλιοθήκη μας</h1>
    <p>
        Ένας σύγχρονος χώρος γνώσης, μάθησης και πολιτισμού.
        Ανακαλύψτε βιβλία, μελετήστε και γίνετε μέλος
        της Mitropolitiko Project Library.
    </p>

    <?php if (Auth::check()): ?>
        <a class="btn" href="dashboard.php">Μετάβαση στο Dashboard</a>
    <?php else: ?>
        <a class="btn" href="register.php">Γίνε μέλος</a>
        <a class="btn" href="login.php">Σύνδεση</a>
    <?php endif; ?>
</div>

<section id="about" class="home-section">
    <h2>Σχετικά με εμάς</h2>

    <div class="about-grid">
        <img src="pictures/library_table.jpg"
             alt="Χώρος μελέτης της βιβλιοθήκης με τραπέζια και ράφια βιβλίων">

        <div>
            <p>
                Η Mitropolitiko Project Library είναι μια σύγχρονη
                δημοτική βιβλιοθήκη που προσφέρει πρόσβαση στη γνώση
                και την πληροφορία.
            </p>
            <p>
                Διαθέτουμε συλλογή βιβλίων, χώρους μελέτης και
                υπηρεσίες δανεισμού για όλα τα μέλη μας.
            </p>
        </div>
    </div>
</section>

<section id="location" class="home-section">
    <h2>Πού θα μας βρείτε</h2>

    <div class="info">
        <p>Ακαδημίας 42, Αθήνα 106 72</p>
        <p>Τηλέφωνο: 210 000 0000</p>
        <p>Email: info@mitropolitikolibrary.gr</p>
        <p>Ωράριο: Δευτέρα - Παρασκευή, 09:00 - 20:00</p>
    </div>

    <div id="map"></div>
</section>

<?php require "includes/footer.php"; ?>
