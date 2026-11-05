/**
 * validation.js
 *
 * Έλεγχος εγκυρότητας φορμών στον browser και σε κάθε πεδίο data-rules="required|email|min:8".
 * Οι ίδιοι κανόνες ελέγχονται και στον server (includes/validation.php).
 * Κάθε κανόνας επιστρέφει true αν η τιμή είναι έγκυρη,
 * αλλιώς το μήνυμα σφάλματος.
 */
const RULES = {
    required: (value) =>
        value.trim() !== '' || 'Το πεδίο είναι υποχρεωτικό.',

    email: (value) =>
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || 'Εισάγετε έγκυρο email.',

    username: (value) =>
        /^[A-Za-z0-9_]{3,30}$/.test(value) ||
        'Το username πρέπει να έχει 3-30 χαρακτήρες (λατινικά, αριθμοί ή _).',

    min: (value, length) =>
        value.length >= Number(length) ||
        'Τουλάχιστον ' + length + ' χαρακτήρες.'
};

/**
 * Ελέγχει ένα πεδίο και εμφανίζει/καθαρίζει το μήνυμα σφάλματος.
 */
function validateField(field) {
    const rules = (field.dataset.rules || '').split('|').filter(Boolean);
    const errorBox = document.getElementById('err-' + field.name);
    let message = '';

    for (const rule of rules) {
        const [name, param] = rule.split(':');
        const result = RULES[name](field.value, param);

        if (result !== true) {
            message = result;
            break;
        }
    }

    if (errorBox) {
        errorBox.textContent = message;
    }
    field.classList.toggle('input-invalid', message !== '');

    return message === '';
}

/**
 * Ενεργοποιεί τον έλεγχο σε όλες τις φόρμες με data-validate.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-validate]').forEach((form) => {
        const fields = form.querySelectorAll('[data-rules]');

        // Έλεγχος κατά την αποχώρηση από το πεδίο
        fields.forEach((field) => {
            field.addEventListener('blur', () => validateField(field));
            field.addEventListener('input', () => {
                if (field.classList.contains('input-invalid')) {
                    validateField(field);
                }
            });
        });

        // Έλεγχος πριν την αποστολή: αν υπάρχει σφάλμα, δεν στέλνεται
        form.addEventListener('submit', (event) => {
            let formIsValid = true;

            fields.forEach((field) => {
                if (!validateField(field)) {
                    formIsValid = false;
                }
            });

            if (!formIsValid) {
                event.preventDefault();
            }
        });
    });
});
