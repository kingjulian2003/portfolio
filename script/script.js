document.addEventListener('DOMContentLoaded', () => {
    const cursor = document.querySelector('.custom-cursor');
    const hoverZones = document.querySelectorAll('.container','.navbar','.navbar-menu');
    let mouseX = 0, mouseY = 0;
    let cursorX = 0, cursorY = 0;
    const delay = 0.1; // Ajustez ce valeur pour plus/ moins de retard (0.1 = 10%)

    // Suivre la position réelle de la souris
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    // Animation pour le retard du curseur
    function animateCursor() {
        // Calculer la nouvelle position avec retard
        cursorX += (mouseX - cursorX) * delay;
        cursorY += (mouseY - cursorY) * delay;
        
        // Appliquer la position
        cursor.style.left = `${cursorX}px`;
        cursor.style.top = `${cursorY}px`;
        
        // Continuer l'animation
        requestAnimationFrame(animateCursor);
    }

    // Démarrer l'animation
    animateCursor();

    // Gestion des zones interactives
    hoverZones.forEach(zone => {
        zone.addEventListener('mouseenter', () => {
            cursor.style.display = 'line';
           });
        
        zone.addEventListener('mouseleave', () => {
            cursor.style.display = 'line';
            });
    });
});

function typeWriter(element, text, speed = 100) {
            let i = 0;
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                } else {
                    element.style.borderRight = 'none'; // Enlève le curseur à la fin
                }
            }
            type();
        }
document.querySelectorAll('[data-typewriter]').forEach(el => {
    const text = el.getAttribute('data-typewriter');
    const speed = el.getAttribute('data-speed') || 100;
    typeWriter(el, text, parseInt(speed));
});

