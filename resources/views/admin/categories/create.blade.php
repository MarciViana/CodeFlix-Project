@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Nova Categoria</h3>
            <?php $icon = Icon::create('floppy-disk'); ?>
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
