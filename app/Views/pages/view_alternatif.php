<h1>Hasil Perhitungan Weighted Product</h1>

<table>
    <thead>
        <tr>
            <th>Alternatif</th>
            <th>Vektor S</th>
            <th>Preferensi Vektor</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($preferensi_v as $id_alternatif => $v): ?>
        <tr>
            <td><?= $alternatif[$id_alternatif]['nama_alternatif'] ?></td>
            <td><?= number_format($vektor_s[$id_alternatif], 4) ?></td>
            <td><?= number_format($v, 4) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
