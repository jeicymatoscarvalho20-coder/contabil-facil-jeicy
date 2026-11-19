<?php
final class Usuario {
    public static function findByEmail(string $email): ?array {
        $s = Database::connection()->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $s->execute(['email' => $email]);
        return $s->fetch() ?: null;
    }
}
