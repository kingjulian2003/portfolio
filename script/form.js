document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;

    // État de chargement
    submitBtn.disabled = true;
    submitBtn.textContent = 'Envoi en cours...';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        });
    } catch (error) {
        form.reset();
    } finally {
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            form.reset();
        }, 2000);
        document.getElementById('form-message').innerHTML = "Message envoyé !";
    }
});