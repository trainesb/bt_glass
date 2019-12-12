<?php


namespace BT;

/**
 * controller class for the Login page
 */
class LoginController extends Controller {

    public function __construct(Site $site, array &$session, array $post) {
        parent::__construct($site);

        $users = new UsersTable($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);


        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        if($user === null) {
            // Login failed
            if(!$users->exists($email)) {
                $this->result = json_encode(['ok' => false, 'message' => 'Invalid Email']);
            } else {
                $this->result = json_encode(['ok' => false, 'message' => 'Invalid Password']);
            }
        } else {
            if($user->isStaff()) {
                $this->result = json_encode(['ok' => true, 'staff' => true]);
            } else {
                $this->result = json_encode(['ok' => true, 'staff' => false]);
            }
        }

        if(isset($post['keep'])) {
            $cookies = new CookieTable($site);
            $token = $cookies->create($user);
            $expire = time() + (86400 * 365); // 86400 = 1 day
            $user_id = $user->getId();
            $cookie = array("user" => $user_id, "token" => $token);
            setcookie(LOGIN_COOKIE, json_encode($cookie), $expire, "/");
        }

    }

}