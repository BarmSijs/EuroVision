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
            'winner_participant_id' => null,
        ];
        $eventId = $this->model->create($data);

        // Voeg geselecteerde landen + artiest/lied als deelnemers toe
        if (isset($_POST['participants']) && !empty($eventId)) {
            foreach ($_POST['participants'] as $countryId => $participantData) {
                // Skip als country_id niet ingesteld is (checkbox niet aangevinkt)
                if (empty($participantData['country_id'])) {
                    continue;
                }

                $this->participantModel->create([
                    'event_id' => $eventId,
                    'country_id' => (int)$countryId,
                    'artist' => $participantData['artist'] ?? '',
                    'song' => $participantData['song'] ?? '',
                ]);
            }
        }

        // Redirect naar participants overzicht
        header('Location: /BramS/EuroVision/events/participants/' . $eventId);
        exit;
    }

    public function participants($eventId = null)
    {
        $eventId = (int)$eventId;
        $event = $this->model->find($eventId);
        if (!$event) {
            echo 'Event niet gevonden';
            return;
        }
        $participants = $this->participantModel->getWithCountries($eventId);
        $this->render('events/participants', [
            'event' => $event,
            'participants' => $participants,
            'title' => 'Deelnemers - ' . $event['name'],
            'countrieModel' => $this->countrieModel
        ]);
    }

    public function addParticipant($eventId = null)
    {
        $eventId = (int)$eventId;
        $event = $this->model->find($eventId);
        if (!$event) {
            echo 'Event niet gevonden';
            return;
        }

        $data = [
            'event_id' => $eventId,
            'country_id' => $_POST['country_id'] ?? null,
            'artist' => $_POST['artist'] ?? '',
            'song' => $_POST['song'] ?? '',
        ];
        $this->participantModel->create($data);

        header('Location: /BramS/EuroVision/events/participants/' . $eventId);
        exit;
    }

    public function selectWinner($id = null)
    {
        $id = (int)$id;
        $event = $this->model->find($id);
        if (!$event) {
            echo 'Event niet gevonden';
            return;
        }
        $participants = $this->participantModel->getWithCountries($id);
        $this->render('events/selectWinner', [
            'event' => $event,
            'participants' => $participants,
            'title' => 'Winnaar selecteren - ' . $event['name']
        ]);
    }

    public function setWinner($eventId = null, $participantId = null)
    {
        $eventId = (int)$eventId;
        $participantId = (int)$participantId;

        $this->model->update($eventId, ['winner_participant_id' => $participantId]);
        header('Location: /BramS/EuroVision/events/index');
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
        header('Location: /BramS/EuroVision/events/index');
        exit;
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $this->model->delete($id);
        header('Location: /BramS/EuroVision/events/index');
        exit;
    }
}
