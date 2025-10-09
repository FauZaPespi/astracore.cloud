// Style du signup et verification des mots de passe

const password = document.getElementById('signup-password');
const confirmPassword = document.getElementById('signup-confirm');
const submit = document.getElementById("submit");

handleInput();

password.addEventListener("input", handleInput);
confirmPassword.addEventListener("input", handleInput);

function handleInput() {
    if (password.value !== confirmPassword.value) {
        document.getElementById("passwordMatchError").textContent = "Passwords do not match. Please try again.";
        submit.disabled = true;
    } else {
        document.getElementById("passwordMatchError").textContent = "";
        submit.disabled = false;
    }
}

document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.style.transform = 'translateY(-2px)';
    });

    input.addEventListener('blur', () => {
        input.parentElement.style.transform = 'translateY(0)';
    });
});

document.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;

    const background = document.querySelector('.grid-background');
    const translateX = (mouseX - 0.5) * 20;
    const translateY = (mouseY - 0.5) * 20;

    background.style.transform = `translate(${translateX}px, ${translateY}px)`;
});