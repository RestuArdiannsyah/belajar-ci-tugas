<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashData('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php
}
?>
<?php echo form_open('keranjang/edit') ?>
<!-- Table with stripped rows -->
<table class="table datatable table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Nama</th>
      <th scope="col">Foto</th>
      <th scope="col">Harga</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Subtotal</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    if (!empty($items)) :
      foreach ($items as $index => $item) :
    ?>
        <tr>
          <td><?php echo $item['name'] ?></td>
          <td><img src="<?php echo base_url() . "img/" . $item['options']['foto'] ?>" width="100px"></td>
          <td><?php echo number_to_currency($item['price'], 'IDR') ?></td>
          <td><input type="number" min="1" name="qty<?php echo $i++ ?>" class="form-control" value="<?php echo $item['qty'] ?>"></td>
          <td><?php echo number_to_currency($item['subtotal'], 'IDR') ?></td>
          <td>
            <a href="<?php echo base_url('keranjang/delete/' . $item['rowid'] . '') ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
    <?php
      endforeach;
    endif;
    ?>
  </tbody>
</table>
<!-- End Table with stripped rows -->
<div class="alert alert-info">
  <?php echo "Total = " . number_to_currency($total, 'IDR') ?>
</div>

<div class="d-flex justify-content-between mb-3">
  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> Perbarui Keranjang</button>
    <a class="btn btn-warning" href="<?php echo base_url() ?>keranjang/clear"><i class="bi bi-cart-x"></i> Kosongkan Keranjang</a>
  </div>
  <div class="d-flex gap-2">
    <?php if (!empty($items)) : ?>
      <a class="btn btn-success" href="<?php echo base_url() ?>checkout"><i class="bi bi-check-circle"></i> Selesai Belanja</a>
    <?php endif; ?>
  </div>
</div>
<?php echo form_close() ?>
<?= $this->endSection() ?>