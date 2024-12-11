function Limpiar() {
    document.getElementById("Modal").reset();
}

const input = document.getElementById('username');
input.addEventListener('input', (event) => {
    const regex = /^[A-Za-z0-9_-]*$/;
    if (!regex.test(event.target.value)) {
        event.target.value = event.target.value.replace(/[^A-Za-z0-9_-]/g, '');
    }
});

const inputs = document.getElementById('edit_username');
inputs.addEventListener('input', (event) => {
    const regex = /^[A-Za-z0-9_-]*$/;
    if (!regex.test(event.target.value)) {
        event.target.value = event.target.value.replace(/[^A-Za-z0-9_-]/g, '');
    }
});

const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('toggle-password');

togglePassword.addEventListener('click', () => {
    // Alternar el tipo del input entre "password" y "text"
    const isPassword = passwordInput.getAttribute('type') === 'password';
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
    // Cambiar el emoji según el estado
    togglePassword.textContent = isPassword ? '🙈' : '👁️';
 });

