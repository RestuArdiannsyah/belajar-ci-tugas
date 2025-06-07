<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- succes session -->
<?php
if (session()->getFlashData('success')) {
?>
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <?= session()->getFlashData('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php
}
?>

<!-- failed session -->
<?php
if (session()->getFlashData('failed')) {
?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashData('failed') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php
}
?>

<div class="d-flex flex-wrap gap-2 mb-3">
  <!-- Button add data in table -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    <i class="bi bi-plus-circle"></i>
    Tambah Data
  </button>
  <!-- End Button add data in table -->
  <!-- Button to download PDF -->
  <a href="<?= base_url('produk/download') ?>" class="btn btn-danger">
    <i class="bi bi-filetype-pdf"></i> Download PDF
  </a>
</div>


<!-- Table with stripped rows -->
<table class="table datatable table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">Harga</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Foto</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>

  <tbody class="tbody-light">
    <?php foreach ($product as $index => $produk) : ?>
      <tr>
        <th scope="row"><?php echo $index + 1 ?></th>
        <td><?php echo $produk['nama'] ?></td>
        <td><?php echo "Rp " . number_format($produk['harga'], 0, ',', '.') ?></td>
        <td><?php echo $produk['jumlah'] ?> pcs</td>
        <td>
          <?php if ($produk['foto'] != '' and file_exists("img/" . $produk['foto'] . "")) : ?>
            <img src="<?php echo base_url() . "img/" . $produk['foto'] ?>" width="80px">
          <?php endif; ?>
        </td>
        <td>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-<?= $produk['id'] ?>">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-danger" onclick="if(confirm('Yakin hapus data ini ?')){window.location.href='<?= base_url('produk/delete/' . $produk['id']) ?>'}">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
      <!-- Edit Modal Begin -->
      <div class="modal fade" id="editModal-<?= $produk['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('produk/edit/' . $produk['id']) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama</label>
                  <input type="text" name="nama" class="form-control" id="nama" value="<?= $produk['nama'] ?>" placeholder="Nama Barang" required>
                </div>
                <div class="form-group">
                  <label for="name">Harga</label>
                  <input type="text" name="harga" class="form-control" id="harga" value="<?= $produk['harga'] ?>" placeholder="Harga Barang" required>
                </div>
                <div class="form-group">
                  <label for="name">Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="jumlah" value="<?= $produk['jumlah'] ?>" placeholder="Jumlah Barang" required>
                </div>
                <img src="<?php echo base_url() . "img/" . $produk['foto'] ?>" width="100px">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                  <label class="form-check-label" for="check">
                    Ceklis jika ingin mengganti foto
                  </label>
                </div>
                <div class="form-group">
                  <label for="name">Foto</label>
                  <input type="file" class="form-control" id="foto" name="foto">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Edit Modal End -->
    <?php endforeach ?>
  </tbody>
</table>
<!-- End Table with stripped rows -->
<!-- Add Modal Begin -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('produk') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Barang" required>
          </div>
          <div class="form-group">
            <label for="name">Harga</label>
            <input type="text" name="harga" class="form-control" id="harga" placeholder="Harga Barang" required>
          </div>
          <div class="form-group">
            <label for="name">Jumlah</label>
            <input type="text" name="jumlah" class="form-control" id="jumlah" placeholder="Jumlah Barang" required>
          </div>
          <div class="form-group">
            <label for="name">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Add Modal End -->
<?= $this->endSection() ?>