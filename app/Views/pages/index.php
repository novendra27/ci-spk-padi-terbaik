<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Weighted Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Perhitungan Weighted Product untuk Pemilihan Padi Terbaik</h1>

        <!-- Tampilkan data kriteria -->
        <div class="mt-4">
            <h3>Kriteria</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kriteria as $key => $k): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $k['nama_kriteria'] ?></td>
                            <td><?= $k['bobot'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tampilkan data alternatif -->
        <div class="mt-4">
            <h3>Alternatif</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Alternatif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alternatif as $key => $alt): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $alt['nama_alternatif'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tampilkan data penilaian -->
        <div class="mt-4">
            <h3>Penilaian Alternatif terhadap Kriteria</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        <?php foreach ($kriteria as $k): ?>
                            <th><?= $k['nama_kriteria'] ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alternatif as $alt): ?>
                        <tr>
                            <td><?= $alt['nama_alternatif'] ?></td>
                            <?php foreach ($kriteria as $k): ?>
                                <td>
                                    <?php 
                                    // Menampilkan nilai penilaian untuk alternatif dan kriteria
                                    $penilaian = array_filter($data_penilaian, function($p) use ($alt, $k) {
                                        return $p['id_alternatif'] == $alt['id_alternatif'] && $p['id_kriteria'] == $k['id_kriteria'];
                                    });
                                    $penilaian = array_values($penilaian);
                                    echo isset($penilaian[0]) ? $penilaian[0]['nilai'] : 'N/A';
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Hitung -->
        <a href="<?= site_url('/padi/hitung') ?>" class="btn btn-primary mt-3">Hitung Perhitungan WP</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
