// Функції для аутентифікації
document.addEventListener('DOMContentLoaded', function() {
    // Реєстрація кастомера
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(registerForm);
            const btn = registerForm.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = 'Registering...';
            let msg = document.getElementById('register-msg');
            if (msg) msg.remove();
            try {
                const response = await fetch('/register-customer', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData
                });
                const result = await response.json();
                if (result.status === 'success') {
                    registerForm.insertAdjacentHTML('beforebegin', `<div id="register-msg" style="color:green;margin-bottom:10px;">${result.message}</div>`);
                    registerForm.reset();
                } else {
                    let errors = '';
                    if (result.errors) {
                        for (const key in result.errors) {
                            errors += result.errors[key].join('<br>') + '<br>';
                        }
                    }
                    registerForm.insertAdjacentHTML('beforebegin', `<div id="register-msg" style="color:red;margin-bottom:10px;">${errors || 'Registration failed'}</div>`);
                }
            } catch (err) {
                registerForm.insertAdjacentHTML('beforebegin', `<div id="register-msg" style="color:red;margin-bottom:10px;">Server error. Try again later.</div>`);
            } finally {
                btn.disabled = false;
                btn.textContent = 'Register';
            }
        });
    }

    // Логін кастомера
    const loginForm = document.getElementById('login-form');
    console.log('Login form found:', loginForm); // DEBUG: Check if form is found

    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            console.log('Login form submit event triggered'); // DEBUG: Check if handler is triggered
            e.preventDefault(); // Prevent default form submission
            console.log('Default form submission prevented'); // DEBUG: Check if preventDefault worked

            const formData = new FormData(loginForm);
            const btn = loginForm.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = 'Logging in...';
            let msg = document.getElementById('login-msg');
            if (msg) msg.remove();
            try {
                const response = await fetch('/login-customer', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData
                });
                const result = await response.json();
                if (result.status === 'success') {
                    loginForm.insertAdjacentHTML('beforebegin', `<div id="login-msg" style="color:green;margin-bottom:10px;">${result.message}</div>`);
                    loginForm.reset();
                    setTimeout(() => { 
                        closeLoginPopup(); 
                        location.reload(); // Reload page after successful login
                    }, 1000);
                } else {
                    let errors = '';
                    if (result.errors) {
                        for (const key in result.errors) {
                            errors += result.errors[key].join('<br>') + '<br>';
                        }
                    }
                    loginForm.insertAdjacentHTML('beforebegin', `<div id="login-msg" style="color:red;margin-bottom:10px;">${errors || 'Login failed'}</div>`);
                }
            } catch (err) {
                loginForm.insertAdjacentHTML('beforebegin', `<div id="login-msg" style="color:red;margin-bottom:10px;">Server error. Try again later.</div>`);
            } finally {
                btn.disabled = false;
                btn.textContent = 'Login';
            }
        });
    } else {
        console.error('Login form with id="login-form" not found!');
    }
}); 