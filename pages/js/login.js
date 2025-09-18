// Enhanced input focus effects
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.style.transform = 'translateY(-2px)';
    });

    input.addEventListener('blur', () => {
        input.parentElement.style.transform = 'translateY(0)';
    });
});

// Social button interactions
document.querySelectorAll('.social-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        alert(`${btn.title} integration coming soon!`);
    });
});

// Add subtle mouse movement parallax effect
document.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;

    const background = document.querySelector('.grid-background');
    const translateX = (mouseX - 0.5) * 20;
    const translateY = (mouseY - 0.5) * 20;

    background.style.transform = `translate(${translateX}px, ${translateY}px)`;
});

// Auto-focus first input on page load
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('login-email').focus();
});