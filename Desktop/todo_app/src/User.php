<?php

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = DB::connect();
    }

    public function save_user($chatId, $action) {
        $check = $this->pdo->query("SELECT * FROM users WHERE user_id = {$chatId}")->fetch();
        if (!$check) {
            $stmt = $this->pdo->prepare('INSERT INTO users (user_id, action) VALUES(:user_id, :action)');
            $stmt->execute([
                ':user_id' => $chatId,
                ':action' => $action
            ]);
        }
    }

    public function setAction($chatId, $action) {
        $stmt = $this->pdo->prepare("UPDATE users SET action = :action WHERE user_id = :user_id");
        $stmt->execute([
            ':action' => $action,
            ':user_id' => $chatId
        ]);
    }
}
?>