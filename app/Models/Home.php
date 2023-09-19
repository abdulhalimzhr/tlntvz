<?php

class Home
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    /**
     * @param array $data
     * 
     * @return bool
     */
    public function deposit(array $data): float
    {
        try {
            $current = $this->getFinalBalance($data);

            $sql = "INSERT INTO balances (amount, user_id, trx_type, description, balance) VALUES (:amount, :user_id, :trx_type, :description, :balance)";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':amount'      => $data['amount'],
                ':user_id'     => $data['user_id'],
                ':trx_type'    => 'deposit',
                ':description' => 'Deposit money',
                ':balance'     => $current
            ]);

            $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->getCurrentBalance($data['user_id']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param array $data
     * 
     * @return float
     */
    public function withdraw(array $data): float
    {
        try {
            $current = $this->getFinalBalance($data, 'debit');

            $sql = "INSERT INTO balances (amount, user_id, trx_type, description, balance) VALUES (:amount, :user_id, :trx_type, :description, :balance)";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':amount'      => $data['amount'],
                ':user_id'     => $data['user_id'],
                ':trx_type'    => 'withdrawal',
                ':description' => 'Withdraw money',
                ':balance'     => $current
            ]);

            $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->getCurrentBalance($data['user_id']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param array $data
     * 
     * @return bool
     */
    public function transfer(array $data): float
    {
        try {
            $checkDestinationUser = $this->getUsernameById($data['destination']);
            if (!$checkDestinationUser) {
                $_SESSION['errors'] = ['Destination user not found!'];
                header('Location: /dashboard');
                exit;
            }

            $current = $this->getFinalBalance($data, 'debit');

            $sql = "INSERT INTO balances (amount, user_id, trx_type , destination, description, balance) VALUES (:amount, :user_id, :trx_type, :destination, :description, :balance)";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':amount'      => $data['amount'],
                ':user_id'     => $data['user_id'],
                ':trx_type'    => 'transfer',
                ':destination' => $data['destination'],
                ':description' => 'Transfer to user ' . $this->getUsernameById($data['destination']),
                ':balance'     => $current
            ]);

            $stmt->fetch(PDO::FETCH_ASSOC);

            $this->sendMoney($data);

            return $this->getCurrentBalance($data['user_id']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param int $userId
     * 
     * @return array
     */
    public function getHistory(int $userId): array
    {
        try {
            $sql = "SELECT * FROM balances WHERE user_id = :user_id ORDER BY id DESC";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':user_id' => $userId
            ]);

            $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $history;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param int $user_id
     * 
     * @return float
     */
    public function getCurrentBalance(int $user_id): float
    {
        try {
            $sql = "SELECT balance FROM balances WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':user_id' => $user_id
            ]);

            $balance = $stmt->fetch(PDO::FETCH_ASSOC);

            return $balance['balance'] ?? 0;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param int $id
     * 
     * @return string|null
     */
    public function getUsernameById($id): ?string
    {
        try {
            $sql = "SELECT username FROM users WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':id' => $id
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? $user['username'] : null;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param mixed $data
     * 
     * @return void
     */
    private function sendMoney($data)
    {
        try {
            $current = $this->getFinalBalance($data, false);

            $sql = "INSERT INTO balances (amount, user_id, trx_type, description, balance) VALUES (:amount, :user_id, :trx_type, :description, :balance)";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':amount'      => $data['amount'],
                ':user_id'     => $data['destination'],
                ':trx_type'    => 'credit',
                ':description' => 'Transfer from user ' . $_SESSION['user']['username'],
                ':balance'     => $current
            ]);

            $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getFinalBalance($data, $type = 'credit', $isCurrentUser = true)
    {
        $current = $this->getCurrentBalance($isCurrentUser ? $data['user_id'] : $data['destination']);

        if ($type === 'debit') {
            return $current - $data['amount'];
        }

        return $current + $data['amount'];
    }
}
