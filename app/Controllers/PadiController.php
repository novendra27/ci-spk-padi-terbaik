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
        $kriteria = $this->kriteriaModel->findAll();
        $alternatif = $this->alternatifModel->findAll();
        $penilaian = $this->penilaianModel->findAll();

        return view('pages/index', [
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'data_penilaian' => $penilaian
        ]);
    }

    public function tampilkanAlternatif()
    {
        $alternatif = $this->alternatifModel->findAll();

        $data = [
            'title' => 'Data Alternatif | Padi Terbaik',
            'alternatif' => $alternatif,
        ];

        return view('pages/view_alternatif', $data);
    }

    public function tampilkanKriteria()
    {

        $kriteria = $this->kriteriaModel->findAll();

        $data = [
            'title' => 'Data Kriteria | Padi Terbaik',
            'kriteria' => $kriteria,
        ];

        return view('pages/view_kriteria', $data);
    }

    public function tampilkanPenilaian()
    {
        $penilaian = $this->penilaianModel->findAll();
        $kriteria = $this->kriteriaModel->findAll();
        $alternatif = $this->alternatifModel->findAll();

        $data_penilaian = [];
        foreach ($penilaian as $p) {
            $data_penilaian[$p['id_alternatif']][$p['id_kriteria']] = $p['nilai'];
        }

        $data = [
            'title' => 'Data Penilaian | Padi Terbaik',
            'penilaian' => $data_penilaian,
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
        ];

        return view('pages/view_penilaian', $data);
    }

    public function hitungWP()
    {
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

        // Menambahkan ranking
        $temp = [];
        $temp = $preferensi_v;
        arsort($temp);
        $ranking = [];
        $rank = 1;
        foreach ($temp as $id_alternatif => $v) {
            $ranking[$id_alternatif] = $rank++;
        }

        $data = [
            'title' => 'Hasil WP | Padi Terbaik',
            'vektor_s' => $vektor_s,
            'alternatif' => $alternatif_by_id,
            'preferensi_v' => $preferensi_v,
            'ranking' => $ranking,
        ];

        return view('pages/view_wp', $data);
    }

    public function hitungTOPSIS()
    {
        // Langkah 1: Ambil data alternatif, kriteria, dan penilaian
        $alternatif = $this->alternatifModel->findAll();
        $kriteria = $this->kriteriaModel->findAll();
        $penilaian = $this->penilaianModel->findAll();

        // Matriks Penilaian
        $data_penilaian = [];
        foreach ($penilaian as $p) {
            $data_penilaian[$p['id_alternatif']][$p['id_kriteria']] = $p['nilai'];
        }

        // Langkah 1: Normalisasi Matriks
        $normalisasi = [];
        foreach ($data_penilaian as $id_alternatif => $penilaian_alternatif) {
            foreach ($penilaian_alternatif as $id_kriteria => $nilai) {
                $normalisasi[$id_alternatif][$id_kriteria] = $nilai / sqrt(array_sum(array_map(function ($x) use ($id_kriteria) {
                    return pow($x[$id_kriteria], 2);
                }, $data_penilaian)));
            }
        }

        // Langkah 2: Matriks Ternormalisasi Terbobot
        $bobot_normalisasi = [];
        foreach ($kriteria as $k) {
            $bobot_normalisasi[$k['id_kriteria']] = $k['bobot'] / array_sum(array_column($kriteria, 'bobot'));
        }

        $ternormalisasi_terbobot = [];
        foreach ($normalisasi as $id_alternatif => $penilaian_alternatif) {
            foreach ($penilaian_alternatif as $id_kriteria => $nilai_normalisasi) {
                $ternormalisasi_terbobot[$id_alternatif][$id_kriteria] = $nilai_normalisasi * $bobot_normalisasi[$id_kriteria];
            }
        }

        // Langkah 3: Solusi Ideal Positif dan Negatif
        $PIS = $NIS = [];
        foreach ($kriteria as $k) {
            $PIS[$k['id_kriteria']] = max(array_column($ternormalisasi_terbobot, $k['id_kriteria']));
            $NIS[$k['id_kriteria']] = min(array_column($ternormalisasi_terbobot, $k['id_kriteria']));
        }

        // Langkah 4: Menghitung Jarak ke PIS dan NIS
        $D_plus = $D_minus = [];
        foreach ($ternormalisasi_terbobot as $id_alternatif => $penilaian_alternatif) {
            $D_plus[$id_alternatif] = $D_minus[$id_alternatif] = 0;
            foreach ($penilaian_alternatif as $id_kriteria => $nilai) {
                $D_plus[$id_alternatif] += pow($nilai - $PIS[$id_kriteria], 2);
                $D_minus[$id_alternatif] += pow($nilai - $NIS[$id_kriteria], 2);
            }
            $D_plus[$id_alternatif] = sqrt($D_plus[$id_alternatif]);
            $D_minus[$id_alternatif] = sqrt($D_minus[$id_alternatif]);
        }

        // Langkah 5: Menghitung Nilai Preferensi
        $preferensi = [];
        foreach ($D_plus as $id_alternatif => $D_p) {
            $preferensi[$id_alternatif] = $D_minus[$id_alternatif] / ($D_plus[$id_alternatif] + $D_minus[$id_alternatif]);
        }

        // Langkah 6: Perangkingan Alternatif
        $temp = [];
        $temp = $preferensi;
        arsort($temp);
        $ranking = [];
        $rank = 1;
        foreach ($temp as $id_alternatif => $v) {
            $ranking[$id_alternatif] = $rank++;
        }

        // Ubah struktur alternatif menjadi array yang menggunakan id_alternatif sebagai key
        $alternatif_by_id = [];
        foreach ($alternatif as $alt) {
            $alternatif_by_id[$alt['id_alternatif']] = $alt;
        }

        // Kirim data ke view
        $data = [
            'title' => 'Hasil TOPSIS | Padi Terbaik',
            'alternatif' => $alternatif_by_id,
            'preferensi' => $preferensi,
            'vektor_s' => $ternormalisasi_terbobot,
            'ranking' => $ranking,
        ];

        return view('pages/view_topsis', $data);
    }
}
