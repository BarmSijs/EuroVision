<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

class UsersController extends Controller
{
    protected User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $users = $this->model->all();
        $this->render('users/index', ['users' => $users, 'title' => 'Users overzicht']);
    }

    public function create()
    {
        $this->render('users/create', ['title' => 'Nieuwe user']);
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'role' => $_POST['role'] ?? 'user',
        ];
        $this->model->create($data);
        header('Location: /BramS/EuroVision/users/index');
        exit;
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $user = $this->model->find($id);
        if (!$user) {
            echo 'Niet gevonden';
            return;
        }
        $this->render('users/edit', ['user' => $user, 'title' => 'Bewerk user']);
    }

    public function update($id = null)
    {
        $id = (int)$id;
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'role' => $_POST['role'] ?? 'user',
        ];
        $this->model->update($id, $data);
        header('Location: /BramS/EuroVision/users/index');
        exit;
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $this->model->delete($id);
        header('Location: /BramS/EuroVision/users/index');
        exit;
    }
}
