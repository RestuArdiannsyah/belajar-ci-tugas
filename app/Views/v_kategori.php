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
      <th scope="col">Nama</th>
      <th scope="col">Created At</th>
      <th scope="col">Updated At</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($kategori as $index => $kategori) : ?>
      <tr>
        <th scope="row"><?php echo $index + 1 ?></th>
        <td><?php echo $kategori['nama'] ?></td>
        <td><?php echo $kategori['created_at'] ?></td>
        <td><?php echo $kategori['updated_at'] ?></td>
        <td>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-<?= $kategori['id'] ?>">
            <i class="bi bi-pencil-square"></i>
          </button>
          <a href="<?= base_url('kategori/delete/' . $kategori['id']) ?>" class="btn btn-danger"
            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
      <!-- Edit Modal Begin -->
      <div class="modal fade" id="editModal-<?= $kategori['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data Kategori</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('kategori/edit/' . $kategori['id']) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama</label>
                  <input type="text" name="nama" class="form-control" id="nama" value="<?= $kategori['nama'] ?>" placeholder="Nama Kategori" required>
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
        <h5 class="modal-title">Tambah Data Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('kategori') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Kategori" required>
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