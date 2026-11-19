<?php
final class DashboardController {
    public function index(): void {
        auth_required();
        render('dashboard/index',['title'=>'Visão geral','metrics'=>Obrigacao::metrics(),'upcoming'=>Obrigacao::upcoming()]);
    }
}
