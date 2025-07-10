<?php
class Authentication
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM karyawan WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $stmt->close();
                return $user['id'];
            }
        }
        $stmt->close();
        return false;
    }
}
?>