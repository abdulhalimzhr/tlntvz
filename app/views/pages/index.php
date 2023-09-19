<!DOCTYPE html>
<html>

<head>
  <style>
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

    .container {
      padding-right: 5rem;
      padding-left: 5rem;
      padding-top: 3rem;
      padding-bottom: 3rem;
      background-color: #fff;
      border: 1px solid #ccc;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      width: 100%;
      display: flex;
      flex-direction: column;
    }

    .container .alert {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 20px;
    }

    .container .alert ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .container .alert li {
      color: red;
    }

    .container .alert--danger {
      background-color: #f8d7da;
      border-color: #f5c6cb;
      color: #721c24;
    }

    .container-flex {
      display: flex;
      flex-direction: row !important;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
    }
  </style>
</head>

<body>
  <header>
    <nav style="background-color: #333; padding: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; color: #fff;">
        <div>
          <h1 style="margin: 0;">Doelz</h1>
        </div>
        <div>
          <?php
          $loggedIn = $_SESSION['user'];
          if ($loggedIn) : ?>
            <ul style="list-style: none; margin: 0; padding: 0; display: flex;">
              <li style="margin-right: 20px;">
                <a href="/dashboard" style="text-decoration: none; color: #fff;">Dashboard</a>
              </li>
              <li style="margin-right: 20px;">
                <a href="/logout" style="text-decoration: none; color: #fff;">Logout</a>
              </li>
            </ul>
          <?php else : ?>
            <ul style="list-style: none; margin: 0; padding: 0; display: flex;">
              <li style="margin-right: 20px;">
                <a href="/login" style="text-decoration: none; color: #fff;">Login</a>
              </li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>
</body>

</html>