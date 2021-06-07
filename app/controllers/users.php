<?php

class users {

    public function loginForm() {
        self::redirectIfLogin();

        $error = [];
        if(request::exist('email','post')) {

            $email = request::get('email','post');
            $password = request::get('password','post');

            if($email=='')
                $error['email'] = 'Podaj adres email';
            elseif($password=='')
                $error['password'] = 'Podaj hasło';
            else {
                $user = userModel::where('email','=',$email)->first();
                if(!$user)
                    $error['email'] = 'Niepoprawny login lub hasło';
                else {
                    if(!passwords::check($user->password,$password))
                        $error['email'] = 'Niepoprawny login lub hasło';
                    else {
                        $_SESSION['user'] = $user->id;

                        $view = new views('info');
                        $view->with('info','Logowanie powiodło się');
                        return $view->render();
                    }
                }
            }
        }

        $view = new views('login_form');
        $view->with('error',$error);
        return $view->render();
    }

    public function registerForm() {
        self::redirectIfLogin();

        $error = [];

        $email = '';
        $terms = 0;
        if(request::exist('email','post')) {
            $email = clearInputString(request::get('email','post'));
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)||$email=='')
                $error['email'] = 'Podany adres email jest niepoprawny';
            elseif(userModel::where('email','=',$email)->count()>0)
                $error['email'] = 'Podany adres email istnieje w bazie';

            $password = clearInputString(request::get('password','post'));
            $confirm_password = clearInputString(request::get('confirm_password','post'));

            if($password=='')
                $error['password'] = 'Podaj hasło';
            elseif($password!=$confirm_password)
                $error['password'] = 'Podane hasła nie zgadzają się';
            elseif(strlen($password)<8)
                $error['password'] = 'Hasło musi się składać conajmniej z 8 znaków';

            request::get('terms')=='on'?$terms = 1:$terms = 0;
            if($terms==0)
                $error['terms'] = 'Zaakceptuj regulamin';

            if(!count($error)) {
                userModel::create([
                    'email'=>$email,
                    'password'=>passwords::hash($password),
                    'role'=>2
                ]);

                $view = new views('info');
                $view->with('info','Konto zostało utworzone, możesz się zalogować.');
                $view->with('button','<a class="button" href="/logowanie">Zaloguj się</a>');
                return $view->render();
            }
        }



        $view = new views('register_form');
        $view->with('email',$email);
        $view->with('terms',$terms);
        $view->with('error',$error);
        return $view->render();
    }

    public function logout() {
        if(self::check())
            unset($_SESSION['user']);

        $view = new views('info');
        $view->with('info','Wylogowano');
        return $view->render();
    }

    static public function check() {
        if(isset($_SESSION['user']))
            return true;
        else
            return false;
    }

    static public function getUser() {
        if(self::check()) {
            return userModel::find($_SESSION['user']);
        }
    }

    static public function redirectIfLogin() {
        if(self::check())
            redirect('/');
    }

    static public function redirectIfNotLogin() {
        if(!self::check())
            redirect('/logowanie');
    }

    static public function redirectIfNotAdmin() {
        if(!self::isAdmin())
            redirect('/');
    }

    static public function isAdmin() {
        if(self::check()) {
            $user = self::getUser();
            if($user&&$user->role==1)
                return true;
        }
        else
            return false;
    }

}