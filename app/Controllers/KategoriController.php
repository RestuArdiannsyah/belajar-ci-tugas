<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;

    // Constructor
    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    // Index
    public function index()
    {
        $kategori = $this->kategoriModel->findAll();
        $data['kategori'] = $kategori;

        return view('v_kategori', $data);
    }

    // function create data
    public function create()
    {
        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->kategoriModel->insert($dataForm);

        return redirect('kategori')->with('success', 'Data Berhasil Ditambah');
    }

    // function edit data
    public function edit($id)
    {
        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->kategoriModel->update($id, $dataForm);

        return redirect('kategori')->with('success', 'Data Berhasil Diubah');
    }

    // function delete data
    public function delete($id)
    {
        $this->kategoriModel->delete($id);

        return redirect('kategori')->with('success', 'Data Berhasil Dihapus');
    }
}
