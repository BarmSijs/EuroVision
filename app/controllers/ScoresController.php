<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Score.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Participant.php';
require_once __DIR__ . '/../models/User.php';

class ScoresController extends Controller
{
    protected Score $model;
    protected Event $eventModel;
    protected Participant $participantModel;
    protected User $userModel;

    public function __construct()
    {
        $this->model = new Score();
        $this->eventModel = new Event();
        $this->participantModel = new Participant();
        $this->userModel = new User();
    }

    public function index()
    {
        $scores = $this->model->all();
        $this->render('scores/index', ['scores' => $scores, 'title' => 'Scores overzicht']);
    }

    public function scoreEvent($eventId = null)
    {
        $eventId = (int)$eventId;
        $event = $this->eventModel->find($eventId);
        if (!$event) {
            echo 'Event niet gevonden';
            return;
        }

        $participants = $this->participantModel->getWithCountries($eventId);
        $users = $this->userModel->all();
        $allScores = $this->model->all();

        // Zet scores in array voor makkelijker lookup: [userId][participantId] = score
        $scoresMap = [];
        foreach ($allScores as $score) {
            if (!isset($scoresMap[$score['user_id']])) {
                $scoresMap[$score['user_id']] = [];
            }
            $scoresMap[$score['user_id']][$score['participant_id']] = $score;
        }

        $this->render('scores/scoreEvent', [
            'event' => $event,
            'participants' => $participants,
            'users' => $users,
            'scoresMap' => $scoresMap,
            'title' => 'Scores geven - ' . $event['name']
        ]);
    }

    public function resultsEvent($eventId = null, $userId = null)
    {
        $eventId = (int)$eventId;
        $event = $this->eventModel->find($eventId);
        if (!$event) {
            echo 'Event niet gevonden';
            return;
        }

        $participants = $this->participantModel->getWithCountries($eventId);
        $allScores = $this->model->all();
        $users = $this->userModel->all();

        // Vind alle gebruikers die scores gegeven hebben voor dit event
        $usersWithScores = [];
        $userScoresByEvent = [];
        foreach ($allScores as $score) {
            // Controleer of score bij een participant van dit event hoort
            $scoreForThisEvent = false;
            foreach ($participants as $p) {
                if ($p['id'] == $score['participant_id']) {
                    $scoreForThisEvent = true;
                    break;
                }
            }
            if ($scoreForThisEvent) {
                if (!in_array($score['user_id'], $usersWithScores)) {
                    $usersWithScores[] = $score['user_id'];
                }
                if (!isset($userScoresByEvent[$score['user_id']])) {
                    $userScoresByEvent[$score['user_id']] = [];
                }
                $userScoresByEvent[$score['user_id']][$score['participant_id']] = $score;
            }
        }

        // Als geen userId gegeven, neem de eerste
        if (empty($userId) && !empty($usersWithScores)) {
            $userId = $usersWithScores[0];
        }

        // Haal scores op voor deze user
        $participantScores = [];
        if (!empty($userId) && isset($userScoresByEvent[$userId])) {
            foreach ($participants as $p) {
                if (isset($userScoresByEvent[$userId][$p['id']])) {
                    $score = $userScoresByEvent[$userId][$p['id']];
                    $participantScores[] = [
                        'participant' => $p,
                        'song_score' => $score['song_score'],
                        'outfit_score' => $score['outfit_score'],
                        'act_score' => $score['act_score'],
                        'total_score' => $score['total_score'],
                    ];
                }
            }
        }

        // Sorteer op totale score (van hoog naar laag)
        usort($participantScores, function ($a, $b) {
            return $b['total_score'] <=> $a['total_score'];
        });

        $this->render('scores/resultsEvent', [
            'event' => $event,
            'participantScores' => $participantScores,
            'users' => $users,
            'usersWithScores' => $usersWithScores,
            'selectedUserId' => $userId,
            'title' => 'Resultaten - ' . $event['name']
        ]);
    }

    public function saveScores($eventId = null)
    {
        $eventId = (int)$eventId;

        // Verwerk alle scores
        if (isset($_POST['scores']) && is_array($_POST['scores'])) {
            foreach ($_POST['scores'] as $participantId => $scoreData) {
                $participantId = (int)$participantId;
                $userId = (int)($_POST['user_id'] ?? 0);

                if (empty($userId)) continue;

                $song_score = (int)($scoreData['song'] ?? 0);
                $outfit_score = (int)($scoreData['outfit'] ?? 0);
                $act_score = (int)($scoreData['act'] ?? 0);
                $total_score = $song_score + $outfit_score + $act_score;

                // Check of score al bestaat
                $existingScore = $this->model->all();
                $scoreExists = false;
                foreach ($existingScore as $s) {
                    if ($s['user_id'] == $userId && $s['participant_id'] == $participantId) {
                        $scoreExists = true;
                        $this->model->update($s['id'], [
                            'song_score' => $song_score,
                            'outfit_score' => $outfit_score,
                            'act_score' => $act_score,
                            'total_score' => $total_score,
                        ]);
                        break;
                    }
                }

                if (!$scoreExists) {
                    $this->model->create([
                        'user_id' => $userId,
                        'participant_id' => $participantId,
                        'song_score' => $song_score,
                        'outfit_score' => $outfit_score,
                        'act_score' => $act_score,
                        'total_score' => $total_score,
                    ]);
                }
            }
        }

        header('Location: /BramS/EuroVision/events/index');
        exit;
    }

    public function create()
    {
        $this->render('scores/create', ['title' => 'Nieuwe score']);
    }

    public function store()
    {
        $data = [
            'user_id' => $_POST['user_id'] ?? null,
            'participant_id' => $_POST['participant_id'] ?? null,
            'song_score' => $_POST['song_score'] ?? 0,
            'outfit_score' => $_POST['outfit_score'] ?? 0,
            'act_score' => $_POST['act_score'] ?? 0,
            'total_score' => $_POST['total_score'] ?? 0,
        ];
        $this->model->create($data);
        header('Location: /BramS/EuroVision/scores/index');
        exit;
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $score = $this->model->find($id);
        if (!$score) {
            echo 'Niet gevonden';
            return;
        }
        $this->render('scores/edit', ['score' => $score, 'title' => 'Bewerk score']);
    }

    public function update($id = null)
    {
        $id = (int)$id;
        $data = [
            'song_score' => $_POST['song_score'] ?? 0,
            'outfit_score' => $_POST['outfit_score'] ?? 0,
            'act_score' => $_POST['act_score'] ?? 0,
            'total_score' => $_POST['total_score'] ?? 0,
        ];
        $this->model->update($id, $data);
        header('Location: /BramS/EuroVision/scores/index');
        exit;
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $this->model->delete($id);
        header('Location: /BramS/EuroVision/scores/index');
        exit;
    }
}
