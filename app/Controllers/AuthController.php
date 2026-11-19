<?php
final class AuthController {
    public function form(): void {
        if (!empty($_SESSION['user_id'])) redirect('/');
        render('auth/login',['title'=>'Entrar']);
    }
    public function login(): void {
        verify_csrf();
        $email=filter_var(trim($_POST['email'] ?? ''),FILTER_VALIDATE_EMAIL);
        $senha=$_POST['senha'] ?? '';
        $errors=[];
        if (!$email) $errors['email']='Informe um e-mail válido.';
        if ($senha==='') $errors['senha']='Informe sua senha.';
        $user=$email ? Usuario::findByEmail($email) : null;
        if (!$errors && (!$user || !password_verify($senha,$user['senha']))) $errors['geral']='E-mail ou senha incorretos.';
        if ($errors) { render('auth/login',['title'=>'Entrar','errors'=>$errors,'old'=>$_POST]); return; }
        session_regenerate_id(true);
        $_SESSION['user_id']=$user['id']; $_SESSION['user_name']=$user['nome'];
        redirect('/');
    }
    public function logout(): void {
        verify_csrf(); $_SESSION=[]; session_destroy(); redirect('/login');
    }
}
