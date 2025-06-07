<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $data = [
            [
                'nama' => 'Noir Timeless82 v2 Classic Edition Mechanical Keyboard Gasket Mount - Beige, Silent',
                'harga'  => 849000,
                'jumlah' => 50,
                'foto' => 'Keyboard_Gasket_Mount_Beige.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ]
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('product')->insert($item);
        }
    }
}