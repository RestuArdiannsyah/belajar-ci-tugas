<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
History Transaksi Pembelian <strong><?= $username ?></strong>
<hr>
<div class="table-responsive">
  <!-- Table with stripped rows -->
  <table class="table datatable table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">ID Pembelian</th>
        <th scope="col">Waktu Pembelian</th>
        <th scope="col">Total Bayar</th>
        <th scope="col">Alamat</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($buy)) :
        foreach ($buy as $index => $item) :
      ?>
          <tr>
            <th scope="row"><?php echo $index + 1 ?></th>
            <td><?php echo $item['id'] ?></td>
            <td><?php echo $item['created_at'] ?></td>
            <td><?php echo number_to_currency($item['total_harga'], 'IDR') ?></td>
            <td><?php echo $item['alamat'] ?></td>
            <td><?php echo ($item['status'] == "1") ? "Sudah Selesai" : "Belum Selesai" ?></td>
            <td>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                Detail
              </button>
            </td>
          </tr>
          <!-- Detail Modal Begin -->
          <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Detail Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <?php
                  if (!empty($product)) {
                    foreach ($product[$item['id']] as $index2 => $item2) : ?>
                      <!-- untuk menampilkan nomor pesanan -->
                      <!-- <?php echo $index2 + 1 . ")" ?> -->
                      <?php if ($item2['foto'] != '' and file_exists("img/" . $item2['foto'] . "")) : ?>
                        <img src="<?php echo base_url() . "img/" . $item2['foto'] ?>" width="100px" class="rounded" alt="Foto Produk">
                      <?php endif; ?>
                      <strong><?= $item2['nama'] ?></strong>
                      <span class="bg-primary p-1 rounded text-white"><?= number_to_currency($item2['harga'], 'IDR') ?></span>
                      <br>
                      <div class="mt-2">
                        <?= "(" . $item2['jumlah'] . " pcs)" ?>
                        <span class="bg-primary p-1 rounded text-white">
                          <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                        </span>
                      </div>
                      <hr>
                  <?php
                    endforeach;
                  }
                  ?>
                  Ongkir <?= number_to_currency($item['ongkir'], 'IDR') ?>
                </div>
              </div>
            </div>
          </div>
          <!-- Detail Modal End -->
      <?php
        endforeach;
      endif;
      ?>
    </tbody>
  </table>
  <!-- End Table with stripped rows -->
</div>
<?= $this->endSection() ?>