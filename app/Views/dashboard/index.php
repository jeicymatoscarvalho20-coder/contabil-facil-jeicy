<div class="page-head"><div><h1>Visão geral</h1><p>Acompanhe a rotina do escritório em um só lugar.</p></div><a class="btn" href="/obrigacoes/nova">+ Nova obrigação</a></div>
<section class="stats">
<div class="stat"><span>Clientes cadastrados</span><strong><?= (int)Database::connection()->query('SELECT COUNT(*) FROM clientes')->fetchColumn() ?></strong></div>
<div class="stat"><span>Obrigações no sistema</span><strong><?= $metrics['total'] ?></strong></div>
<div class="stat warning"><span>Obrigações vencidas</span><strong><?= $metrics['vencidas'] ?></strong></div>
<div class="stat"><span>Pendentes</span><strong><?= $metrics['pendentes'] ?></strong></div>
<div class="stat good"><span>Concluídas</span><strong><?= $metrics['concluidas'] ?></strong></div>
</section>
<section class="panel"><div class="panel-title"><h2>Próximos prazos e pendências</h2><a href="/obrigacoes">Ver todas</a></div><div class="table-wrap"><table><thead><tr><th>Obrigação</th><th>Cliente</th><th>Vencimento</th><th>Status</th><th>Alerta</th></tr></thead><tbody>
<?php foreach($upcoming as $o): $late=$o['vencimento']<date('Y-m-d') && $o['status']!=='Concluída'; ?>
<tr><td><?= e($o['titulo']) ?></td><td><?= e($o['cliente_nome']) ?></td><td><?= date('d/m/Y',strtotime($o['vencimento'])) ?></td><td><span class="tag"><?= e($o['status']) ?></span></td><td class="<?= $late?'late':'ok' ?>"><?= $late?'Vencida':(strtotime($o['vencimento'])-strtotime(date('Y-m-d'))<=3*86400?'Prazo próximo':'Em dia') ?></td></tr>
<?php endforeach; if(!$upcoming): ?><tr><td colspan="5">Nenhuma obrigação cadastrada.</td></tr><?php endif; ?>
</tbody></table></div></section>
<div class="notice"><strong>Central de alertas:</strong> acompanhe nesta tela os prazos próximos e as obrigações vencidas para priorizar as cobranças e evitar atrasos.</div>