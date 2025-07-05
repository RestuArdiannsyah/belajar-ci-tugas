<?php

namespace App\Controllers;

use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    // Constructor
    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
    }

    // Index
    public function index()
    {
        $diskon = $this->diskonModel->findAll();
        $data['diskon'] = $diskon;

        return view('v_diskon', $data);
    }

    // function create data
    public function create()
    {
        $tanggal = $this->request->getPost('tanggal');
        
        // Cek apakah tanggal sudah ada
        $existing = $this->diskonModel->where('tanggal', $tanggal)->first();
        
        if ($existing) {
            return redirect('diskon')->with('failed', 'Tanggal ' . $tanggal . ' sudah ada. Silakan pilih tanggal lain.');
        }

        $dataForm = [
            'tanggal' => $tanggal,
            'nominal' => $this->request->getPost('nominal'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->diskonModel->insert($dataForm);

        return redirect('diskon')->with('success', 'Data Berhasil Ditambah');
    }

    // function edit data
    public function edit($id)
    {
        $tanggal = $this->request->getPost('tanggal');
        
        // Cek apakah tanggal sudah ada, kecuali untuk data yang sedang diedit
        $existing = $this->diskonModel->where('tanggal', $tanggal)->where('id !=', $id)->first();
        
        if ($existing) {
            return redirect('diskon')->with('failed', 'Tanggal ' . $tanggal . ' sudah ada. Silakan pilih tanggal lain.');
        }

        $dataForm = [
            'tanggal' => $tanggal,
            'nominal' => $this->request->getPost('nominal'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->diskonModel->update($id, $dataForm);

        return redirect('diskon')->with('success', 'Data Berhasil Diubah');
    }

    // function delete data
    public function delete($id)
    {
        $this->diskonModel->delete($id);

        return redirect('diskon')->with('success', 'Data Berhasil Dihapus');
    }
}