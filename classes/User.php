class User {
    private $conn;
    private $table = "users";  // Your table name

    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;  // Set the database connection
    }

    // Register function
    public function register() {
        $query = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_DEFAULT));  // Hash the password for storage

        return $stmt->execute();
    }

    // Login function
    public function login($email, $password) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);  // Sanitize input email

        $query = "SELECT id, name, email, password FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        // If user is found
        if ($stmt->rowCount() > 0) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if (password_verify($password, $userData['password'])) {
                return $userData;  // Return user data
            }
        }

        return null;  // Return null if login fails
    }
}
