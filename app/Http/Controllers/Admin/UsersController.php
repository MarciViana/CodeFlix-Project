<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\UserForm;
use CodeFlix\Models\User;
use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Form;

class UsersController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //mostra usuários
    {
        $users = $this->repository->paginate(); //usa paginação, sem nenhum param, a paginação tem no max 15 elementos
        return view('admin.users.index', compact('users'));
        //compact acessa todas as variaveis de users, seria o mesmo de ['users' => $users]

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//mostra formulário de criação de usuários
    {
        $form = \FormBuilder::create(UserForm::class,[
            'url' => route('admin.users.store'),
            'method' => 'POST'
        ]); //classe de formulario, url de ação do formulario e método http

        return view('admin.users.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //cria usuário no bd
    {
        //captura as informações vindas da requisição POST e faz o cadastro no bd
        //cria a instancia do formulário
        /** @var Form $form */
        $form = \FormBuilder::create(UserForm::class);
        //valida o formulario
        if(!$form->isValid()){
            //redirecionar para a pagina de criação de usuários (pagina anterior)
            //quer retornar com os erros e os campos incorretos
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        //se for valido, realiza o cadastro
        //pega informações do formulário
        $data = $form->getFieldValues(); //name e email
        $this->repository->create($data);

        //flash message criada
        $request->session()->flash('message','Usuário criado com sucesso!');

        return redirect()->route('admin.users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) //mostra um usuário
    {
        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) //mostra formulário de edição de um usuário
    {
        $form = \FormBuilder::create(UserForm::class,[
            'url' => route('admin.users.update', ['user' => $user->id]),
            'method' => 'PUT',
            'model' => $user
        ]); //classe de formulario, url de ação do formulario e método http

        return view('admin.users.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //fazer edição no bd
    {
        //captura as informações vindas da requisição POST e faz o cadastro no bd
        //cria a instancia do formulário
        /** @var Form $form */
        $form = \FormBuilder::create(UserForm::class, [
            'data' => ['id' => $id]
        ]);
        //valida o formulario
        if(!$form->isValid()){
            //redirecionar para a pagina de criação de usuários (pagina anterior)
            //quer retornar com os erros e os campos incorretos
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        //se for valido, realiza o cadastro
        //pega informações do formulário
        $data = array_except($form->getFieldValues(), ['password','role']); //name e email, password e role
        $this->repository->update($data,$id);
        //flash message criada
        $request->session()->flash('message','Usuário alterado com sucesso!');

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id) //excluir usuário
    {
        //deleta o usuário e redireciona para a tela de usuários
        $this->repository->delete($id);
        //flash message criada
        $request->session()->flash('message','Usuário excluído com sucesso!');
        return redirect()->route('admin.users.index');
    }
}
