<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

Kelola Seluruh Data Pembelian

<hr>
<div class="table-responsive">
    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Pembelian</th>
                <th scope="col">Username</th>
                <th scope="col">Waktu Pembelian</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Alamat</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($transactions)) :
                foreach ($transactions as $index => $item) :
            ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['username'] ?></td>
                        <td><?= $item['created_at'] ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= $item['alamat'] ?></td>
                        <td>
                            <?= ($item['status'] == "1")
                                ? '<span class="badge bg-success">Sudah Selesai</span>'
                                : '<span class="badge bg-warning">Belum Selesai</span>' ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal-<?= $item['id'] ?>">
                                Ubah Status
                            </button>
                        </td>
                    </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>

<?php if (!empty($transactions)) : ?>

    <?php foreach ($transactions as $item) : ?>

        <!-- Detail Modal Begin -->
        <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Transaksi #<?= $item['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($products[$item['id']])) : ?>
                            <?php foreach ($products[$item['id']] as $index2 => $item2) : ?>
                                <?= $index2 + 1 . ")" ?>

                                <?php
                                $imagePath = FCPATH . 'img/' . $item2['foto'];

                                if (!empty($item2['foto']) && file_exists($imagePath)) :
                                ?>
                                    <div class="my-2">
                                        <img src="<?= base_url('img/' . $item2['foto']) ?>" width="100" class="img-thumbnail">
                                    </div>
                                <?php endif; ?>

                                <strong><?= $item2['nama'] ?></strong>
                                <?= number_to_currency($item2['harga'], 'IDR') ?>
                                <br>
                                <?= "(" . $item2['jumlah'] . " pcs)" ?><br>
                                <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                <hr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        Ongkir <?= number_to_currency($item['ongkir'], 'IDR') ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Detail Modal End -->

        <!-- Status Modal Begin -->
        <div class="modal fade" id="statusModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Status Transaksi #<?= $item['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?= form_open('kelola-transaksi/status/' . $item['id']) ?>
                    <?= csrf_field() ?>

                    <div class="modal-body">
                        <div class="mb-3">
                            <?= form_label('Status', 'status') ?>
                            <?= form_dropdown('status', [
                                '0' => 'Belum Selesai',
                                '1' => 'Sudah Selesai'
                            ], $item['status'], ['id' => 'status', 'class' => 'form-control']) ?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <?= form_submit('submit', 'Simpan', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <!-- Status Modal End -->

    <?php endforeach; ?>

<?php endif; ?>
<?= $this->endSection() ?>