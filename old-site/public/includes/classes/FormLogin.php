<?php

use libAllure\ElementInput;
use libAllure\ElementPassword;
use libAllure\Form;

class FormLogin extends Form
{
    public function __construct()
    {
        parent::__construct('formLogin', 'Login to your account');

        $this->addElement(new ElementInput('username', 'Username'));
        $this->addElement(new ElementPassword('password', 'Password'));

        $this->addDefaultButtons('Login');
    }

    public function process() {}
}
