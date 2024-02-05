<?php

namespace System\Auth;

use App\User;

use System\Session\Session;

class Auth
{

    private $redirectTo = "/login";

    private function userMethod()
    {
        if (!Session::get('user')) {
            return redirect($this->redirectTo);
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            Session::remove('user');
            return redirect($this->redirectTo);
        } else {
            return $user;
        }
    }

    private function checkMethod()
    {
        if (!Session::get('user')) {
            return redirect($this->redirectTo);
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            Session::remove('user');
            return redirect($this->redirectTo);
        } else {
            return true;
        }
    }
    private function checkLoginMethod()
    {
        if (!Session::get('user')) {
            return false;
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            return false;
        } else {
            return true;
        }
    }

    private function loginByEmailMethod($email, $password)
    {
        $user = User::where('email', $email)->get();
        if (empty($user)) {
            error('login', 'no user found');
            return false;
        } else {
            if (password_verify($password, $user[0]->password) && $user[0]->is_active == 1) {
                Session::set('user', $user->id);
                return true;
            } else {
                error('login', 'password is incorrect');

                return false;
            }
        }
    }
    private function loginByIdMethod($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            error('login', 'User does not exist');
            return false;
        } else {
            Session::set('user', $user->id);
            return true;
        }
    }

    private function logoutMethod()
    {
        if (Session::get('user')) {
            Session::remove('user');
            return true;
        } else {
            return false;
        }
    }

    public function __call($name, $arguments)
    {
        return $this->methodCaller($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = new self();
        return $instance->methodCaller($name, $arguments);
    }

    private function methodCaller($method, $arguments)
    {
        $suffix = "Method";
        $methodName = $method . $suffix;
        return call_user_func_array([$this, $methodName], $arguments);
    }
}
