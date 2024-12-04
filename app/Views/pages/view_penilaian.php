<?= $this->extend('layout/template');  ?>

<?= $this->section('content');  ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">SPK Padi Terbaik</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data Nilai Alternatif Terhadap Kriteria</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Nilai Alternatif Terhadap Kriteria</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Alternatif</th>
                            <th>R1 (Harga)</th>
                            <th>R2 (Kualitas)</th>
                            <th>R3 (Waktu Panen)</th>
                            <th>R4 (Popularitas)</th>
                            <th>R5 (Biaya Perawatan)</th>
                            <th>R6 (Keawetan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($alternatif as $alt): ?>
                            <tr>
                                <td>X<?= $counter++ ?></td>
                                <td><?= $alt['nama_alternatif'] ?></td>
                                <?php
                                // Tampilkan penilaian berdasarkan ID kriteria untuk setiap alternatif
                                foreach ($kriteria as $k): ?>
                                    <td>
                                        <?= isset($penilaian[$alt['id_alternatif']][$k['id_kriteria']])
                                            ? $penilaian[$alt['id_alternatif']][$k['id_kriteria']]
                                            : 'N/A' ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection();  ?>