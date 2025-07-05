<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\DiskonModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $diskonModel;

    //c
    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();

        // untuk menyimpan object baru dari client guzzle dan nilai API Key yang tersimpan pada file .env.
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');

        // untuk menginisialisasi model transaksi dan detail transaksi
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->diskonModel = new DiskonModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $harga_asli = $this->request->getPost('harga');
        $harga_final = $harga_asli;
        $diskon_amount = 0;
        
        // Cek apakah ada diskon untuk hari ini
        $today = date('Y-m-d');
        $diskon_hari_ini = $this->diskonModel->where('tanggal', $today)->first();
        
        if ($diskon_hari_ini) {
            $diskon_amount = $diskon_hari_ini['nominal'];
            $harga_final = $harga_asli - $diskon_amount;
            
            // Pastikan harga tidak negatif
            if ($harga_final < 0) {
                $harga_final = 0;
            }
        }

        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $harga_final,
            'name'      => $this->request->getPost('nama'),
            'options'   => array(
                'foto' => $this->request->getPost('foto'),
                'harga_asli' => $harga_asli,
                'diskon' => $diskon_amount
            )
        ));
        
        $message = 'Produk berhasil ditambahkan ke keranjang.';
        if ($diskon_amount > 0) {
            $message .= ' Diskon Rp ' . number_format($diskon_amount, 0, ',', '.') . ' telah diterapkan!';
        }
        $message .= ' (<a href="' . base_url() . 'keranjang">Lihat</a>)';
        
        session()->setflashdata('success', $message);
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

    // Checkout function to display the checkout page
    public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }

    public function getLocation()
    {
        //keyword pencarian yang dikirimkan dari halaman checkout
        $search = $this->request->getGet('search');

        $response = $this->client->request(
            'GET',
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $search . '&limit=50',
            [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    {
        //ID lokasi yang dikirimkan dari halaman checkout
        $destination = $this->request->getGet('destination');

        //parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
        //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
        $response = $this->client->request(
            'POST',
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
            [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function buy()
    {
        if ($this->request->getPost()) {
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'total_harga' => $this->request->getPost('total_harga'),
                'alamat' => $this->request->getPost('alamat'),
                'ongkir' => $this->request->getPost('ongkir'),
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $this->transactionModel->insert($dataForm);

            $last_insert_id = $this->transactionModel->getInsertID();

            foreach ($this->cart->contents() as $value) {
                $dataFormDetail = [
                    'transaction_id' => $last_insert_id,
                    'product_id' => $value['id'],
                    'jumlah' => $value['qty'],
                    'diskon' => isset($value['options']['diskon']) ? $value['options']['diskon'] : 0,
                    'subtotal_harga' => $value['qty'] * $value['price'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];

                $this->transactionDetailModel->insert($dataFormDetail);
            }

            $this->cart->destroy();

            return redirect()->to(base_url(''));
        }
    }
}