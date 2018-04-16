<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class UserSettingsForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('password', 'password',[
                'rules' => 'required|min:8|max:16|confirmed'
            ])
            ->add('password_confirmation', 'password');
    }
}
