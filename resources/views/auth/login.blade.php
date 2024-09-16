<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form id="login-form" method="POST" action="/login" accept-charset="UTF-8">
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

<script></script>

</html>
