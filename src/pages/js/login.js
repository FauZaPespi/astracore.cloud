/**
 * Adds focus and blur event listeners to all elements with the class 'form-input'.
 * On focus, moves the parent element up slightly; on blur, resets its position.
 */
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.style.transform = 'translateY(-2px)';
    });

    input.addEventListener('blur', () => {
        input.parentElement.style.transform = 'translateY(0)';
    });
});

/**
 * Adds a mousemove event listener to the document to create a parallax effect
 * on the element with the class 'grid-background' based on mouse position.
 *
 * @param {MouseEvent} e - The mousemove event object.
 */
document.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;

    const background = document.querySelector('.grid-background');
    const translateX = (mouseX - 0.5) * 20;
    const translateY = (mouseY - 0.5) * 20;

    background.style.transform = `translate(${translateX}px, ${translateY}px)`;
});

/**
 * Sets focus to the input element with the id 'login-email' when the DOM is fully loaded.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('login-email').focus();
});