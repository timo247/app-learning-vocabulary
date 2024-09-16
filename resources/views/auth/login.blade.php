<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form id="login-form" accept-charset="UTF-8">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="john@doe.com">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required value="password">
        </div>
        <button type="submit" onclick="login()"> Envoyer </button>
    </form>
</body>

<script>
    const appUrl = "{{ env('APP_URL') }}";
    const loginForm = document.getElementById('login-form');
    const csrfToken = document.querySelector('input[name="_token"]').getAttribute('value')

    loginForm.addEventListener('submit', (e) => e.preventDefault());

    function login() {
        console.log("CSRF Token:", csrfToken);
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        fetch(`${appUrl}/api/login`, {

                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                }),
            })
            .then(response => response.json())
            .then(response => {
                if (response.data.token) {
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', response.data.user.id)
                    return redirectToVocabularies(response.data.user.id, response.data.token)
                } else {
                    alert('Invalid credentials');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    function redirectToVocabularies(userId, token) {
        console.log('on se rend à vocabularies')
        fetch(`${appUrl}/api/vocabularies`, {
            method: 'post',
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        });
    }
</script>

</html>
