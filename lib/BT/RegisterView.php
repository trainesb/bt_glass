<?php


namespace BT;


class RegisterView extends View {

    public function __construct(Site $site) {
        parent::__construct($site);
    }

    public function presentForm() {
        $html = <<<HTML
<form id="register" method="post" action="post/register.php">
    <fieldset>
        <legend>Register</legend>

        <p><label for="username">Username *</label><br>
        <input type="text" id="username" name="username" placeholder="username" minlength="8" maxlength="20" required></p>

        <p><label for="password">Password *</label><br>
        <input type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="20" autocomplete="Password" required></p>

        <p><label for="password-valid">Re-Enter Password *</label><br>
        <input type="password" id="password-valid" name="password-valid" minlength="8" maxlength="20" placeholder="Re-Enter Password" autocomplete="Password" required></p>


        <p><label for="email">Email *</label><br>
        <input type="email" id="email" name="email" placeholder="Email" autocomplete="Email" required></p>

        <p><input type="submit" value="Register"></p>

        <p><a href="./">BT Glass Home</a></p>
        <p><a href="./login.php">Login</a></p>
    </fieldset>
    
    <div class="message"></div>
</form>
HTML;
        return $html;

    }

}