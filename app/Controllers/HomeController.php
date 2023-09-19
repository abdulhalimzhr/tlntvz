<?php

require_once './Controllers/Controller.php';
require_once './Models/Home.php';

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Home();
    }

    /**
     * @return void
     */
    public function deposit()
    {
        try {
            $params = [
                'amount' => $this->request->post('amount'),
                'user_id' => $_SESSION['user']['id'],
            ];

            $validate = $this->validate($params, [
                'amount' => [
                    'required' => true,
                    'min' => 1,
                    'number' => true,
                ]
            ]);

            if (count($validate) > 0) {
                $_SESSION['errors'] = $validate;

                header('Location: /dashboard');
                exit;
            }

            $this->setBalance($this->model->deposit($params));

            header('Location: /dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @return void
     */
    public function withdraw()
    {
        try {
            $this->checkBalance();

            $params = [
                'amount' => $this->request->post('amount'),
                'user_id' => $_SESSION['user']['id'],
            ];

            $validate = $this->validate($params, [
                'amount' => [
                    'required' => true,
                    'min' => 1,
                    'number' => true,
                ]
            ]);

            if (count($validate) > 0) {
                $_SESSION['errors'] = $validate;

                header('Location: /dashboard');
                exit;
            }

            $this->setBalance($this->model->withdraw($params));

            header('Location: /dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @return void
     */
    public function transfer()
    {
        try {
            $this->checkBalance();

            $params = [
                'amount' => $this->request->post('amount'),
                'user_id' => $_SESSION['user']['id'],
                'destination' => $this->request->post('destination'),
            ];

            $validate = $this->validate($params, [
                'amount' => [
                    'required' => true,
                    'min' => 1,
                    'number' => true,
                ],
                'destination' => [
                    'required' => true,
                ]
            ]);

            if (count($validate) > 0) {
                $_SESSION['errors'] = $validate;

                header('Location: /dashboard');
                exit;
            }

            if ($_SESSION['user']['id'] == $params['destination']) {
                $_SESSION['errors'] = [
                    'destination' => 'You cannot transfer to yourself!'
                ];

                header('Location: /dashboard');
                exit;
            }

            $this->setBalance($this->model->transfer($params));

            header('Location: /dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function dashboard()
    {
        $history = $this->model->getHistory($_SESSION['user']['id']);

        return require_once './views/pages/home/dashboard.php';
    }

    public function dismissAlert()
    {
        unset($_SESSION['errors']);
        header('Location: /dashboard');
    }

    public function index()
    {
        return require_once './views/pages/index.php';
    }

    private function checkBalance()
    {
        if ($_SESSION['user']['balance'] < $this->request->post('amount')) {

            $_SESSION['errors'] = [
                'balance' => 'Insufficient balance!'
            ];

            header('Location: /dashboard');
            exit;
        }
    }


    /**
     * @param mixed $balance
     * 
     * @return void
     */
    private function setBalance($balance)
    {
        if ($balance) {
            unset($_SESSION['errors']);
            $_SESSION['user']['balance'] = $balance;
        }
    }
}
