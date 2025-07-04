<?php

namespace App\Controllers;

use App\Models\DiskonModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user;

    function __construct()
    {
        helper('form');
        $this->user = new UserModel();
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]|',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first(); //pasw 1234567

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        session()->set([
                            'id' => $dataUser['id'],
                            'username' => $dataUser['username'],
                            'email' => $dataUser['email'],
                            'role' => $dataUser['role'],
                            'isLoggedIn' => TRUE
                        ]);

                        // mengecek apakah ketika login di hari itu ada diskon 
                        $diskonModel = new DiskonModel();
                        $diskon = $diskonModel->where('tanggal', date('Y-m-d'))->first();

                        if ($diskon) {
                            session()->set([
                                'diskon_nominal' => $diskon['nominal'],
                                'diskon_tanggal' => $diskon['tanggal']
                            ]);
                        }

                        return redirect()->to(base_url('/'));
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        return view('v_login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
