<?php

require_once './Models/Home.php';

class Login
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    /**
     * @param mixed $username
     * @param mixed $password
     * 
     * @return array
     */
    public function login($username, $password): array|bool
    {
        try {
            $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':username' => $username,
                ':password' => $password
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $user['balance'] = (new Home())->getCurrentBalance($user['id']);
            }

            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param mixed $username
     * @param mixed $password
     * 
     * @return array|bool
     */
    public function register($username, $password): array|bool
    {
        try {

            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':username' => $username,
                ':password' => $password
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param string $field
     * @param mixed $value
     * 
     * @return bool
     */
    public function exists($username): bool
    {
        try {
            $sql = "SELECT id FROM users WHERE username = :value LIMIT 1";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':value' => $username
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? true : false;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
