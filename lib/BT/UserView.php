<?php


namespace BT;


/**
 * view class for the users page users.php
 */
class UserView extends View {

    /**
     * Constructor
     * Sets the page title and any other settings.
     * @param Site $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site);

        $this->setTitle("User");
    }

    /**
     * Present the users form
     * @return string HTML
     */
    public function present() {
        $user = $this->getUser();
        $name = $user->getName();
        $email = $user->getEmail();
        $phone = $user->getPhone();
        $address = $user->getAddress();
        $notes = $user->getNotes();
        $joined = $user->getJoined();
        $role = $user->getRole();

        $html = <<<HTML
<div class="user-wrapper">
    <h1>$name</h1>
    <h3>Email: $email</h3>
    <h3>Phone: $phone</h3>
    <h3>Address: $address</h3>
    <h3>Notes: $notes</h3>
    <h3>Joined: $joined</h3>
    <h3>Role: $role</h3>
</div>
HTML;

        return $html;
    }
}