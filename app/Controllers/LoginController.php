<?php

require_once './Controllers/Controller.php';
require_once './Models/Login.php';

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Login();
    }

    public function login()
    {
        try {
            $username = $this->request->post('username');
            $password = $this->request->post('password');

            $user = $this->model->login($username, $password);

            if ($user) {
                unset($_SESSION['errors']);
                $_SESSION['user'] = $user;
                header('Location: /dashboard');
            } else {
                $_SESSION['errors'] = [
                    'cred' => 'Username or password is incorrect'
                ];

                header('Location: /login');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function register()
    {
        try {

            $username = $this->request->post('username');
            $password = $this->request->post('password');

            $isExist = $this->model->exists($username);

            if ($isExist) {
                $_SESSION['errors'] = [
                    'cred' => 'Username already exists'
                ];

                header('Location: /login');
                exit;
            }

            $this->model->register($username, $password);

            unset($_SESSION['errors']);
            header('Location: /login');
            exit;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function logout()
    {
        ob_start();
        session_start();
        session_unset();
        session_regenerate_id(true);
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');

        header('Location: /login');
    }

    public function registerIndex()
    {
        return require_once './views/pages/auth/register.php';
    }

    public function index()
    {
        return require_once './views/pages/auth/login.php';
    }
}
