<?php

declare(strict_types=1);

class User
{

    public function register()
    {
        if ($this->isUserExists()) {
            echo 'User already exists';
            return;
        }
        $user =  $this->create();
        $_SESSION['user'] = $user['email'];
        header("location: /");
    }

    public function isUserExists() : bool
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email    = $_POST['email'];
            $password = $_POST['password'];

            $db   = DB::connect();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return (bool)$stmt->fetch();
        }
        return false;
    }
    public function create()
{
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email    = $_POST['email'];
        $password = $_POST['password'];

        $db   = DB::connect();
        $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Fetch the newly created user
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

public function signIn()
{
    if (isset($_POST['signEmail'])) {
        $signEmail = $_POST['signEmail'];
        
        $db = DB::connect();
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $signEmail);
        $stmt->execute();
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            header("Location: /");
        } else {
            echo "Invalid email or password";
        }
    }
}

}
