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

<!-- button add data -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
  <i class="bi bi-plus-circle"></i>
  Tambah Data
</button>

<!-- Table with stripped rows -->
<table class="table datatable table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Tanggal</th>
      <th scope="col">Nominal(Rp)</th>
      <th scope="col">Created At</th>
      <th scope="col">Updated At</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($diskon as $index => $diskon_item) : ?>
      <tr>
        <th scope="row"><?php echo $index + 1 ?></th>
        <td><?php echo $diskon_item['tanggal'] ?></td>
        <td>Rp <?php echo number_format($diskon_item['nominal'], 0, ',', '.') ?></td>
        <td><?php echo $diskon_item['created_at'] ?></td>
        <td><?php echo $diskon_item['updated_at'] ?></td>
        <td>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-<?= $diskon_item['id'] ?>">
            <i class="bi bi-pencil-square"></i>
          </button>
          <a href="<?= base_url('diskon/delete/' . $diskon_item['id']) ?>" class="btn btn-danger"
            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
      <!-- Edit Modal Begin -->
      <div class="modal fade" id="editModal-<?= $diskon_item['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data Diskon</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('diskon/edit/' . $diskon_item['id']) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <div class="modal-body">
                <div class="form-group mb-3">
                  <label for="tanggal">Tanggal</label>
                  <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= $diskon_item['tanggal'] ?>" required>
                </div>
                <div class="form-group mb-3">
                  <label for="nominal">Nominal</label>
                  <input type="number" name="nominal" class="form-control" id="nominal" value="<?= $diskon_item['nominal'] ?>" placeholder="Masukkan nominal diskon" required>
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
    <?php endforeach; ?>
  </tbody>
</table>

<!-- modal add data -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Diskon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('diskon') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" required>
          </div>
          <div class="form-group mb-3">
            <label for="nominal">Nominal</label>
            <input type="number" name="nominal" class="form-control" id="nominal" placeholder="Masukkan nominal diskon" required>
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
<!-- End modal add data -->
<?= $this->endSection() ?>