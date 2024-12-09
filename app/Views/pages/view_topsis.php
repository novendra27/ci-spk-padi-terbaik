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
                    <li class="breadcrumb-item active">Hasil Perhitungan Metode TOPSIS</li>
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
                <h3 class="card-title">Hasil Perhitungan Metode TOPSIS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Alternatif</th>
                            <th>Alternatif</th>
                            <th>Preferensi</th>
                            <th>Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($preferensi as $id_alternatif => $preferensi_value): ?>
                            <tr>
                                <td>X<?= $counter++ ?></td>
                                <td><?= $alternatif[$id_alternatif]['nama_alternatif'] ?></td>
                                <td><?= number_format($preferensi_value, 9) ?></td>
                                <td><?= $ranking[$id_alternatif] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hasil Perhitungan Ternormalisasi Bobot</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
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
                        <?php foreach ($alternatif as $id_alternatif => $alt): ?>
                            <tr>
                                <td><?= $alt['nama_alternatif'] ?></td>
                                <td><?= number_format($vektor_s[$id_alternatif][2001], 9) ?></td> 
                                <td><?= number_format($vektor_s[$id_alternatif][2002], 9) ?></td> 
                                <td><?= number_format($vektor_s[$id_alternatif][2003], 9) ?></td> 
                                <td><?= number_format($vektor_s[$id_alternatif][2004], 9) ?></td> 
                                <td><?= number_format($vektor_s[$id_alternatif][2005], 9) ?></td> 
                                <td><?= number_format($vektor_s[$id_alternatif][2006], 9) ?></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
    <div class="row mb-5"></div>
</section>
<!-- /.content -->

<?= $this->endSection();  ?>