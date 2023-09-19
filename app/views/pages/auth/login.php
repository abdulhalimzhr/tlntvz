<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        .login-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-input-placeholder {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: textfield;
        }

        * {
            padding: 0;
            margin: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            outline: none;
            font-family: arial;
        }

        h2 {
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: row;
            justify-content: start;
            align-items: center;
            gap: 20px;

        }

        .input-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: row;
            justify-content: start;
            align-items: center;
            gap: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input-group button {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .alert {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .alert--danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .alert--danger p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($_SESSION['errors']['cred'])) : ?>
            <div class="alert alert--danger">
                <p><?= $_SESSION['errors']['cred'] ?></p>
            </div>
        <?php endif ?>
        <form action="/login" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <a href="/register" style="text-decoration:none;">Register</a>
            </div>
            <div class="input-group">
                <button type="submit" class="btn-login">Login</button>
            </div>
        </form>
    </div>
</body>

</html>