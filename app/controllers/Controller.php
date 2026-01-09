<?php
class Controller
{
    protected function render(string $view, array $data = [])
    {
        extract($data, EXTR_SKIP);
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/' . $view . '.php';
        include __DIR__ . '/../views/layout/footer.php';
    }
}
