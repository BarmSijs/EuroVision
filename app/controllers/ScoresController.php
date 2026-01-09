<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Score.php';

class ScoresController extends Controller
{
    protected Score $model;

    public function __construct()
    {
        $this->model = new Score();
    }

    public function index()
    {
        $scores = $this->model->all();
        $this->render('scores/index', ['scores' => $scores, 'title' => 'Scores overzicht']);
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
        header('Location: /EuroVision/public/scores/index');
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
        header('Location: /EuroVision/public/scores/index');
        exit;
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $this->model->delete($id);
        header('Location: /EuroVision/public/scores/index');
        exit;
    }
}
