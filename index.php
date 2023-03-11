
<?php
//koneksi database 
$server = "localhost";
$user = "root";
$password = "";
$database = "dbcrud2022";

//buat koneksi
$koneksi = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));



$q = mysqli_query($koneksi, "SELECT nomor FROM tbuku order by nomor desc limit 1");
$datax = mysqli_fetch_array($q);
if($datax){
  $no_terakhir = substr($datax['nomor'], -3);
  $no = $no_terakhir + 1;


  if($no > 0 and $no < 10){
  $nomor = "00".$no;
}else if($no > 10 and $no < 100){
  $nomor = "0".$no;
}else if($no > 100){
  $nomor = $no;
}
}else{
  $nomor = "001";
}

$tahun = date('Y');
$vnomor = "198-".$tahun .'-'. $nomor;

?>

<?php
if(isset($_POST['bsimpan'])){

//pemgjian apakah data akan diedit
if(isset($_GET['hal'])== "edit" ){
//data akan diedit
$edit = mysqli_query($koneksi, "UPDATE tbuku SET
                                   nama = '$_POST[tnama]',
                                   jenis_hak = '$_POST[tjenis_hak]',
                                   perihal = '$_POST[tperihal]',
                                   btsu = '$_POST[tbtsu]',
                                   tanggal_pinjam = '$_POST[ttanggal_pinjam]'
                                WHERE id_buku= '$_GET[id]'
                                   ");
if($edit){
  echo "<script>
    alert('Edit data sukses!');
    document.location='index.php';
  </script>";
}else {
  echo "<script>
    alert('Edit data gagal!');
    document.location='index.php';
  </script>";
}

}else {
$simpan = mysqli_query($koneksi, " INSERT INTO tbuku (nomor, nama, jenis_hak, btsu, tanggal_pinjam)
                                     VALUE (  '$_POST[tnomor]',
                                              '$_POST[tnama]',
                                              '$_POST[tjenis_hak]',
                                              '$_POST[tbt]',
                                              '$_POST[tanggal_pinjam]'

                                           )


                                 ");

if($simpan){
  echo "<script>
    alert('Simpan data sukses!');
    document.location='index.php';
  </script>";
}else {
  echo "<script>
    alert('Simpan data gagal!');
    document.location='index.php';
  </script>";
}
}
  

}

//deklarasi variabel untuk menampung data yang akan diedit


$vnama = "";
$vjenis_hak = "";
$vbtsu = "";
$vtanggal_pinjam ="";

if(isset($_GET['hal'])) {
  

  if($_GET['hal'] == "edit"){

// tampilkan data yang akan diedit
$tampil = mysqli_query($koneksi, "SELECT * FROM tbuku WHERE id_buku = '$_GET[id]'");
$data = mysqli_fetch_array($tampil);
if($data){
  //jika data ditemukan, maka data ditampung ke dalam variabel
  $vnomor = $data['nomor'];
  $vnama = $data['nama'];
  $vjenis_hak = $data['jenis_hak'];
  $vbtsu = $data['btsu'];
  $vtanggal_pinjam = $data['tanggal_pinjam'];
}

}else if ($_GET['hal'] == "hapus") {
  $hapus = mysqli_query($koneksi, "DELETE FROM tbuku WHERE id_buku = '$_GET[id]' ");
  if($hapus){
  echo "<script>
    alert('Hapus data sukses!');
    document.location='index.php';
  </script>";
}else {
  echo "<script>
    alert('Hapus data gagal!');
    document.location='index.php';
  </script>";
}
}



}





?>






<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>


<div class="container">
    <h3 class="text-center">Sistem Informasi</h3>
    <h3 class="text-center">Peminjaman Buku Tanah</h3>

<div class="row">
  <div class="col-md-6 mx-auto">
<div class="card">
  <div class="card-header bg-dark text-light">
    Form Input Data Buku Tanah
  </div>
  <div class="card-body">
    <form method="POST">
     <div class="mb-3">
  <label class="form-label">Nomor Buku</label>
  <input type="text" name="tnomor" value="<?=$vnomor?>" class="form-control" placeholder="Masukkan Nomor Buku">
</div>

<div class="mb-3">
  <label class="form-label">Nama Peminjam</label>
  <input type="text" name="tnama" value="<?=$vnama?>" class="form-control" placeholder="Masukkan Nama Peminjam">
</div>

<div class="mb-3">
  <label class="form-label">Jenis Hak</label>
 <select class="form-select" name="tjenis_hak">
  <option value="<?=$vjenis_hak?>"><?=$vjenis_hak?></option>
  <option value="Milik">Milik</option>
  <option value="Pakai">Pakai</option>
  <option value="Wakaf">Wakaf</option>
  <option value="Guna Bangunan">Guna Bangunan</option>
</select>
</div>

<div class="row-3">
  <div class="col">
    <div class="mb-3">
      <label class="form-label">Bt/Su</label/>
     <select class="form-select" name="tbt">
  <option value="<?=$vbtsu?>"><?=$vbtsu?></option>
  <option value="Btsu">BTSU</option>
  <option value="Bt">BT</option>
  <option value="Su">SU</option>
</select>
    </div>
  </div>
<div class="col">
    <div class="mb-3">
      <label class="form-label">Tanggal Pinjam</label/>
        <input type="date" name="ttanggal_pinjam" class="form-control" placeholder="Masukkan Nomor Buku">
    </div>
  </div>

  <div class="col">
    <div class="mb-3">
      <label class="form-label">Tanggal Diterima</label/>
        <input type="date" name="ttanggal_diterima"value="<?=$vtanggal_pinjam?>"class="form-control" placeholder="Masukkan Nomor Buku">
    </div>
  </div>

<div class="text-center">
  <hr>
  <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
  <button class="btn btn-success" name="bkosongkan" type="reset">Kosongkan</button>
</div>

</div>



    </form>
  </div>
  <div class="card-footer bg-dark">
    
  </div>
</div>

  </div>
</div>


    <div class="card mt-3">
  <div class="card-header bg-danger text-light">
    Data peminjam
  </div>
  <div class="card-body">
<div class="col-md-6 mx-auto">
  <form method="POST">
    <div class="input-group mb-3">
      <input type="text" name="tcari" value="<?=@$_POST['tcari']?>"class="form-control" placeholder="Masukkan kata kunci!">
      <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
      <button class="btn btn-danger" name="breset" type="submit">Reset</button>
    </div>
  </form>
</div>

    <table class="table table-striped table-hover table-border">
      <tr>
        <th>No</th>
        <th>Nomor Buku</th>
        <th>Nama Peminjam</th>
        <th>Jenis Hak</th>
        <th>BTSU</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Aksi</th>
      </tr>

      <?php
      $no = 1; 

      //untuk pencarian data
      if(isset($_POST['bcari'])){
      $keyword = $_POST['tcari'];
      $q = "SELECT * FROM tbuku WHERE nomor like '%$keyword%' or nama like '%keyword' order by id_buku desc ";
    }else{
    $q = "SELECT * FROM tbuku order by id_buku desc"; 
  }


      $tampil = mysqli_query($koneksi, $q);
      while($data = mysqli_fetch_array($tampil)) :


      ?>

<tr>
  <td><?=$no++?></td>
  <td><?=$data['nomor']?></td>
  <td><?=$data['nama']?></td>
  <td><?=$data['jenis_hak']?></td>
  <td><?=$data['btsu']?></td>
  <td><?=$data['tanggal_pinjam']?></td>
  <td><?=$data['tanggal_kembalikan']?></td>
  <td>
    <a href="index.php?hal=edit&id=<?=$data['id_buku']?>" class="btn btn-warning">Edit</a>
    <a href="index.php?hal=hapus&id=<?=$data['id_buku']?>" class="btn btn-danger" onclick="return confrim('Apakah anda Yakin akan Hapus Data ini?')">Hapus</a>
  </td>
</tr>

<?php endwhile; ?>

    </table>
  </div>
  <div class="card-footer bg-danger">
    
  </div>
</div>

</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>