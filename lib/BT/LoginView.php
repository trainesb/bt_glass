<?php


namespace BT;


class LoginView extends View {

    public function __construct(Site $site, &$cookie) {
        parent::__construct($site);
        $this->setTitle("Login");

        if(isset($cookie[LOGIN_COOKIE]) && $cookie[LOGIN_COOKIE] != "") {
            $cookie = json_decode($cookie[LOGIN_COOKIE], true);
            $cookies = new CookieTable($site);
            $hash = $cookies->validate($cookie['user'], $cookie['token']);

            if($hash !== null) {
                $cookies->delete($hash);
            }

            $expire = time() - 3600;
            setcookie(LOGIN_COOKIE, "", $expire, "/");
        }
    }

    public function presentLoginForm() {
        return <<<HTML
<form id="login" method="post" action="post/login.php">
    <fieldset>
        <legend>Login</legend>

        <p><label for="email">Email</label><br>
        <input type="email" id="email" name="email" minlength="8" placeholder="Email" autocomplete="Email" required></p>

        <p><label for="password">Password</label><br>
        <input type="password" id="password" name="password" minlength="8" maxlength="20" placeholder="Password" autocomplete="current-password" required></p>

        <p class="keep"><input type="checkbox" name="keep" id="keep">
		<label for="keep">Keep me logged on</label></p>

        <p><input type="submit" value="Log in"></p>
        <p><a href="">Lost Password</a></p>

        <p><a href="./">BT Glass Home</a></p>
        <p><a href="./register.php">Register</a></p>
    </fieldset>
    
    <div class="message"></div>
</form>
HTML;
    }
}