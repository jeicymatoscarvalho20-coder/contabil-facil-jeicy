<?php
function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function redirect(string $path): never { header('Location: ' . $path); exit; }
function csrf_token(): string {
    if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['_csrf'];
}
function csrf_field(): string { return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">'; }
function verify_csrf(): void {
    $sent = $_POST['_csrf'] ?? '';
    if (!is_string($sent) || !hash_equals($_SESSION['_csrf'] ?? '', $sent)) {
        http_response_code(419); exit('Sessão do formulário expirada. Volte e tente novamente.');
    }
}
function auth_required(): void {
    if (empty($_SESSION['user_id'])) redirect('/login');
}
function current_user(): string { return $_SESSION['user_name'] ?? 'Administrador'; }
function render(string $view, array $data = []): void {
    extract($data);
    $viewFile = BASE_PATH . '/app/Views/' . $view . '.php';
    require BASE_PATH . '/app/Views/layout.php';
}
function page_url(array $changes = []): string {
    $params = array_merge($_GET, $changes);
    return '?' . http_build_query($params);
}
