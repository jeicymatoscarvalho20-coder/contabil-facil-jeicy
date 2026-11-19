<!doctype html>
<html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($title ?? 'Contábil Fácil') ?> | Contábil Fácil</title><link rel="stylesheet" href="/assets/style.css"></head>
<body>
<?php if(!empty($_SESSION['user_id'])): ?>
<aside class="sidebar"><div class="brand">◇ Contábil Fácil</div><nav>
<a href="/">Visão geral</a><a href="/clientes">Clientes</a><a href="/obrigacoes">Obrigações fiscais</a><a href="/avaliacao">Avaliar sistema</a>
</nav><div class="user"><strong>Olá, <?= e(current_user()) ?></strong><form method="post" action="/logout"><?= csrf_field() ?><button class="logout">Sair</button></form></div></aside>
<main class="main"><header><span>Gestão contábil simplificada</span><span><?= date('d/m/Y') ?></span></header><?php require $viewFile; ?></main>
<?php else: ?><?php require $viewFile; ?><?php endif; ?>
</body></html>