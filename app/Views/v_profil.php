<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Tampilkan pesan alert -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
      <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          <!-- Foto Profil -->
          <img src="<?= base_url('img/profil/' . session()->get('foto_profil')); ?>" alt="Profile" class="rounded-circle">

          <!-- Nama -->
          <h2><?= esc($user['username'] ?? 'Nama Pengguna') ?></h2>

          <!-- Posisi -->
          <h3 class="mt-2"><?= esc($user['posisi']) ?></h3>
        </div>
      </div>

      <a class="dropdown-item d-flex align-items-center" href="logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
      </a>
    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
            </li>

          </ul>

          <div class="tab-content pt-2">
            <!-- Profile Overview -->
            <div class="tab-pane fade show active profile-overview" id="profile-overview">

              <?php if (!empty($user['bio'])): ?>
                <h5 class="card-title">Bio</h5>
                <p class="small fst-italic"><?= nl2br(esc($user['bio'])) ?></p>
              <?php endif; ?>

              <h5 class="card-title">Profile Details</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Nama Lengkap</div>
                <div class="col-lg-9 col-md-8"><?= esc($user['username'] ?? '-') ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?= esc($user['email'] ?? '-') ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">No HP</div>
                <div class="col-lg-9 col-md-8"><?= esc($user['no_hp'] ?? '-') ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Posisi</div>
                <div class="col-lg-9 col-md-8"><?= esc($user['posisi'] ?? '-') ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Role</div>
                <div class="col-lg-9 col-md-8"><?= esc($user['role'] ?? 'Member') ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Tanggal Bergabung</div>
                <div class="col-lg-9 col-md-8">
                  <?php if (!empty($user['created_at'])): ?>
                    <?= date('d F Y', strtotime($user['created_at'])) ?>
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </div>
              </div>

            </div>

            <!-- Profile Edit Form -->
            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

              <!-- Form Edit Foto -->
              <form action="<?= base_url('profil/edit/foto') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                  <div class="col-md-8 col-lg-9">
                    <!-- Preview Foto -->
                    <?php if (!empty($user['foto_profil']) && file_exists('img/profil/' . $user['foto_profil'])): ?>
                      <img src="<?= base_url('img/profil/' . $user['foto_profil']) ?>" alt="Profile" style="width: 120px; height: 120px; object-fit: cover;">
                    <?php else: ?>
                      <img src="<?= base_url('assets/img/profile-img.jpg') ?>" alt="Profile" style="width: 120px; height: 120px; object-fit: cover;">
                    <?php endif; ?>

                    <div class="pt-2">
                      <!-- Input File -->
                      <input type="file" name="foto_profil" id="foto_profil" class="form-control mb-2" accept="image/*">
                      <button type="submit" class="btn btn-primary btn-sm" title="Upload new profile image">
                        <i class="bi bi-upload"></i> Upload
                      </button>

                      <?php if (!empty($user['foto_profil'])): ?>
                        <a href="<?= base_url('profil/hapus/foto') ?>" class="btn btn-danger btn-sm ms-1"
                          title="Hapus Profil Saya" onclick="return confirm('Yakin ingin menghapus foto profil?')">
                          <i class="bi bi-trash"></i> Hapus
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </form>

              <!-- Form Edit Info -->
              <form action="<?= base_url('profil/edit/info') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Username -->
                <div class="row mb-3">
                  <label for="username" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="username" type="text" class="form-control" id="username"
                      value="<?= old('username', $user['username'] ?? '') ?>" required>
                  </div>
                </div>

                <!-- Bio -->
                <div class="row mb-3">
                  <label for="bio" class="col-md-4 col-lg-3 col-form-label">Bio</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="bio" class="form-control" id="bio" style="height: 100px"
                      placeholder="Ceritakan tentang diri Anda..."><?= old('bio', $user['bio'] ?? '') ?></textarea>
                  </div>
                </div>

                <!-- Email -->
                <div class="row mb-3">
                  <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control" id="email"
                      value="<?= old('email', $user['email'] ?? '') ?>" required>
                  </div>
                </div>

                <!-- No HP -->
                <div class="row mb-3">
                  <label for="no_hp" class="col-md-4 col-lg-3 col-form-label">No HP</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="no_hp" type="text" class="form-control" id="no_hp"
                      value="<?= old('no_hp', $user['no_hp'] ?? '') ?>" required>
                  </div>
                </div>

                <!-- Posisi -->
                <div class="row mb-3">
                  <label for="posisi" class="col-md-4 col-lg-3 col-form-label">Posisi</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="posisi" type="text" class="form-control" id="posisi"
                      value="<?= old('posisi', $user['posisi'] ?? '') ?>" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label"></label>
                  <div class="col-md-8 col-lg-9">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                  </div>
                </div>
              </form><!-- End Profile Edit Form -->

            </div>

            <!-- Change Password Form -->
            <div class="tab-pane fade pt-3" id="profile-change-password">

              <form action="<?= base_url('profil/edit/password') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row mb-3">
                  <label for="password_lama" class="col-md-4 col-lg-3 col-form-label">Old Password</label>
                  <div class="col-md-8 col-lg-9">
                    <div class="input-group">
                      <input name="password_lama" type="password" class="form-control" id="password_lama" required>
                      <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_lama')">
                        <i class="bi bi-eye" id="icon_password_lama"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="password_baru" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <div class="input-group">
                      <input name="password_baru" type="password" class="form-control" id="password_baru" required>
                      <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_baru')">
                        <i class="bi bi-eye" id="icon_password_baru"></i>
                      </button>
                    </div>
                    <small class="text-muted">Minimal 7 karakter</small>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="konfirmasi_password" class="col-md-4 col-lg-3 col-form-label">Confirm New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <div class="input-group">
                      <input name="konfirmasi_password" type="password" class="form-control" id="konfirmasi_password" required>
                      <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('konfirmasi_password')">
                        <i class="bi bi-eye" id="icon_konfirmasi_password"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label"></label>
                  <div class="col-md-8 col-lg-9">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                  </div>
                </div>
              </form>

              <script>
                function togglePassword(inputId) {
                  const input = document.getElementById(inputId);
                  const icon = document.getElementById('icon_' + inputId);

                  if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                  } else {
                    input.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                  }
                }
              </script>

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
</section>

<script>
  // Preview foto sebelum upload
  document.getElementById('foto_profil').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const img = document.querySelector('img[alt="Profile"]');
        img.src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  });
</script>

<?= $this->endSection() ?>