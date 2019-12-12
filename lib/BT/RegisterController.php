<?php


namespace BT;


class RegisterController extends Controller {

    private $username;
    private $password;
    private $password_valid;
    private $email;

    public function __construct(Site $site, &$session, $post) {
        parent::__construct($site);

        $users = new UsersTable($site);

        $this->username = $post['username'];
        $this->password = $post['password'];
        $this->password_valid = $post['password-valid'];
        $this->email = $post['email'];

        if($users->exists($this->email)) {
            $this->result = json_encode(["ok" => false, "message" => "Email exists"]);
        } else {
            if($this->validate()) {
                $users->addNew($post);
            }
        }
    }

    public function validate() {
        if($this->validatePassword()) {
            return true;
        } else {
            return false;
        }
    }

    public function validatePassword() {
        if($this->password != $this->password_valid) {
            $this->result = json_encode(["ok" => false, "message" => "Password"]);
        } else {
            return true;
        }
    }

}