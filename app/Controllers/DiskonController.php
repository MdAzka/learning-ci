<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiscountModel;

class DiskonController extends BaseController
{
    protected $discountModel;

    function __construct()
    {
        helper(['number', 'form', 'url']);
        $this->discountModel = new DiscountModel();
    }

    public function index()
    {
        return view('diskon/index', [
            'discounts' => $this->discountModel->orderBy('tanggal', 'ASC')->findAll()
        ]);
    }

    public function create()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nominal = $this->request->getPost('nominal');

        // validasi: tidak boleh ada diskon untuk tanggal yang sama
        $cek = $this->discountModel->where('tanggal', $tanggal)->first();
        if ($cek) {
            return redirect()->back()->with('failed', 'Sudah ada data diskon untuk tanggal tersebut');
        }

        $this->discountModel->insert([
            'tanggal' => $tanggal,
            'nominal' => $nominal
        ]);

        return redirect('diskon')->with('success', 'Data Berhasil Ditambah');
    }

    public function edit($id)
    {
        // tanggal tidak boleh diubah, hanya nominal
        $this->discountModel->update($id, [
            'nominal' => $this->request->getPost('nominal')
        ]);

        return redirect('diskon')->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id)
    {
        $this->discountModel->delete($id);

        return redirect('diskon')->with('success', 'Data Berhasil Dihapus');
    }
}
