<div class="login-wrap">
    <form class="login-card" method="post" action="/login">
        <?= csrf_field() ?>

        <div class="brand dark">◇ Contábil Fácil</div>

        <h1>Acesse sua conta</h1>
        <p>Entre para gerenciar clientes e obrigações.</p>

        <?php if (!empty($errors['geral'])): ?>
            <div class="alert error"><?= e($errors['geral']) ?></div>
        <?php endif; ?>

        <label>E-mail</label>
        <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required>

        <?php if (!empty($errors['email'])): ?>
            <small class="field-error"><?= e($errors['email']) ?></small>
        <?php endif; ?>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <?php if (!empty($errors['senha'])): ?>
            <small class="field-error"><?= e($errors['senha']) ?></small>
        <?php endif; ?>

        <button class="btn full">Entrar</button>
    </form>
</div>