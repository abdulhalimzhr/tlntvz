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

        .btn-dismiss {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
    <section>
        <div class="container">
            <h1>Dashboard</h1>
            <p>Welcome, <?= $loggedIn['username'] ?></p>
            <p>Balance: IDR <?= currencyFormat($loggedIn['balance']) ?></p>
        </div>
        <div class="container">
            <?php if (isset($_SESSION['errors'])) : ?>
                <div class="alert alert--danger">
                    <ul style="padding: 10px">
                        <?php
                        foreach ($_SESSION['errors'] as $error) {
                        ?>
                            <li><?= $error ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div style="margin-top: 20px; justify-content: center; display: flex;">
                    <form action="/dismiss-alert" method="POST">
                        <button class="btn-dismiss" type="submit">Dismiss alert</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <div class="container container-flex">
            <div style="width:33%">
                <h1>Deposit</h1>
                <div>
                    <form class="form-group" action="/deposit" method="POST">
                        <div class="input-group">
                            <label for="amount">Amount:</label>
                            <input type="number" id="amount" name="amount" min="1" required placeholder="Min 1. e.g 10000">
                        </div>
                        <div class="input-group">
                            <button type="submit" class="btn-login">Deposit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div style="width:33%;">
                <h1>Withdraw</h1>
                <div>
                    <form class="form-group" action="/withdraw" method="POST">
                        <div class="input-group">
                            <label for="amount">Amount:</label>
                            <input type="number" id="amount" name="amount" min="1" required placeholder="Min 1. e.g 10000">
                        </div>
                        <div class="input-group">
                            <button type="submit" class="btn-login">Withdraw</button>
                        </div>
                    </form>
                </div>
            </div>
            <div style="width:33%;">
                <h1>Transfer</h1>
                <div>
                    <form class="form-group" action="/transfer" method="POST">
                        <div class="input-group">
                            <label for="amount">Amount:</label>
                            <input type="number" id="amount" name="amount" min="1" required placeholder="Min 1. e.g 10000">
                        </div>
                        <div class="input-group">
                            <label for="destination">Destination:</label>
                            <input type="number" id="destination" name="destination" required placeholder="User ID. e.g : 2">
                        </div>
                        <div class="input-group">
                            <button type="submit" class="btn-login">Transfer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <table style="width: 100%; border-collapse: collapse;font-size: 12px;">
                <thead style="background-color: #343a40; color: #fff;">
                    <tr>
                        <th style="padding: 10px;">No.</th>
                        <th style="padding: 10px;">Transaction ID</th>
                        <th style="padding: 10px;">Date</th>
                        <th style="padding: 10px;" colspan="3">Amount</th>
                        <th style="padding: 10px;">Type</th>
                        <th style="padding: 10px;">Destination</th>
                        <th style="padding: 10px;">Description</th>
                    </tr>
                    <tr>
                        <th style="padding: 10px;"></th>
                        <th style="padding: 10px;"></th>
                        <th style="padding: 10px;"></th>
                        <th style="padding: 10px;">Credit</th>
                        <th style="padding: 10px;">Debit</th>
                        <th style="padding: 10px;">Balance</th>
                        <th style="padding: 10px;"></th>
                        <th style="padding: 10px;"></th>
                        <th style="padding: 10px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($history) == 0) : ?>
                        <tr>
                            <td colspan="9" style="border: 1px solid #dee2e6; padding: 10px; text-align:center;">No data</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($history as $item => $value) : ?>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:center;"><?= $item + 1 ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:center;"><?= $value['trx_id'] ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:center;"><?= formatDate($value['created_at']) ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:right"><?= in_array($value['trx_type'], ['deposit', 'credit']) ? 'IDR ' . currencyFormat($value['amount']) : '-' ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:right"><?= in_array($value['trx_type'], ['withdrawal', 'transfer']) ? 'IDR ' . currencyFormat($value['amount']) : '-' ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:right">IDR <?= currencyFormat($value['balance']) ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:center;"><?= $value['trx_type'] ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:center;"><?= ($value['trx_type'] == 'transfer' ? 'user id: ' . $value['destination'] : '-') ?></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px; text-align:center;"><?= $value['description'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </section>
</body>

</html>