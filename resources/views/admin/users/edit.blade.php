@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Editar Usuário</h3>
            <?php $icon = Icon::create('pencil'); ?>
            <!--adiciona um botão de salvar no form -->
            {!!
                form($form->add('salvar','submit',[
                'attr' => ['class' => 'btn btn-primary btn-block'],
                'label' => $icon
                ]))
            !!} <!--essas chaves renderizam -->
        </div>
    </div>
@endsection
