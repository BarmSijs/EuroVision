<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Countrie.php';

class CountriesController extends Controller
{
    protected Countrie $model;

    public function __construct()
    {
        $this->model = new Countrie();
    }

    public function index()
    {
        $countries = $this->model->all();
        $this->render('countries/index', ['countries' => $countries, 'name' => 'Landen overzicht']);
    }

    public function create()
    {
        $this->render('countries/create', ['title' => 'Nieuw drankje']);
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'description' => $_POST['description'] ?? null,
        ];
        $this->model->create($data);
        header('Location: /BramS/EuroVision/countries/index');
        exit;
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $drink = $this->model->find($id);
        if (!$drink) {
            echo 'Niet gevonden';
            return;
        }
        $this->render('drinks/edit', ['drink' => $drink, 'title' => 'Bewerk drankje']);
    }

    public function update($id = null)
    {
        $id = (int)$id;
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'description' => $_POST['description'] ?? null,
        ];
        $this->model->update($id, $data);
        header('Location: /BramS/EuroVision/countries/index');
        exit;
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $this->model->delete($id);
        header('Location: /BramS/EuroVision/countries/index');
        exit;
    }
}
