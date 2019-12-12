<?php


namespace BT;


class AdminView extends View {

    private $users;


    public function __construct(Site $site) {
        parent::__construct($site);

        $this->users = new UsersTable($site);

        $this->setTitle("Admin");
    }

    public function present() {

        echo $this->presentUsers();
    }

    public function presentUsers() {
        echo "<h1>Users</h1>";
        $users = $this->users->getAll();
        $this->presentTable($users);
    }

}