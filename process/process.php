<?php


class process
{
    private $conn;
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;

    public $title;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = 'INSERT INTO users SET email = :email, password = :password';

        $stmt = $this->conn->prepare($query);


        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $encrypt = password_hash($this->password, PASSWORD_ARGON2I);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $encrypt);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s\n", $stmt->error);
        return false;
    }

    public function checkEmail()
    {
        $query = 'SELECT email FROM users WHERE email = ? LIMIT 0,1';
        $em = $this->conn->prepare($query);
        $em->bindParam(1, $this->email);
        if ($em->execute()) {
            $row = $em->fetch(PDO::FETCH_ASSOC);
            $this->email = $row['email'];
        }
    }

}