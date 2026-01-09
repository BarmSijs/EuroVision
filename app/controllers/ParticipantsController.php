<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Participant.php';

class ParticipantsController extends Controller
{
    protected Participant $model;

    public function __construct()
    {
        $this->model = new Participant();
    }

    public function index()
    {
        $participants = $this->model->all();
        $this->render('participants/index', ['participants' => $participants, 'title' => 'Participants overzicht']);
    }

    public function create()
    {
        $this->render('participants/create', ['title' => 'Nieuwe participant']);
    }

    public function store()
    {
        $data = [
            'event_id' => $_POST['event_id'] ?? null,
            'country_id' => $_POST['country_id'] ?? null,
            'artist' => $_POST['artist'] ?? '',
            'song' => $_POST['song'] ?? '',
        ];
        $this->model->create($data);
        header('Location: /EuroVision/public/participants/index');
        exit;
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $participant = $this->model->find($id);
        if (!$participant) {
            echo 'Niet gevonden';
            return;
        }
        $this->render('participants/edit', ['participant' => $participant, 'title' => 'Bewerk participant']);
    }

    public function update($id = null)
    {
        $id = (int)$id;
        $data = [
            'event_id' => $_POST['event_id'] ?? null,
            'country_id' => $_POST['country_id'] ?? null,
            'artist' => $_POST['artist'] ?? '',
            'song' => $_POST['song'] ?? '',
        ];
        $this->model->update($id, $data);
        header('Location: /EuroVision/public/participants/index');
        exit;
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $this->model->delete($id);
        header('Location: /EuroVision/public/participants/index');
        exit;
    }
}
