<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProfilController extends BaseController
{
    protected $userModel;

    // Constructor
    function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    // Index - menampilkan halaman profil
    public function index()
    {
        // Cek login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil user berdasarkan username (bukan id)
        $username = session()->get('username');
        $user = $this->userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Data user tidak ditemukan');
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        return view('v_profil', $data);
    }

    // Edit info pengguna (username dan email)
    public function editInfo()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil user berdasarkan username
        $username = session()->get('username');
        $user = $this->userModel->where('username', $username)->first();
        $userId = $user['id'];

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $dataForm = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        // Cek apakah email sudah digunakan user lain
        $existingUser = $this->userModel->where('email', $dataForm['email'])
            ->where('id !=', $userId)
            ->first();

        if ($existingUser) {
            return redirect()->back()->withInput()
                ->with('error', 'Email sudah digunakan');
        }

        // Cek apakah username sudah digunakan user lain
        $existingUsername = $this->userModel->where('username', $dataForm['username'])
            ->where('id !=', $userId)
            ->first();
        if ($existingUsername) {
            return redirect()->back()->withInput()
                ->with('error', 'Username sudah digunakan');
        }

        // Update data
        $this->userModel->update($userId, $dataForm);

        // Update session jika diperlukan
        session()->set([
            'username' => $dataForm['username'],
            'email' => $dataForm['email']
        ]);

        return redirect('profil')->with('success', 'Informasi profil berhasil diperbarui');
    }

    // Edit foto profil
    public function editFoto()
    {
        // Ambil user berdasarkan username
        $username = session()->get('username');
        $user = $this->userModel->where('username', $username)->first();
        $userId = $user['id'];

        $userData = $this->userModel->find($userId);

        // Validasi file
        $validation = \Config\Services::validation();
        $validation->setRules([
            'foto_profil' => [
                'label' => 'Foto Profil',
                'rules' => 'uploaded[foto_profil]|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]|max_size[foto_profil,2048]'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', 'File foto tidak valid. Pastikan file adalah gambar (JPG/PNG) dan ukuran maksimal 2MB');
        }

        $dataFoto = $this->request->getFile('foto_profil');

        if ($dataFoto->isValid() && !$dataFoto->hasMoved()) {
            // Hapus foto lama jika ada
            if ($userData['foto_profil'] != '' && file_exists("img/profil/" . $userData['foto_profil'])) {
                unlink("img/profil/" . $userData['foto_profil']);
            }

            // Upload foto baru
            $fileName = $dataFoto->getRandomName();

            // Buat folder jika belum ada
            if (!is_dir('img/profil/')) {
                mkdir('img/profil/', 0777, true);
            }

            $dataFoto->move('img/profil/', $fileName);

            // Update database
            $dataForm = [
                'foto_profil' => $fileName,
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $this->userModel->update($userId, $dataForm);

            // Update session foto profil
            session()->set('foto_profil', $fileName);

            return redirect('profil')->with('success', 'Foto profil berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal mengupload foto profil');
    }

    // Edit password
    public function editPassword()
    {
        // Ambil user berdasarkan username
        $username = session()->get('username');
        $user = $this->userModel->where('username', $username)->first();
        $userId = $user['id'];

        $userData = $this->userModel->find($userId);

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'password_lama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password lama harus diisi'
                ]
            ],
            'password_baru' => [
                'rules' => 'required|min_length[7]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password baru minimal 7 karakter'
                ]
            ],
            'konfirmasi_password' => [
                'rules' => 'required|matches[password_baru]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok dengan password baru'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        // Verifikasi password lama
        if (!password_verify($passwordLama, $userData['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password baru
        $dataForm = [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->userModel->update($userId, $dataForm);

        return redirect('profil')->with('success', 'Password berhasil diperbarui');
    }

    // Fungsi tambahan untuk menghapus foto profil
    public function hapusFoto()
    {
        // Ambil user berdasarkan username
        $username = session()->get('username');
        $user = $this->userModel->where('username', $username)->first();
        $userId = $user['id'];

        $userData = $this->userModel->find($userId);

        // Hapus file foto jika ada
        if ($userData['foto_profil'] != '' && file_exists("img/profil/" . $userData['foto_profil'])) {
            unlink("img/profil/" . $userData['foto_profil']);
        }

        // Update database
        $dataForm = [
            'foto_profil' => null,
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->userModel->update($userId, $dataForm);

        // Update session
        session()->remove('foto_profil');

        return redirect('profil')->with('success', 'Foto profil berhasil dihapus');
    }
}