<?php
include '../layouts/header.php';
include '../layouts/navbar.php';
?>  

  <script>

    // validasi angka bahwa angka yang diinputkan hanya dapat angka saja
function validateInput(input) {
    // Remove non-numeric characters
    var sanitizedInput = input.value.replace(/[^0-9]/g, '');

    // Check if the sanitized input is different from the original input
    if (sanitizedInput !== input.value) {
        alert('Inputan harus angka!!');
    }

    // Update the input value with the sanitized input
    input.value = sanitizedInput;
}

      // refresh halaman setelah melakukan search engine
      window.onload = function() {
          if (performance.navigation.type === 1) {
              // Redirect ke halaman yg sama setelah di refresh
              window.location.href = 'outlet.php';
          }
      };
  </script>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Outlet</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Outlet</h3>
                <div class="card-tools">
                  <div>
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data </button>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              <?php
      if(isset($_GET['info'])){
        if($_GET['info'] == "delete"){ ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-trash"></i>Sukses</h5>
          Berhasil Menghapus Data
        </div>
      <?php } else if($_GET['info'] == "simpan"){ ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i>Sukses</h5>
          Berhasil Menambahkan Data
        </div>
      <?php }else if($_GET['info'] == "update"){ ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-edit"></i>Sukses</h5>
          Update Data Berhasil
        </div>
        <?php } } ?>

        <!-- search engine -->
        <form action="" method="post">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
              <div class="input-group-prepend">
                <button type="submit" name="search" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
        </form>
        <!-- akhir search engine -->

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Telepon</th>
                      <th style="width: 200px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    include "../koneksi.php";

                    // fitur search
                  if(isset($_POST['search'])){
                    $cari = mysqli_real_escape_string($koneksi, $_POST['cari']);
                    $tb_outlet = mysqli_query($koneksi, "SELECT * FROM tb_outlet WHERE 
                    -- search engine berdasarkan
                    nama LIKE '%$cari%' OR
                    alamat LIKE '%$cari%' OR
                    tlp LIKE '%$cari%'
                    ");
                  } else {
                    $tb_outlet = mysqli_query($koneksi, "SELECT * FROM tb_outlet");
                  }

                    while($d_tb_outlet = mysqli_fetch_array($tb_outlet)){
                      ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?=$d_tb_outlet['nama']?></td>
                      <td><?=$d_tb_outlet['alamat']?></td>
                      <td><?=$d_tb_outlet['tlp']?></td>
                      <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit<?php echo $d_tb_outlet['id']; ?>"><i class="fas fa-edit"></i> Edit </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus<?php echo $d_tb_outlet['id']; ?>"><i class="fas fa-trash"></i> Delete </button>
                      </td>
                    </tr>

                    <div class="modal fade" id="modal-hapus<?php echo $d_tb_outlet['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hapus Data Outlet</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data <b><?php echo $d_tb_outlet['nama']; ?></b> ini?</p>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                            <a href="hapus_outlet.php?id=<?php echo $d_tb_outlet['id']; ?>" class="btn btn-outline-success"> Delete </a>
                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="modal fade" id="modal-edit<?php echo $d_tb_outlet['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Outlet</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="update_outlet.php">
                        <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="id" value="<?php echo $d_tb_outlet['id']; ?>" hidden>
                            <input type="text" name="nama" class="form-control" value="<?php echo $d_tb_outlet['nama']; ?>" placeholder="Masukkan Nama" required>
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" required><?php echo $d_tb_outlet['alamat']; ?></textarea>
                          </div>
                          <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="tlp" value="<?php echo $d_tb_outlet['tlp']; ?>"  class="form-control" placeholder="Masukkan Telepon" oninput="validateInput(this)" required>
                          </div>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-success">Simpan</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>

                    <div class="modal fade" id="modal-tambah">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Tambah Data Outlet</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="simpan_outlet.php">
                        <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" required></textarea>
                          </div>
                          <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="tlp" class="form-control" placeholder="Masukkan Telepon" oninput="validateInput(this)" required>
                          </div>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-success">Simpan</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  </tbody>
                </table>

                <?php
              if (mysqli_num_rows($tb_outlet) == 0 && isset($_POST['search'])) {
                  // Tampilkan alert jika tidak ada hasil pencarian
                  ?>
                  <div class="alert alert-danger alert-dismissible mt-3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
                      Data yang anda cari tidak ditemukan
                  </div>
                  <?php
              }
              ?>

                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <!-- Modal Tombol Logout -->
<div class="modal fade" id="modal-logout" tabindex="-1" role="dialog" aria-labelledby="modal-logout-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi Logout</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin logout?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <a href="../index.php" class="btn btn-outline-success">Yes</a>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

  <?php
  include '../layouts/footer.php';
  ?>

  
