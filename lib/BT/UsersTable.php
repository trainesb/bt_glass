<?php


namespace BT;


/**
 * Manage users in our system.
 */
class UsersTable extends Table {

    private $email;
    private $hash;
    private $password;
    private $salt;

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "user");
    }

    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @return User object if successful, null otherwise.
     */
    public function login($email, $password) {

        if(!$this->exists($email)) {
            return null;
        }

        $this->email = $email;
        $this->password = $password;

        // Get the encrypted password and salt from the record
        $row = $this->getByEmail();

        $this->salt = $row['salt'];
        $this->hash = $this->hash_pw($this->password, $this->salt);

        if($this->hash !== $row['hash']) {
            //Invalid Password
            return null;
        }

        return new User($row);
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @return User object if successful, null otherwise.
     */
    public function get($id) {
        $sql = "SELECT * FROM ".$this->tableName." WHERE id = ?";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id, ));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
    public function update(User $user) {
        $sql = 'UPDATE $this->tablename SET email=?, name=?, phone=?, address=?, notes=?, role=? WHERE id=?';
        $pdo = $this->pdo();
        try {
            $statement = $pdo->prepare($sql);
            $statement->execute(array($user->getEmail(), $user->getName(), $user->getPhone(), $user->getAddress(), $user->getNotes(), $user->getRole(), $user->getId(),));
            if ($statement->rowCount() === 0) {
                return false;
            }
        } catch(\PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @return true if $email is an existing email address
     */
    public function exists($email) {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE email=?';
        $pdo = $this->pdo();
        try {
            $statement = $pdo->prepare($sql);
            $statement->execute([$email]);
            if ($statement->rowCount() === 0) {
                return false;
            }
        } catch(\PDOException $e) {
            return false;
        }
        return true;
    }

    public function addNew($post) {
        $salt = self::randomSalt();
        $hash = $this->hash_pw($post['password'], $salt);

        // Add a record to the user table
        $sql = 'INSERT INTO '.$this->tableName.' (email, name, hash, role, salt) VALUES(?, ?, ?, ?, ?)';
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([$post['email'], $post['username'], $hash, "C", $salt]);
        if($statement->rowCount() === 0) {
            return null;
        }
    }

    /**
     * Create a new user.
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
     * @return null on success or error message if failure
     */
    public function add(User $user, Email $mailer) {

        print_r($user);

        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, phone, address, notes, joined, role)
values(?, ?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute([
            $user->getEmail(), $user->getName(), $user->getPhone(), $user->getAddress(),
            $user->getNotes(), date("Y-m-d H:i:s"), $user->getRole()
        ]);
        $id = $this->pdo()->lastInsertId();

        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);

        // Send email with the validator in it
        $link = "http://"  . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to BT Glass. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     */
    public function setPassword($userid, $password) {
        $sql = 'UPDATE $this->tableName SET password = ? WHERE id = ?';
        $pdo = $this->pdo();
        $pdo->prepare($sql);
        $pdo->execute(array($password, $userid, ));
    }

    public function getAll() {
        $sql = 'SELECT * FROM '.$this->tableName;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }

        $rtrn = [];

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            array_push($rtrn, $row);
        }

        return $rtrn;
    }

    public function getByEmail() {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE email = ?';
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$this->email]);
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        $this->hash = $row['hash'];
        $this->salt = $row['salt'];
        return $row;
    }

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @return Salt string
     */
    public static function randomSalt($len = 16) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }

    private function hash_pw($password, $salt) {
        return hash("sha256", $password . $salt);
    }


}