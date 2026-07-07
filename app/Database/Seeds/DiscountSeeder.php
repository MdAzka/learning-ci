<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        // nominal diskon untuk 10 hari berturut-turut
        $nominals = [
            100000,
            100000,
            200000,
            150000,
            250000,
            300000,
            300000,
            300000,
            300000,
            300000,
        ];

        $tanggalMulai = date("Y-m-d"); // tanggal migration dibuat (hari ini)

        foreach ($nominals as $i => $nominal) {
            $data = [
                'tanggal' => date("Y-m-d", strtotime($tanggalMulai . " +{$i} days")),
                'nominal' => $nominal,
                'created_at' => date("Y-m-d H:i:s"),
            ];

            // insert data ke tabel
            $this->db->table('discount')->insert($data);
        }
    }
}
