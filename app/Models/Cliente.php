<?php

final class Cliente {

    public static function all(string $q, int $limit, int $offset): array {

        $sql = "SELECT c.*,
                (SELECT COUNT(*) FROM obrigacoes o
                 WHERE o.cliente_id = c.id) AS total_obrigacoes
                FROM clientes c
                WHERE (
                    ? = ''
                    OR c.nome LIKE ?
                    OR c.cnpj LIKE ?
                    OR c.email LIKE ?
                )
                ORDER BY c.nome
                LIMIT ? OFFSET ?";

        $s = Database::connection()->prepare($sql);

        $like = "%$q%";

        $s->bindValue(1, $q);
        $s->bindValue(2, $like);
        $s->bindValue(3, $like);
        $s->bindValue(4, $like);
        $s->bindValue(5, $limit, PDO::PARAM_INT);
        $s->bindValue(6, $offset, PDO::PARAM_INT);

        $s->execute();

        return $s->fetchAll();
    }

    public static function count(string $q): int {

        $sql = "SELECT COUNT(*)
                FROM clientes
                WHERE (
                    ? = ''
                    OR nome LIKE ?
                    OR cnpj LIKE ?
                    OR email LIKE ?
                )";

        $s = Database::connection()->prepare($sql);

        $like = "%$q%";

        $s->execute([
            $q,
            $like,
            $like,
            $like
        ]);

        return (int) $s->fetchColumn();
    }

    public static function find(int $id): ?array {

        $s = Database::connection()->prepare(
            'SELECT * FROM clientes WHERE id = ?'
        );

        $s->execute([$id]);

        return $s->fetch() ?: null;
    }

    public static function save(array $d, ?int $id = null): void {

        if ($id) {

            $s = Database::connection()->prepare(
                'UPDATE clientes
                 SET nome = ?, cnpj = ?, email = ?, telefone = ?, responsavel = ?
                 WHERE id = ?'
            );

            $s->execute([
                $d['nome'],
                $d['cnpj'],
                $d['email'],
                $d['telefone'],
                $d['responsavel'],
                $id
            ]);

        } else {

            $s = Database::connection()->prepare(
                'INSERT INTO clientes
                (nome, cnpj, email, telefone, responsavel)
                VALUES (?, ?, ?, ?, ?)'
            );

            $s->execute([
                $d['nome'],
                $d['cnpj'],
                $d['email'],
                $d['telefone'],
                $d['responsavel']
            ]);
        }
    }

    public static function delete(int $id): void {

        $s = Database::connection()->prepare(
            'DELETE FROM clientes WHERE id = ?'
        );

        $s->execute([$id]);
    }
}