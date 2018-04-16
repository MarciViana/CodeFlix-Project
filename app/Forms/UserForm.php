<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        //required: o campo é obrigatório
        //unique: não pode ter igual a um ja cadastrado, escreve a tabela e o campo que quer olhar
        $id = $this->getData('id'); //pega o usuário no momento
        $this
            ->add('name', 'text', [
                'label' => 'Nome',
                'rules' => 'required|max:255'
            ])
            ->add('email', 'email', [
                'label' => 'E-mail',
                'rules' => "required|max:255|unique:users,email,$id" //passa o id para deixar alterar se for o msm usuário corrente
            ]);
    }
}
