// Login Handler

const loginButtons = document.querySelectorAll('.login-btn');

loginButtons.forEach(button => {
    button.addEventListener('click', async () => {
        const account = button.getAttribute('data-account');
        const formData = new FormData();
        formData.append('account', account);
        try {
            const response = await fetch('./app/account-access.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                window.location.href = 'http://localhost:8000/project/demo-preventivi/index.php?page=dashboard';
            }
        } catch (error) {
            console.error('Error during login:', error);
        }
    });
});