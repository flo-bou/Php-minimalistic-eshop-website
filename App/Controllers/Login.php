<?php

namespace App\Controllers;

// use PDO;
use \Core\View;
use \App\Models\User;
// use \App\Controllers\Profile;

class Login extends \Core\Controller {

// test if connected.
// if yes send certain values to renderTemplate, if no send other values


    public function loginAction(){
        View::renderTemplate('Login/index.php', 
        [
            'sendForm' => "loging"

            // 'sendForm' => '$this->$log()'
            // 'sendForm' => self::log()
            // 'sendForm' => "login/log"
            // 'sendForm' => "parent::log"
            // 'passwordError' => $data['passwordError'],
            // 'usernameError' => $data['usernameError']
        ]
        );
    }

    // link to form
    // link to db

    // search user
    // public function logme(){
    //     User::loginToDb2();
    //     View::renderTemplate('Profile/index.php');
    // }

    public function log2(){
        // if (isset($_POST['hidden'])) {
        //     $username = $_POST['username'];
        //     $password = $_POST['password'];
        //     $connection = Model::getDb();
        //     $query = $connection->prepare("SELECT * FROM users WHERE username=:username"); // :username
        //     $query->bindParam("username", $username, PDO::PARAM_STR);
        //     $query->execute();
        //     $result = $query->fetch(PDO::FETCH_ASSOC);
        //     if (!$result) {
        //         echo '<p class="error">Connection to database failed.</p>';
        //     } else {
        //         if (password_verify($password, $result['password'])) {
        //             $_SESSION['user_id'] = $result['id'];
        //             echo '<p class="success">Congratulations, you are logged in!</p>';
        //         } else {
        //             echo '<p class="error">Username password combination is wrong!</p>';
        //         }
        //     }
        // }

        // View::renderTemplate('Profile/index.php');
    }

    // Get the PDO database connection
    // protected static function getDb(){

    // return $db

    // send to Profile page

    // send to profile if connection succeed, stay on login otherwise ?
    // call when sending the form (form action)


    public function log() {
        $data = [
            'title' => 'Login page',
            'username' => '',
            'password' => '',
            'usernameError' => '',
            'passwordError' => ''
        ];

        //Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => '',
            ];
            // Check if username is empty
            if (empty($data['username'])) {
                $data['usernameError'] = 'Please enter a username.';
            }

            // Check if password is empty
            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter a password.';
            }

            //Check if all errors are empty
            if (empty($data['usernameError']) && empty($data['passwordError'])) {
                $loggedInUser = User::loginToDb($data['username'], $data['password']); // USer:: (static)  or   $this->  (non-static)
                // loginToDb return user infos or false
                if (isset($loggedInUser['id'])) { //test if array ? flo
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'Password or username is incorrect. Please try again.';
                    // self::loginAction(); // success
                    // self::loginAction(); // success
                    // $this->view('users/login', $data);
                }
            }
        } else { //if method ain't POST
            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];
        }
        // always execute the following at the end of the function whatever happens
        // Profile->profileAction();
        $this->loginAction();
        // $this->loginAction();
        // $this->view('users/login', $data);
    }

    // populate $_SESSION
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['created_at'] = $user['created_at'];
        $_SESSION['location'] = $user['location'];
        $_SESSION['portrait'] = $user['portrait'];
        // header('location:' . URLROOT . '/pages/index');
    }

}