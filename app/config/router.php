<?php

Router::get('/login', 'LoginController', 'index');
Router::post('/login', 'LoginController', 'login');

Router::get('/register', 'LoginController', 'registerIndex');
Router::post('/register', 'LoginController', 'register');

Router::get('/logout', 'LoginController', 'logout', 'AuthMiddleware');

Router::get('/', 'HomeController', 'index', 'AuthMiddleware');
Router::get('/dashboard', 'HomeController', 'dashboard', 'AuthMiddleware');
Router::post('/deposit', 'HomeController', 'deposit', 'AuthMiddleware');
Router::post('/withdraw', 'HomeController', 'withdraw', 'AuthMiddleware');
Router::post('/transfer', 'HomeController', 'transfer', 'AuthMiddleware');
Router::post('/dismiss-alert', 'HomeController', 'dismissAlert', 'AuthMiddleware');
