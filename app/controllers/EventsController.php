<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Event.php';

class EventsController extends Controller
{
    protected Event $model;

    public function __construct()
    {
        $this->model = new Event();
    }

    public function index()
    {
        $events = $this->model->all();
        $this->render('events/index', ['events' => $events, 'title' => 'Events overzicht']);
    }

    public function create()
    {
        $this->render('events/create', ['title' => 'Nieuw event']);
    }

    public function store()
    {
        $data = [
            'year' => $_POST['year'] ?? null,
            'name' => $_POST['name'] ?? '',
            'winner_participant_id' => $_POST['winner_participant_id'] ?? null,
        ];
        $this->model->create($data);
        header('Location: /EuroVision/public/events/index');
        exit;
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $event = $this->model->find($id);
        if (!$event) {
            echo 'Niet gevonden';
            return;
        }
        $this->render('events/edit', ['event' => $event, 'title' => 'Bewerk event']);
    }

    public function update($id = null)
    {
        $id = (int)$id;
        $data = [
            'year' => $_POST['year'] ?? null,
            'name' => $_POST['name'] ?? '',
            'winner_participant_id' => $_POST['winner_participant_id'] ?? null,
        ];
        $this->model->update($id, $data);
        header('Location: /EuroVision/public/events/index');
        exit;
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $this->model->delete($id);
        header('Location: /EuroVision/public/events/index');
        exit;
    }
}
