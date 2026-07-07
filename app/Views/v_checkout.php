<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="row">
    <div class="col-lg-6">
        <?php echo form_open('buy', 'class="row g-3"'); ?>

        <?php echo form_hidden('username', session()->get('username')); ?>
        <?php echo form_input([
            'type' => 'hidden',
            'name' => 'total_harga',
            'id' => 'total_harga',
            'value' => ''
        ]); ?>

        <div class="col-12">
            <?php echo form_label('Nama', 'nama', ['class' => 'form-label']); ?>
            <?php echo form_input([
                'name' => 'nama',
                'id' => 'nama',
                'class' => 'form-control',
                'value' => session()->get('username'),
                'readonly' => true
            ]); ?>
        </div>
        <div class="col-12">
            <?php echo form_label('Alamat', 'alamat', ['class' => 'form-label']); ?>
            <?php echo form_input([
                'name' => 'alamat',
                'id' => 'alamat',
                'class' => 'form-control'
            ]); ?>
        </div>
        <div class="col-12">
            <?php echo form_label('Kelurahan', 'kelurahan', ['class' => 'form-label']); ?>
            <?= form_dropdown('kelurahan', [], '', ['id' => 'kelurahan', 'class' => 'form-control']) ?>
        </div>
        <div class="col-12">
            <?php echo form_label('Layanan', 'layanan', ['class' => 'form-label']); ?>
            <?= form_dropdown('layanan', [], '', ['id' => 'layanan', 'class' => 'form-control']) ?>
        </div>
        <div class="col-12">
            <?php echo form_label('Ongkir', 'ongkir', ['class' => 'form-label']); ?>
            <?php echo form_input([
                'name' => 'ongkir',
                'id' => 'ongkir',
                'class' => 'form-control',
                'readonly' => true
            ]); ?>
        </div>
        <div class="col-12">
            <?php echo form_submit(
                'submit',
                'Buat Pesanan',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>

        <?php echo form_close(); ?>
    </div>
    <div class="col-lg-6">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)) { ?>
                    <?php foreach ($items as $index => $item) { ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>
                                <?php if (!empty($discount)) : ?>
                                    <del class="text-muted"><?= number_to_currency($item['price'], 'IDR') ?></del><br>
                                    <span class="text-danger fw-bold"><?= number_to_currency($item['harga_diskon'], 'IDR') ?></span>
                                <?php else : ?>
                                    <?php echo number_to_currency($item['price'], 'IDR'); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $item['qty']; ?></td>
                            <td><?php echo number_to_currency($item['subtotal_diskon'], 'IDR'); ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td colspan="2"></td>
                    <td>Subtotal</td>
                    <td><?php echo number_to_currency($total, 'IDR'); ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Total</td>
                    <td><span id="total"><?php echo number_to_currency($total, 'IDR'); ?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        let ongkir = 0;
        let subtotal = <?= $total ?>;
        hitungTotal();

        function hitungTotal() {
            let total = subtotal + ongkir;

            $("#ongkir").val(ongkir);
            $("#total").text(`IDR ${total.toLocaleString('id-ID')}`);
            $("#total_harga").val(total);
        }
        $('#kelurahan').select2({
            placeholder: 'Cari daerah tujuan',
            minimumInputLength: 3,
            dropdownParent: $('body'),
            ajax: {
                url: '<?= site_url('ajax/destinations') ?>',
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return data;
                },
                cache: true
            }
        });
        $("#kelurahan").on('change', function() {
            let id_kelurahan = $(this).val();

            $("#layanan").empty();
            ongkir = 0;
            hitungTotal();

            $.ajax({
                url: "<?= site_url('ajax/costs') ?>",
                dataType: "json",
                data: {
                    destination: id_kelurahan
                },
                success: function(data) {
                    data.forEach(function(item) {
                        $("#layanan").append(
                            $('<option>', {
                                value: item.cost,
                                text: `${item.description} (${item.service}) : estimasi ${item.etd}`
                            })
                        );
                    });
                }
            });

        });
        $("#layanan").on('change', function() {
            ongkir = parseInt($(this).val());
            hitungTotal();
        });
    });
</script>
<?= $this->endSection() ?>