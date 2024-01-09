<?php
include '../layouts/header.php';
include '../layouts/navbar.php';

function displaySearchWarning() {
  echo '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
          Data tidak ditemukan.
        </div>';
}
?>

<script>
          // refresh halaman setelah melakukan search engine
          window.onload = function() {
              if (performance.navigation.type === 1) {
                  // Redirect ke halaman yg sama setelah di refresh
                  window.location.href = 'pelanggan.php';
              }
          };
      </script>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pelanggan</h1>
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
                <h3 class="card-title">Data Pelanggan</h3>
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
                      <th style="width: 10px">#</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Jenis Kelamin</th>
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
                    $tb_member = mysqli_query($koneksi, "SELECT * FROM tb_member WHERE 
                    -- search engine berdasarkan
                    nama LIKE '%$cari%' OR
                    alamat LIKE '%$cari%' OR
                    jenis_kelamin LIKE '%$cari%' OR
                    tlp LIKE '%$cari%'
                    ");
                    if (mysqli_num_rows($tb_member) == 0) {
                      displaySearchWarning();
                  }
                  } else {
                    $tb_member = mysqli_query($koneksi, "SELECT * FROM tb_member");
                  }

                    while($d_tb_member = mysqli_fetch_array($tb_member)){
                      ?>
                      
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?=$d_tb_member['nama']?></td>
                      <td><?=$d_tb_member['alamat']?></td>
                      <td>
                        <?php
                        if ($d_tb_member['jenis_kelamin'] == 'L') { ?>
                        Laki - Laki
                        <?php } else{ ?>
                          Perempuan
                        <?php } ?>
                      </td>
                      <td><?=$d_tb_member['tlp']?></td>
                      <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit<?php echo $d_tb_member['id']; ?>"><i class="fas fa-edit"></i> Edit </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus<?php echo $d_tb_member['id']; ?>"><i class="fas fa-trash"></i> Delete </button>
                      </td>
                    </tr>

                    <div class="modal fade" id="modal-hapus<?php echo $d_tb_member['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hapus Data Pelanggan</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data <b><?php echo $d_tb_member['nama']; ?></b> ? </p>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <a href="hapus_pelanggan.php?id=<?php echo $d_tb_member['id']; ?>" class="btn btn-outline-success"> Delete </a>
                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="modal fade" id="modal-edit<?php echo $d_tb_member['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Pelanggan</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="update_pelanggan.php">
                        <div class="modal-body">
                        <div class="form-group">
                          <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" name="id" value="<?php echo $d_tb_member['id']; ?>" hidden>
                            <input type="text" name="nama" class="form-control" value="<?php echo $d_tb_member['nama']; ?>" placeholder="Masukkan Nama Pelanggan">
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3"><?php echo $d_tb_member['alamat']; ?></textarea>
                          </div>
                        <label>Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin" value="<?php echo $d_tb_member['jenis_kelamin']; ?>">
                          <option>- Pilih Jenis Kelamin -</option>
                          <option value="L" <?php if('L' == $d_tb_member['jenis_kelamin']){ echo 'selected'; } ?>>Laki - Laki</option>
                          <option value="P" <?php if('P' == $d_tb_member['jenis_kelamin']){ echo 'selected'; } ?>>Perempuan</option>
                        </select>
                      </div>
                          <div class="form-group">
                            <label>Telepon</label>
                            <input type="number" name="tlp" class="form-control" value="<?php echo $d_tb_member['tlp']; ?>" placeholder="Masukkan No Telepon">
                          </div>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-success">Update</button>
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
                          <h4 class="modal-title">Tambah Data Pelanggan</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="simpan_pelanggan.php">
                        <div class="modal-body">
                        <div class="form-group">
                          <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Pelanggan">
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"></textarea>
                          </div>
                        <label>Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin">
                          <option>- Pilih Jenis Kelamin -</option>
                          <option value="L">Laki - Laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                          <div class="form-group">
                            <label>Telepon</label>
                            <input type="number" name="tlp" class="form-control" placeholder="Masukkan No Telepon">
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

  
