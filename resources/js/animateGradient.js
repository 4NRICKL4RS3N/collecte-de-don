const url = window.location.pathname

class CursorGradient {
    constructor(element, defaultColors = [
        'rgba(80, 92, 253, 1)',
        'rgba(80, 92, 253, 1)',
        'rgba(82, 209, 220, 1)'
    ]) {
        this.element = element;
        this.currentX = 0;
        this.currentY = 0;
        this.ease = 0.1;
        this.defaultColors = defaultColors;
    }

    updateGradient(targetX, targetY, colors = this.defaultColors) {
        // delay
        this.currentX += (targetX - this.currentX) * this.ease;
        this.currentY += (targetY - this.currentY) * this.ease;

        // manambatra an'ireo couleur ho string ray
        const gradientColors = colors.length > 0 ? colors : this.defaultColors;
        const colorString = gradientColors.map(color => color).join(', ');

        this.element.style.background = `radial-gradient(
                    circle at ${this.currentX}px ${this.currentY}px,
                    ${colorString}
                )`;
    }
}

//accueil
if (url === '/accueil') {
    const cards_accueil = document.querySelectorAll('.card-impacte');
    const cta = document.querySelector('.section-cta');

    const gradientTrackers = [
        ...Array.from(cards_accueil).map(card => new CursorGradient(card)),
        new CursorGradient(cta)
    ];

    document.addEventListener('mousemove', (e) => {
        gradientTrackers.forEach(tracker => {
            const rect = tracker.element.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            tracker.updateGradient(x, y);
        });
    });
}

//donate
if (url === '/donate' || url === '/contact') {
    const card_donate = document.querySelector('.donation_container');
    const gradientTracker = new CursorGradient(card_donate)
    const gradient = [
        'rgba(4, 15, 22, 1)',
        'rgba(4, 15, 22, 1)',
        'rgba(45, 40, 141, 1)'
    ];
    document.addEventListener('mousemove', (e) => {
        const rect = gradientTracker.element.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        gradientTracker.updateGradient(x, y, gradient);
    });
}

//projet cta
if (url.startsWith('/projets/')) {
    const card_projet = document.querySelector('.project-cta');
    const gradientTrackerProjet = new CursorGradient(card_projet)
    const gradient = [
        'rgba(4, 15, 22, 1)',
        'rgba(4, 15, 22, 1)',
        'rgba(45, 40, 141, 1)'
    ];
    document.addEventListener('mousemove', (e) => {
        const rect = gradientTrackerProjet.element.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        gradientTrackerProjet.updateGradient(x, y, gradient);
    });
}
