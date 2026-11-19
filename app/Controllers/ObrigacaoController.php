<?php
final class ObrigacaoController {
    public function index(): void {
        auth_required(); $q=trim($_GET['q']??''); $status=$_GET['status']??''; $page=max(1,(int)($_GET['page']??1)); $per=8;
        render('obrigacoes/index',['title'=>'Obrigações fiscais','items'=>Obrigacao::all($q,$status,$per,($page-1)*$per),'q'=>$q,'status'=>$status,'page'=>$page,'pages'=>max(1,(int)ceil(Obrigacao::count($q,$status)/$per))]);
    }
    public function create(): void { auth_required(); render('obrigacoes/form',['title'=>'Nova obrigação','item'=>['status'=>'Pendente'],'clients'=>$this->clients(),'errors'=>[]]); }
    public function store(): void { auth_required(); verify_csrf(); $d=$this->validate($_POST); if($d['errors']){render('obrigacoes/form',['title'=>'Nova obrigação','item'=>$_POST,'clients'=>$this->clients(),'errors'=>$d['errors']]);return;} Obrigacao::save($d['data']); redirect('/obrigacoes'); }
    public function edit(): void { auth_required(); $item=Obrigacao::find((int)($_GET['id']??0)); if(!$item) redirect('/obrigacoes'); render('obrigacoes/form',['title'=>'Editar obrigação','item'=>$item,'clients'=>$this->clients(),'errors'=>[]]); }
    public function update(): void { auth_required(); verify_csrf(); $id=(int)($_POST['id']??0); $d=$this->validate($_POST); if($d['errors']){render('obrigacoes/form',['title'=>'Editar obrigação','item'=>$_POST,'clients'=>$this->clients(),'errors'=>$d['errors']]);return;} Obrigacao::save($d['data'],$id); redirect('/obrigacoes'); }
    public function delete(): void { auth_required(); verify_csrf(); Obrigacao::delete((int)($_POST['id']??0)); redirect('/obrigacoes'); }
    private function clients(): array { return Database::connection()->query('SELECT id,nome FROM clientes ORDER BY nome')->fetchAll(); }
    private function validate(array $p): array {
        $d=['cliente_id'=>(int)($p['cliente_id']??0),'titulo'=>trim($p['titulo']??''),'descricao'=>trim($p['descricao']??''),'vencimento'=>$p['vencimento']??'','status'=>$p['status']??'Pendente']; $e=[];
        if($d['cliente_id']<1)$e['cliente_id']='Selecione um cliente.';
        if($d['titulo']==='')$e['titulo']='Informe o nome da obrigação.';
        $date=DateTime::createFromFormat('Y-m-d',$d['vencimento']);
        if(!$date || $date->format('Y-m-d')!==$d['vencimento'])$e['vencimento']='Informe uma data válida.';
        if(!in_array($d['status'],['Pendente','Em andamento','Concluída'],true))$e['status']='Selecione uma situação válida.';
        return ['data'=>$d,'errors'=>$e];
    }
}
