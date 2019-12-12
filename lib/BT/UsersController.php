<?php


namespace BT;


/**
 * controller for the users page users.php
 * Utilized by post/users.php
 */
class UsersController extends Controller {
    /**
     * UsersController constructor.
     * @param Site $site Site object
     * @param User $user Current user
     * @param array $post $_POST
     */
    public function __construct(Site $site, User $user, array $post) {
        parent::__construct($site);
        $root = $site->getRoot();
        $this->redirect = "$root/user.php";
    }
}