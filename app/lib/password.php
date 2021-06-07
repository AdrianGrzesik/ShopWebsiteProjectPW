<?php

class passwords {

    static public function hash(string $password):string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    static public function check(string $hash, string $password):bool {
        if(password_verify($password, $hash))
            return true;
        else
            return false;
    }

}