<?php
class Controller
{
    protected function render(string $view, array $data = [])
    {
        extract($data, EXTR_SKIP);
        include __DIR__ . '/../views/' . $view . '.php';
    }
}