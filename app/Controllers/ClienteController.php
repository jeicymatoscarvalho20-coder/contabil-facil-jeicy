<?php
final class ClienteController {
    public function index(): void {
        auth_required(); $q=trim($_GET['q']??''); $page=max(1,(int)($_GET['page']??1)); $per=8;
        render('clientes/index',['title'=>'Clientes','items'=>Cliente::all($q,$per,($page-1)*$per),'q'=>$q,'page'=>$page,'pages'=>max(1,(int)ceil(Cliente::count($q)/$per))]);
    }
    public function create(): void { auth_required(); render('clientes/form',['title'=>'Novo cliente','item'=>[],'errors'=>[]]); }
    public function store(): void { auth_required(); verify_csrf(); $d=$this->validate($_POST); if($d['errors']){render('clientes/form',['title'=>'Novo cliente','item'=>$_POST,'errors'=>$d['errors']]);return;} Cliente::save($d['data']); redirect('/clientes'); }
    public function edit(): void { auth_required(); $item=Cliente::find((int)($_GET['id']??0)); if(!$item) redirect('/clientes'); render('clientes/form',['title'=>'Editar cliente','item'=>$item,'errors'=>[]]); }
    public function update(): void { auth_required(); verify_csrf(); $id=(int)($_POST['id']??0); $d=$this->validate($_POST); if($d['errors']){render('clientes/form',['title'=>'Editar cliente','item'=>$_POST,'errors'=>$d['errors']]);return;} Cliente::save($d['data'],$id); redirect('/clientes'); }
    public function delete(): void { auth_required(); verify_csrf(); Cliente::delete((int)($_POST['id']??0)); redirect('/clientes'); }
    private function validate(array $p): array {
        $data=[];$errors=[];
        $data['nome']=trim($p['nome']??''); $data['cnpj']=trim($p['cnpj']??''); $data['email']=trim($p['email']??'');
        $data['telefone']=trim($p['telefone']??''); $data['responsavel']=trim($p['responsavel']??'');
        if($data['nome']==='')$errors['nome']='Informe o nome do cliente.';
        if($data['cnpj']==='')$errors['cnpj']='Informe o CNPJ ou CPF.';
        if($data['email']!=='' && !filter_var($data['email'],FILTER_VALIDATE_EMAIL))$errors['email']='Informe um e-mail válido.';
        return ['data'=>$data,'errors'=>$errors];
    }
}
