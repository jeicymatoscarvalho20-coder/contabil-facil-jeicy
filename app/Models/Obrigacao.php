<?php

final class Obrigacao {

    public static function all(string $q, string $status, int $limit, int $offset): array {

        $sql = "SELECT o.*, c.nome AS cliente_nome
                FROM obrigacoes o
                JOIN clientes c ON c.id = o.cliente_id
                WHERE (
                    :q = ''
                    OR o.titulo LIKE :titulo
                    OR c.nome LIKE :cliente
                )
                AND (
                    :status_vazio = ''
                    OR o.status = :status_valor
                )
                ORDER BY o.vencimento ASC
                LIMIT :lim OFFSET :off";

        $s = Database::connection()->prepare($sql);

        $s->bindValue(':q', $q);
        $s->bindValue(':titulo', "%$q%");
        $s->bindValue(':cliente', "%$q%");
        $s->bindValue(':status_vazio', $status);
        $s->bindValue(':status_valor', $status);
        $s->bindValue(':lim', $limit, PDO::PARAM_INT);
        $s->bindValue(':off', $offset, PDO::PARAM_INT);

        $s->execute();

        return $s->fetchAll();
    }

    public static function count(string $q, string $status): int {

        $sql = "SELECT COUNT(*)
                FROM obrigacoes o
                JOIN clientes c ON c.id = o.cliente_id
                WHERE (
                    :q = ''
                    OR o.titulo LIKE :titulo
                    OR c.nome LIKE :cliente
                )
                AND (
                    :status_vazio = ''
                    OR o.status = :status_valor
                )";

        $s = Database::connection()->prepare($sql);

        $s->execute([
            'q' => $q,
            'titulo' => "%$q%",
            'cliente' => "%$q%",
            'status_vazio' => $status,
            'status_valor' => $status
        ]);

        return (int) $s->fetchColumn();
    }

    public static function find(int $id): ?array {

        $s = Database::connection()->prepare(
            'SELECT * FROM obrigacoes WHERE id = ?'
        );

        $s->execute([$id]);

        return $s->fetch() ?: null;
    }

    public static function save(array $d, ?int $id = null): void {

        if ($id) {

            $s = Database::connection()->prepare(
                'UPDATE obrigacoes
                 SET cliente_id = ?, titulo = ?, descricao = ?,
                     vencimento = ?, status = ?
                 WHERE id = ?'
            );

            $s->execute([
                $d['cliente_id'],
                $d['titulo'],
                $d['descricao'],
                $d['vencimento'],
                $d['status'],
                $id
            ]);

        } else {

            $s = Database::connection()->prepare(
                'INSERT INTO obrigacoes
                (cliente_id, titulo, descricao, vencimento, status)
                VALUES (?, ?, ?, ?, ?)'
            );

            $s->execute([
                $d['cliente_id'],
                $d['titulo'],
                $d['descricao'],
                $d['vencimento'],
                $d['status']
            ]);
        }
    }

    public static function delete(int $id): void {

        $s = Database::connection()->prepare(
            'DELETE FROM obrigacoes WHERE id = ?'
        );

        $s->execute([$id]);
    }

    public static function metrics(): array {

        $db = Database::connection();

        return [
            'total' => (int) $db->query(
                'SELECT COUNT(*) FROM obrigacoes'
            )->fetchColumn(),

            'vencidas' => (int) $db->query(
                "SELECT COUNT(*) FROM obrigacoes
                 WHERE status <> 'Concluída'
                 AND vencimento < CURDATE()"
            )->fetchColumn(),

            'pendentes' => (int) $db->query(
                "SELECT COUNT(*) FROM obrigacoes
                 WHERE status = 'Pendente'"
            )->fetchColumn(),

            'concluidas' => (int) $db->query(
                "SELECT COUNT(*) FROM obrigacoes
                 WHERE status = 'Concluída'"
            )->fetchColumn()
        ];
    }

    public static function upcoming(int $limit = 8): array {

        $sql = "SELECT o.*, c.nome AS cliente_nome
                FROM obrigacoes o
                JOIN clientes c ON c.id = o.cliente_id
                WHERE o.status <> 'Concluída'
                ORDER BY o.vencimento
                LIMIT ?";

        $s = Database::connection()->prepare($sql);

        $s->bindValue(1, $limit, PDO::PARAM_INT);

        $s->execute();

        return $s->fetchAll();
    }
}