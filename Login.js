document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form from submitting normally

    const formData = new FormData(this);

    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.role === 'admin') {
                window.location.href = 'Admin.html';
            } else if (data.role === 'customer') {
                window.location.href = 'Customer.html';
            }
        } else {
            document.getElementById('loginError').innerText = data.message;
            document.getElementById('loginError').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

