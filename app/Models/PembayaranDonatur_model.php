<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranDonatur_model extends Model
{
    public function getPembayaranDonatur()
    {
        return  $this->db->table('pembayaran_donatur')
            ->join('donatur', 'donatur.id = pembayaran_donatur.donatur')
            ->get()->getresultArray();
    }
    public function savePembayaranDonatur($data)
    {
        $query = $this->db->table('pembayaran_donatur')->insert($data);
        return $query;
    }
    // Save Uang Masuk
    public function saveUangMasuk($data1)
    {
        $query = $this->db->table('cash_in')->insert($data1);
        return $query;
    }
    public function deletePembayaranDonatur($id, $bulan)
    {
        $query = $this->db->table('pembayaran_donatur')->delete(array('donatur' => $id, 'bulan' => $bulan));
        return $query;
    }

    public function getDetail($id)
    {
        return $this->db->table('pembayaran_donatur')
            ->join('bulan', 'bulan.idb = pembayaran_donatur.bulan')
            ->where(['donatur' => $id])->get();
    }
}
