<?php

namespace App\Controllers;

use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

class Pengguna extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $db;

    public function __construct()
    {
        $this->userModel  = new UserModel();
        $this->groupModel = new GroupModel();
        $this->db         = \Config\Database::connect();
    }

    public function index()
    {
        $users = $this->db->table('users u')
            ->select('u.id, u.email, u.username, u.active, u.created_at, g.name as role_name, g.description as role_desc, g.id as group_id')
            ->join('auth_groups_users agu', 'agu.user_id = u.id', 'left')
            ->join('auth_groups g', 'g.id = agu.group_id', 'left')
            ->orderBy('u.id', 'DESC')
            ->get()
            ->getResultArray();

        $groups = $this->groupModel->findAll();

        $data = [
            'title'  => 'Manajemen Pengguna & Role',
            'users'  => $users,
            'groups' => $groups,
        ];

        return view('pengguna/index', $data);
    }

    public function simpan()
    {
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'group_id' => 'required|is_not_unique[auth_groups.id]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User([
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'active'   => 1,
        ]);

        $userId = $this->userModel->insert($user);

        if (!$userId) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $groupId = (int) $this->request->getPost('group_id');
        $this->groupModel->addUserToGroup($userId, $groupId);

        return redirect()->to('/pengguna')->with('message', 'Pengguna baru berhasil ditambahkan.');
    }

    public function update($id)
    {
        $rules = [
            'username' => "required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,{$id}]",
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'group_id' => 'required|is_not_unique[auth_groups.id]',
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/pengguna')->with('errors', ['Pengguna tidak ditemukan.']);
        }

        $user->username = $this->request->getPost('username');
        $user->email    = $this->request->getPost('email');
        if (!empty($password)) {
            $user->password = $password;
        }

        $this->userModel->save($user);

        $groupId = (int) $this->request->getPost('group_id');
        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
        $this->groupModel->addUserToGroup($id, $groupId);

        return redirect()->to('/pengguna')->with('message', 'Data pengguna berhasil diperbarui.');
    }

    public function hapus($id)
    {
        // Cegah admin menghapus akunnya sendiri
        if (function_exists('user_id') && (int) user_id() === (int) $id) {
            return redirect()->to('/pengguna')->with('errors', ['Anda tidak dapat menonaktifkan akun sendiri.']);
        }

        // Soft deactive
        $this->userModel->update($id, ['active' => 0]);

        return redirect()->to('/pengguna')->with('message', 'Akun pengguna dinonaktifkan.');
    }
}
