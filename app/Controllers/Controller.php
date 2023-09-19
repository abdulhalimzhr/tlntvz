<?php

require_once __DIR__ . '/../Core/Request.php';

class Controller
{
    protected $model;
    protected $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function index()
    {
        return require_once './views/index.php';
    }

    public function validate($params, $rules)
    {
        $errors = [];

        foreach ($rules as $key => $rule) {
            $value = $params[$key];

            if (isset($rule['required']) && $rule['required'] && empty($value)) {
                $errors[$key] = 'Field is required';
            }

            if (isset($rule['min']) && strlen($value) < $rule['min']) {
                $errors[$key] = 'Field must be at least ' . $rule['min'] . ' characters';
            }

            if (isset($rule['max']) && strlen($value) > $rule['max']) {
                $errors[$key] = 'Field must be at most ' . $rule['max'] . ' characters';
            }

            if (isset($rule['match']) && $value !== $params[$rule['match']]) {
                $errors[$key] = 'Field must match ' . $rule['match'];
            }

            if (isset($rule['unique']) && $this->model->exists($key, $value)) {
                $errors[$key] = 'Field must be unique';
            }

            if (isset($rule['number']) && !is_numeric($value)) {
                $errors[$key] = 'Field must be a number';
            }
        }

        return $errors;
    }
}
