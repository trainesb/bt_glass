<?php


namespace BT;


class PasswordValidateView extends View {

    private $validator;

    public function __construct(Site $site, $get) {
        parent::__construct($site);

        $this->setTitle("BT Glass Password Entry");
        $this->validator = strip_tags($get['v']);
    }

    public function passwordForm() {
        $html = <<<HTML
<div class="password">
    <form class="password" method="post" action="post/password-validate.php">
        <input type="hidden" name="validator" value="$this->validator">
        <fieldset>
            <legend>Change Password</legend>
    
            <p><label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email" autocomplete="Email"></p>
    
            <p><label for="password">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Password" autocomplete="Password"></p>

            <p><label for="password-again">Password (again)</label><br>
            <input type="password" id="password-again" name="password" placeholder="Password" autocomplete="Password"></p>

        </fieldset>
    </form>
</div>
HTML;

    }

}