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
                    <li class="breadcrumb-item active">Hasil Perhitungan Metode WP</li>
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
                <h3 class="card-title">Hasil Perhitungan Metode WP</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Alternatif</th>
                            <th>Alternatif</th>
                            <th>Vektor S</th>
                            <th>Preferensi Vektor</th>
                            <th>Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($preferensi_v as $id_alternatif => $v): ?>
                            <tr>
                                <td>X<?= $counter++ ?></td>
                                <td><?= $alternatif[$id_alternatif]['nama_alternatif'] ?></td>
                                <td><?= number_format($vektor_s[$id_alternatif], 9) ?></td>
                                <td><?= number_format($v, 9) ?></td>
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
</section>
<!-- /.content -->

<?= $this->endSection();  ?>