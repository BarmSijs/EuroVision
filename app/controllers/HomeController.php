<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Event.php';

class HomeController extends Controller
{
    public function index()
    {
        $events = (new Event())->all();
        $this->render('home', ['events' => $events, 'title' => 'EuroVision Home']);
    }
}
