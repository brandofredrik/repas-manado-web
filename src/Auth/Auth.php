<?php

namespace App\Auth;

use App\Models\User;

class Auth
{

    public function user()
    {
        return User::find($_SESSION['user']);
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password)
    {
        $user =  User::where('email', $email)->first();

        if (!$user) {

        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}