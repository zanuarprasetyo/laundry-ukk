<?php
include '../layouts/header.php';

function calculateTotalRevenue($koneksi)
{
    $query = "SELECT SUM(total) AS total_revenue FROM (
                SELECT (tb_paket.harga * tb_transaksi.qty) AS total
                FROM tb_transaksi
                LEFT JOIN tb_paket ON tb_transaksi.id_paket = tb_paket.id
              ) AS subquery";

    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    return $row['total_revenue'];
}

?>
    <!-- /.content-header -->
    <script>
  window.addEventListener("load", window.print());
    </script>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12 text-center">
            <div class="card">
            <div class="card-body">
                <h2><center>Data Laporan</center></h2>
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

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Kode Invoice</th>
                      <th>Nama Member</th>
                      <th>Jenis Paket</th>
                      <th>Nama Outlet</th>
                      <th>Berat Cucian</th>
                      <th>Total Bayar</th>
                      <th style="width: 150px">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $no = 1;
                    include "../koneksi.php";
                    $tb_transaksi = mysqli_query($koneksi, "SELECT * FROM tb_transaksi where dibayar='dibayar'");
                    while($d_tb_transaksi = mysqli_fetch_array($tb_transaksi)){
                        $tb_outlet = mysqli_query($koneksi, "SELECT * FROM tb_outlet where id='$d_tb_transaksi[id_outlet]'");
                        while($d_tb_outlet_d = mysqli_fetch_array($tb_outlet)){
                          $tb_member = mysqli_query($koneksi, "SELECT * FROM tb_member where id='$d_tb_transaksi[id_member]'");
                          while($d_tb_member_d = mysqli_fetch_array($tb_member)){
                            $tb_user = mysqli_query($koneksi, "SELECT * FROM tb_user where id='$d_tb_transaksi[id_user]'");
                            while($d_tb_user_d = mysqli_fetch_array($tb_user)){
                          ?>
                          <?php
                          if ($d_tb_transaksi['status'] == 'diambil') { ?>
                            <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?=$d_tb_transaksi['kode_invoice']?></td>
                      <td><?=$d_tb_member_d['nama']?></td>
                      <td>
                      <?php
                        $tb_paket = mysqli_query($koneksi, "SELECT * FROM tb_paket where id='$d_tb_transaksi[id_paket]'");
                        while($d_tb_paket_d = mysqli_fetch_array($tb_paket)){ ?>
                        <?=$d_tb_paket_d['nama_paket']?>
                        <?php } ?>
                        
                      </td>
                      <td><?=$d_tb_outlet_d['nama']?></td>
                      <td>  
                      <?=$d_tb_transaksi['qty']?>
                      <?php
                        $tb_paket = mysqli_query($koneksi, "SELECT * FROM tb_paket where id='$d_tb_transaksi[id_paket]'");
                        while($d_tb_paket_d = mysqli_fetch_array($tb_paket)){ ?>
                        <?=$d_tb_paket_d['jenis']?>
                        <?php } ?>
                      </td>
                      <td>
                      <?php
                        if ($d_tb_transaksi['id_paket'] == '0') { ?>
                      <?php } else { ?>
                        <?php
                        $tb_paket = mysqli_query($koneksi, "SELECT * FROM tb_paket where id='$d_tb_transaksi[id_paket]'");
                        while($d_tb_paket_d = mysqli_fetch_array($tb_paket)){ 
                        $a=$d_tb_paket_d['harga'];
                      }
                      $b=$d_tb_transaksi['qty'];
                      $total  = ($a*$b);
                      echo "Rp. $total"
                      ?>
                      <?php } ?>
                      
                      </td>
                      <td>
                        <table>
                          <tr>
                            <td>
                            <?php
                        if ($d_tb_transaksi['status'] == 'baru') { ?>
                          <p class="btn btn-default btn-sm">Baru</p>
                        <?php } else if ($d_tb_transaksi['status'] == 'proses') { ?>
                          <p class="btn btn-warning btn-sm">Proses</p>
                        <?php } else if ($d_tb_transaksi['status'] == 'selesai') { ?>
                          <p class="btn btn-primary btn-sm">Selesai</p>
                        <?php } else { ?>
                          <p class="btn btn-success btn-sm">Diambil</p>
                        <?php } ?>
                            </td>
                            <td>
                            <?php
                        if ($d_tb_transaksi['id_paket'] == '0') { ?>
                      <?php } else { ?>
                        <?php
                        if ($d_tb_transaksi['dibayar'] == 'dibayar') { ?>
                          <p class="btn btn-success btn-sm">Dibayar</p>
                        <?php } else { ?>
                          <p class="btn btn-danger btn-sm">Belum Dibayar</p>
                        <?php } ?>
                        <?php } ?>
                            </td>
                          </tr>
                        </table>
                        </td>
                    </tr>
                          <?php } else { ?>

                          <?php } ?>

                          
                  <div class="modal fade" id="modal-bayar<?php echo $d_tb_transaksi['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title"> Bayar Transaksi</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <p>Apakah anda sudah menerima dana transaksi sebesar <b>
                        <?php
                        $tb_paket = mysqli_query($koneksi, "SELECT * FROM tb_paket where id='$d_tb_transaksi[id_paket]'");
                        while($d_tb_paket_d = mysqli_fetch_array($tb_paket)){ ?>
                        <?php 
                        $a=$d_tb_paket_d['harga'];
                      }
                        $b=$d_tb_transaksi['qty'];
                        $total  = ($a*$b);
                        echo "Rp. $total"
                        ?>
                        </b> dari <b>
                          <?=$d_tb_member_d['nama']?></b>?</p>

                        <form method="post" action="update_bayar_transaksi.php">
                        <div class="modal-body">
                        <div class="form-group">
                        <input type="text" name="id" value="<?php echo $d_tb_transaksi['id']; ?>" hidden>
                        <input type="text" name="qty" value="<?php echo $d_tb_transaksi['qty']; ?>" hidden>
                        <input type="text" name="id_paket" value="<?php echo $d_tb_paket_d['id']; ?>" hidden>
                      </div>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-success">Bayar</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  </div>

                  <div class="modal fade" id="modal-pilih-paket<?php echo $d_tb_transaksi['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Pilih Paket</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="update_paket_pilih.php">
                        <div class="modal-body">
                        <input type="text" name="id" value="<?php echo $d_tb_transaksi['id']; ?>" hidden>
                        <div class="form-group">
                        <label>Pilih Paket</label>
                        <select name="id_paket" class="form-control" id="id_paket" required>
                          <option>-- Pilih Nama Paket --</option>
                          <?php
                            include "../koneksi.php";
                            $tb_paket = mysqli_query($koneksi, "SELECT * FROM tb_paket where id_outlet='$d_tb_outlet_d[id]'");
                            while($d_tb_paket_d_d = mysqli_fetch_array($tb_paket)){
                          ?>
                          <option value="<?=$d_tb_paket_d_d['id']?>"><?=$d_tb_paket_d_d['nama_paket']?></option>
                          <?php } ?>
                        </select>
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

                  <div class="modal fade" id="modal-status<?php echo $d_tb_transaksi['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Ubah Status Transaksi</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="update_status_transaksi.php">
                        <div class="modal-body">
                        <div class="form-group">
                        <label>Pilih Status</label>
                        <input type="text" name="id" value="<?php echo $d_tb_transaksi['id']; ?>" hidden>
                        <select class="form-control" name="status">
                          <option>-- Silahkan Pilih Status --</option>
                          <option value="baru" <?php if('baru' == $d_tb_transaksi['status']){ echo 'selected'; } ?>>Baru</option>
                          <option value="proses" <?php if('proses' == $d_tb_transaksi['status']){ echo 'selected'; } ?>>Proses</option>
                          <option value="selesai" <?php if('selesai' == $d_tb_transaksi['status']){ echo 'selected'; } ?>>Selesai</option>
                          <option value="diambil" <?php if('diambil' == $d_tb_transaksi['status']){ echo 'selected'; } ?>>Diambil</option>
                        </select>
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

                    <div class="modal fade" id="modal-batalkan<?php echo $d_tb_transaksi['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title"> Batal Bayar Transaksi</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <p>Apakah anda akan membatalkan pembayaran transaksi sebesar <b>
                        <?php
                        $tb_paket = mysqli_query($koneksi, "SELECT * FROM tb_paket where id='$d_tb_transaksi[id_paket]'");
                        while($d_tb_paket_d = mysqli_fetch_array($tb_paket)){ ?>
                        <?php 
                        $a=$d_tb_paket_d['harga'];
                      }
                        $b=$d_tb_transaksi['qty'];
                        $c=$d_tb_transaksi['biaya_tambahan'];
                        $total  = ($a*$b)+$c;
                        echo "Rp. $total"
                        ?>

                        </b> dari <b>
                          <?=$d_tb_member_d['nama']?></b>?</p>
                          <form method="post" action="update_batal_bayar_transaksi.php">
                        <div class="modal-body">
                        <div class="form-group">
                        <input type="text" name="id" value="<?php echo $d_tb_transaksi['id']; ?>" hidden>
                      </div>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-success">Batalkan</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  </div>

                  <div class="modal fade" id="modal-hapus<?php echo $d_tb_transaksi['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hapus Data Transaksi</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data <b><?php echo $d_tb_transaksi['kode_invoice']; ?></b> ini?</p>
                         </div>
                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <a href="hapus_transaksi.php?id=<?php echo $d_tb_transaksi['id']; ?>" class="btn btn-outline-success"> Delete </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="modal-edit<?php echo $d_tb_transaksi['id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Transaksi</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="update_transaksi.php">
                        <div class="form-group">
                            <label>Invoice</label>
                            <input type="text" name="id" class="form-control" value="<?php echo $d_tb_transaksi['id']; ?>" hidden>
                            <input type="text" name="kode_invoice" class="form-control" value="<?php echo $d_tb_transaksi['kode_invoice']; ?>" readonly="">
                          </div>

                        <div class="form-group">
                        <label>Pilih Member</label>
                        <select class="form-control" name="id_member">
                          <option>-- Pilih Nama Member --</option>
                          <?php
                            include "../koneksi.php";
                            $tb_member = mysqli_query($koneksi, "SELECT * FROM tb_member");
                            while($d_tb_member = mysqli_fetch_array($tb_member)){
                          ?>
                          <option value="<?=$d_tb_member['id']?>" <?php if($d_tb_member['id'] == $d_tb_transaksi['id_member']){ echo 'selected'; } ?>><?=$d_tb_member['nama']?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Pilih Outlet</label>
                        <select name="id_outlet" class="form-control" required>
                          <option>-- Pilih Nama Outlet --</option>
                          <?php
                            include "../koneksi.php";
                            $tb_user = mysqli_query($koneksi, "SELECT * FROM tb_user where username='$_SESSION[username]'");
                            while($d_tb_user = mysqli_fetch_array($tb_user)){
                            $tb_outlet = mysqli_query($koneksi, "SELECT * FROM tb_outlet where id='$d_tb_user[id_outlet]'");
                            while($d_tb_outlet_d_d = mysqli_fetch_array($tb_outlet)){
                          ?>
                          <option value="<?=$d_tb_outlet_d_d['id']?>"><?=$d_tb_outlet_d_d['nama']?></option>
                          <?php } } ?>
                        </select>
                      </div>

                          <div class="form-group">
                            <label>Berat</label>
                            <input type="text" name="qty" value="<?php echo $d_tb_transaksi['qty']; ?>" class="form-control" placeholder="Masukkan Berat">
                          </div>

                          <div class="form-group">
                          <?php 
                            include "../koneksi.php";
                              $tb_user = mysqli_query($koneksi, "SELECT * FROM tb_user where username='$_SESSION[username]'");
                              while($d_tb_user = mysqli_fetch_array($tb_user)){ ?>
                            <input type="text" name="id_user" value="<?php echo $d_tb_transaksi['id_user']; ?>" class="form-control" hidden>
                            <?php }  ?>
                          </div>

                         <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-success">Simpan</button>
                        </div>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                  
                  <?php } } } }  ?>

                  <div class="modal fade" id="modal-tambah">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">  
                          <h4 class="modal-title">Tambah Data Transaksi</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="simpan_transaksi.php">

                        <div class="form-group">
                            <label>Invoice</label>
                            <input type="text" name="kode_invoice" class="form-control" value="INV<?php echo date('dmyHis') ?>" readonly="">
                          </div>

                        <div class="form-group">
                        <label>Pilih Member</label>
                        <select class="form-control" name="id_member">
                          <option>-- Pilih Nama Member --</option>
                          <?php
                            include "../koneksi.php";
                            $tb_member = mysqli_query($koneksi, "SELECT * FROM tb_member");
                            while($d_tb_member = mysqli_fetch_array($tb_member)){
                          ?>
                          <option value="<?=$d_tb_member['id']?>"><?=$d_tb_member['nama']?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Pilih Outlet</label>
                        <select name="id_outlet" class="form-control" id="id_outlet" required>
                          <option>-- Pilih Nama Outlet --</option>
                          <?php
                            include "../koneksi.php";
                            $tb_user = mysqli_query($koneksi, "SELECT * FROM tb_user where username='$_SESSION[username]'");
                            while($d_tb_user = mysqli_fetch_array($tb_user)){
                            $tb_outlet = mysqli_query($koneksi, "SELECT * FROM tb_outlet where id='$d_tb_user[id_outlet]'");
                            while($d_tb_outlet = mysqli_fetch_array($tb_outlet)){
                          ?>
                          <option value="<?=$d_tb_outlet['id']?>"><?=$d_tb_outlet['nama']?></option>
                          <?php } } ?>
                        </select>
                      </div>
                      
                      <div class="form-group">
                            <label>Berat</label>
                            <input type="text" name="qty" class="form-control" placeholder="Masukkan Berat">
                          </div>
                        

                          <div class="form-group">
                          <?php
                            include "../koneksi.php";
                            $tb_user = mysqli_query($koneksi, "SELECT * FROM tb_user where username='$_SESSION[username]'");
                            while($d_tb_user = mysqli_fetch_array($tb_user)){ ?>
                            <input type="text" name="id_user" value="<?php echo $d_tb_user['id']; ?>" class="form-control" hidden>
                            <?php } ?>
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

<?php
  ?>

  <!-- 44:42 -->

  