<?php
final class AvaliacaoController {
    public function form(): void { auth_required(); render('avaliacao/form',['title'=>'Avaliar o sistema']); }
    public function store(): void {
        auth_required(); verify_csrf(); $nota=(int)($_POST['nota']??0); $comentario=trim($_POST['comentario']??'');
        if($nota<1||$nota>5){render('avaliacao/form',['title'=>'Avaliar o sistema','error'=>'Escolha uma nota de 1 a 5.']);return;}
        $s=Database::connection()->prepare('INSERT INTO avaliacoes(usuario_id,nota,comentario) VALUES(?,?,?)');
        $s->execute([$_SESSION['user_id'],$nota,$comentario]); render('avaliacao/form',['title'=>'Avaliar o sistema','success'=>'Obrigado! Sua avaliação foi registrada.']);
    }
}
