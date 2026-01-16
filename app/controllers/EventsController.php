<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Countrie.php';
require_once __DIR__ . '/../models/Participant.php';

class EventsController extends Controller
{
    protected Event $model;
    protected Countrie $countrieModel;
    protected Participant $participantModel;

    public function __construct()
    {
        $this->model = new Event();
        $this->countrieModel = new Countrie();
        $this->participantModel = new Participant();
    }

    public function index()
    {
        $events = $this->model->all();

        // Voeg winnaar toe aan elk event
        foreach ($events as &$event) {
            $event['winner'] = $this->model->winnerEvent($event['id']);
        }

        $this->render('events/index', ['events' => $events, 'title' => 'Events overzicht']);
    }

    public function create()
    {
        $countries = $this->countrieModel->all();
        $this->render('events/create', [
            'title' => 'Nieuw event',
            'countries' => $countries
        ]);
    }

    public function store()
    {
        $data = [
            'year' => $_POST['year'] ?? null,
            'name' => $_POST['name'] ?? '',
            'winner_participant_id' => $_POST['winner_participant_id'] ?? null,
        ];
        $eventId = $this->model->create($data);

        // Voeg geselecteerde landen als deelnemers toe
        if (isset($_POST['countries']) && !empty($eventId)) {
            foreach ($_POST['countries'] as $countryId) {
                $this->participantModel->create([
                    'event_id' => $eventId,
                    'country_id' => (int)$countryId,
                ]);
            }
        }

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
