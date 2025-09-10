<?php

class UsersInformation
{
    public $id;
    public $username;
    public $email;
    public $rol;

    function users() {}

    function valueSet($user)
    {
        foreach ($user as $value) {
            if (!empty($val7ue['id']) || !empty($value['username']) || !empty($value['email']) || !empty($value['rol'])) {
                $this->id = $value['id'];
                $this->username = $value['username'];
                $this->email = $value['email'];
                $this->rol = $value['rol'];
            } else {
                throw new InvalidArgumentException("Los datos de usuario se encuentran incompletos.");
            }
        }
    }

    function valueGet()
    {
        $user = [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'rol' => $this->rol
        ];
        return $user;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getRol() {
        return $this->rol;
    }
}
