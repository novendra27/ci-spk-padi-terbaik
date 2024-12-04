<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\AlternatifModel;
use App\Models\PenilaianModel;

class PadiController extends BaseController
{
    protected $kriteriaModel;
    protected $alternatifModel;
    protected $penilaianModel;

    public function __construct()
    {
        $this->kriteriaModel = new KriteriaModel();
        $this->alternatifModel = new AlternatifModel();
        $this->penilaianModel = new PenilaianModel();
    }

    public function index()
    {
        // Ambil data kriteria dan alternatif
        $kriteria = $this->kriteriaModel->findAll();
        $alternatif = $this->alternatifModel->findAll();

        // Ambil data penilaian berdasarkan alternatif dan kriteria
        $penilaian = $this->penilaianModel->findAll();

        // Kirim data ke view untuk ditampilkan
        return view('pages/index', [
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'data_penilaian' => $penilaian
        ]);
    }


    public function hitungWP()
    {
        // Ambil data kriteria dan bobot
        $kriteria = $this->kriteriaModel->findAll();
        $alternatif = $this->alternatifModel->findAll();

        // Langkah 1: Hitung bobot kriteria (normalisasi)
        $total_bobot = array_sum(array_column($kriteria, 'bobot'));
        $bobot_normalisasi = [];

        foreach ($kriteria as $k) {
            $bobot_normalisasi[$k['id_kriteria']] = $k['bobot'] / $total_bobot;
        }

        // Langkah 2: Ambil data penilaian alternatif terhadap kriteria
        $penilaian = $this->penilaianModel->findAll();
        $data_penilaian = [];

        foreach ($penilaian as $p) {
            $data_penilaian[$p['id_alternatif']][$p['id_kriteria']] = $p['nilai'];
        }

        // Langkah 3: Hitung nilai vektor S untuk setiap alternatif
        $vektor_s = [];

        foreach ($alternatif as $alt) {
            $nilai_s = 1;
            foreach ($kriteria as $k) {
                // Cek jenis kriteria: 'benefit' atau 'cost'
                $nilai = $data_penilaian[$alt['id_alternatif']][$k['id_kriteria']];
                $bobot = $bobot_normalisasi[$k['id_kriteria']];

                if ($k['jenis'] == 'benefit') {
                    // Untuk benefit, gunakan pangkat positif
                    $nilai_s *= pow($nilai, $bobot);
                } else if ($k['jenis'] == 'cost') {
                    // Untuk cost, gunakan pangkat negatif
                    $nilai_s *= pow($nilai, -$bobot);
                }
            }
            $vektor_s[$alt['id_alternatif']] = $nilai_s;
        }

        // Langkah 4: Hitung nilai preferensi Vektor (normalisasi S)
        $total_s = array_sum($vektor_s);
        $preferensi_v = [];

        foreach ($vektor_s as $id_alternatif => $s) {
            $preferensi_v[$id_alternatif] = $s / $total_s;
        }

        // Mengubah array alternatif menjadi array yang diindeks berdasarkan id_alternatif
        $alternatif_by_id = [];
        foreach ($alternatif as $alt) {
            $alternatif_by_id[$alt['id_alternatif']] = $alt;
        }

        return view('pages/view_alternatif', [
            'preferensi_v' => $preferensi_v,
            'vektor_s' => $vektor_s,
            'alternatif' => $alternatif_by_id,
        ]);
    }
}
