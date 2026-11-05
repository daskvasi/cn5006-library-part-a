/**
 * Φορτώνει τον χάρτη Leaflet (OpenStreetMap) με marker
 * στη θέση της βιβλιοθήκης. Απαιτεί τη βιβλιοθήκη Leaflet.
 */
document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map');

    // ελέγχει αν δεν υπάρχει χάρτης στη σελίδα ή δεν φορτώθηκε το Leaflet
    if (!mapElement || typeof L === 'undefined') {
        return;
    }

    const position = [37.98008, 23.7357];

    const map = L.map('map').setView(position, 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker(position)
        .addTo(map)
        .bindPopup(
            '<b>Mitropolitiko Project Library</b><br>' +
            'Ακαδημίας 42, Αθήνα 106 72'
        );
});
