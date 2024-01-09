<?php
include '../layouts/header.php';
include '../layouts/navbar.php';
?>

    <script>
          // refresh halaman setelah melakukan search engine
          window.onload = function() {
              if (performance.navigation.type === 1) {
                  // Redirect ke halaman yg sama setelah di refresh
                  window.location.href = 'pengguna.php';
              }
          };
      </script>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengguna</h1>
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
                <h3 class="card-title">Data Pengguna</h3>
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
                      <th>Username</th>
                      <th>Nama Outlet</th>
                      <th>Akses</th>
                      <th style="width: 200px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                                    $no = 1;
                                    include "../koneksi.php";

                                    if (isset($_POST['search'])) {
                                        $keyword = $_POST['cari'];
                                        $result = mysqli_query($koneksi, "SELECT * FROM tb_user 
                                        WHERE (nama LIKE '%$keyword%' OR username LIKE '%$keyword%'  OR id_outlet IN (SELECT id FROM tb_outlet WHERE nama LIKE '%$keyword%'))");
                                        if (mysqli_num_rows($result) == 0) {
                                          echo '<div class="alert alert-danger alert-dismissible">
                                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                  <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
                                                  Data tidak ditemukan.
                                                </div>';
                                      }
                                    } else {
                                        $result = mysqli_query($koneksi, "SELECT * FROM tb_user");
                                    }

                                    while ($d_tb_user = mysqli_fetch_array($result)) {
                                        $tb_outlet_d = mysqli_query($koneksi, "SELECT * FROM tb_outlet where id='$d_tb_user[id_outlet]'");
                                        while ($d_tb_outlet_d = mysqli_fetch_array($tb_outlet_d)) {
                                    ?>

                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?=$d_tb_user['nama']?></td>
                      <td><?=$d_tb_user['username']?></td>
                      <td><?=$d_tb_outlet_d['nama']?></td> 
                      <td><?=$d_tb_user['role']?></td>
                      <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit<?php echo $d_tb_user['id']; ?>"><i class="fas fa-edit"></i> Edit </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus<?php echo $d_tb_user['id']; ?>"><i class="fas fa-trash"></i> Delete </button>
                      </td>
                    </tr>

                    <div class="modal fade" id="modal-hapus<?php echo $d_tb_user['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hapus Data Pengguna</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data ini?</p>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <a href="hapus_pengguna.php?id=<?php echo $d_tb_user['id']; ?>" class="btn btn-outline-success"> Delete </a>
                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="modal fade" id="modal-edit<?php echo $d_tb_user['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Pengguna</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="update_pengguna.php">
                        <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Pengguna</label>
                            <input type="text" name="id" value="<?php echo $d_tb_user['id']; ?>" hidden>
                            <input type="text" name="nama" class="form-control" value="<?php echo $d_tb_user['nama']; ?>" placeholder="Masukkan Nama Pengguna">
                          </div>
                          <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $d_tb_user['username']; ?>" placeholder="Masukkan Username">
                          </div>
                          <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required="">
                          </div>
                          
                          <div class="form-group">
                        <label>Nama Outlet</label>
                       <select name="id_outlet" class="form-control">
                        <option>---Pilih Nama Outlet---</option>
                        <?php
                    include "../koneksi.php";
                    $tb_outlet =mysqli_query($koneksi, "SELECT * FROM  tb_outlet");
                    while($d_tb_outlet = mysqli_fetch_array($tb_outlet)){
                      ?>
                          <option value="<?=$d_tb_outlet['id']?>" <?php if($d_tb_outlet['id'] == $d_tb_user['id_outlet']){ echo 'selected'; } ?>>
                          <?=$d_tb_outlet['nama']?></option>
                          <?php } ?>
                    </select>
                      </div>

                        <div class="form-group">
                        <label>Akses</label>
                        <select class="form-control" name="role">
                          <option>-- Pilih Akses -- </option>
                          <option value="admin" <?php if('admin' == $d_tb_user['role']){ echo 'selected'; } ?>>Admin</option>
                          <option value="kasir" <?php if('kasir' == $d_tb_user['role']){ echo 'selected'; } ?>>Kasir</option>
                          <option value="owner" <?php if('owner' == $d_tb_user['role']){ echo 'selected'; } ?>>Owner</option>
                        </select>
                      </div>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">Update</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php }} ?>

                    <div class="modal fade" id="modal-tambah">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Tambah Data Pengguna</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="simpan_pengguna.php">
                        <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Pengguna</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Pengguna">
                          </div>
                          <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username">
                          </div>
                          <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                          </div>
                        <div class="form-group">
                      <label>Nama Outlet</label>
                      <select class="form-control" name="id_outlet">
                        <option>- Pilih Nama Outlet -</option>

                        <?php
                      include "../koneksi.php";
                      $tb_outlet = mysqli_query($koneksi, "SELECT * FROM tb_outlet");
                      while($d_tb_outlet = mysqli_fetch_array($tb_outlet)){
                        ?>
                        <option value="<?=$d_tb_outlet['id']?>"><?=$d_tb_outlet['nama']?></option>
                        <?php } ?>

                        </select>
                    </div>
                        <div class="form-group">
                        <label>Akses</label>
                        <select class="form-control" name="role">
                          <option>- Pilih Akses - </option>
                          <option value="admin">Admin</option>
                          <option value="kasir">Kasir</option>
                          <option value="owner">Owner</option>
                        </select>
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