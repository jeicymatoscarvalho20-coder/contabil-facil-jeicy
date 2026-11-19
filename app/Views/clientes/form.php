<div class="page-head">
    <div>
        <h1><?= e($title) ?></h1>
        <p>Preencha os dados do cliente.</p>
    </div>
    <a class="btn secondary" href="/clientes">Voltar</a>
</div>

<form class="panel form-grid"
      method="post"
      action="<?= isset($item['id']) ? '/clientes/atualizar' : '/clientes/salvar' ?>"
      autocomplete="off">

    <?= csrf_field() ?>

    <?php if (isset($item['id'])): ?>
        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
    <?php endif; ?>

    <div>
        <label>Nome / Razão social *</label>
        <input type="text" name="nome"
               value="<?= e($item['nome'] ?? '') ?>"
               autocomplete="off">
        <?php if (isset($errors['nome'])): ?>
            <small class="field-error"><?= e($errors['nome']) ?></small>
        <?php endif; ?>
    </div>

    <div>
        <label>CNPJ / CPF *</label>
        <input type="text" name="cnpj"
               value="<?= e($item['cnpj'] ?? '') ?>"
               autocomplete="off">
        <?php if (isset($errors['cnpj'])): ?>
            <small class="field-error"><?= e($errors['cnpj']) ?></small>
        <?php endif; ?>
    </div>

    <div>
        <label>E-mail</label>
        <input type="email" name="email"
               value="<?= e($item['email'] ?? '') ?>"
               autocomplete="off">
        <?php if (isset($errors['email'])): ?>
            <small class="field-error"><?= e($errors['email']) ?></small>
        <?php endif; ?>
    </div>

    <div>
        <label>Telefone</label>
        <input type="text" name="telefone"
               value="<?= e($item['telefone'] ?? '') ?>"
               autocomplete="off">
    </div>

    <div class="wide">
        <label>Responsável</label>
        <input type="text" name="responsavel"
               value="<?= e($item['responsavel'] ?? '') ?>"
               autocomplete="off">
    </div>

    <div class="wide">
        <button class="btn" type="submit">Salvar cliente</button>
    </div>

</form>