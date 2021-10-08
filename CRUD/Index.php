<?php
    $host      = "localhost";
    $user      = "root";
    $pw        = "";
    $db        = "db_mahasiswa";
    
    $koneksi = mysqli_connect($host, $user, $pw, $db);

    if (!$koneksi) {
        die("Gagal Menghubungkan dengan Database.....");
    }else {
        // echo("Berhasil Menghubungan dengan Database");
    }
$nim        = "";
$nama       = "";
$alamat     = "";
$jurusan    = "";
$error      = "";
$success    = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
}else {
    $op = "";
}

if ($op == 'Ubah') {
    $id          = $_GET['id'];
    $sql1        = "select * from mahasiswa where id = '$id'";
    $q1          = mysqli_query($koneksi,$sql1);
    $r1          = mysqli_fetch_array($q1);
    $nim         = $r1['NIM'];
    $nama        = $r1['Nama'];
    $jurusan     = $r1['Jurusan'];
    $alamat      = $r1['Alamat'];
    if ($nim == '') {
        $error = "Data Tidak Ditemukan";
    }
}elseif ($op == 'Hapus') {
    $id          = $_GET['id'];
    $sql1        = "delete from mahasiswa where id = '$id'";
    $q1          = mysqli_query($koneksi,$sql1);
    if ($q1) {
        $success = "Berhasil Menghapus Data";
    }else {
        $error   = "Gagal Menghapus Data";
    }
}
if (isset($_POST['simpan'])) {//create data
    $nim        = $_POST['nim'];
    $nama       = $_POST['nama'];
    $jurusan    = $_POST['jurusan'];
    $alamat     = $_POST['alamat'];

    if ($nim && $nama && $alamat && $jurusan) {
        if ($op == "Ubah") { //untuk update
            $sql1   = "update mahasiswa set nim = '$nim', nama='$nama', jurusan='$jurusan', alamat='$alamat' where id = '$id'";
            $q1     = mysqli_query($koneksi,$sql1);
            if ($q1) {
                $success = "Data Berhasil Diperbarui";
            }else {
                $error   = "Data Gagal Diperbarui";
            }
        }else {//untuk create
            $sql1 = "insert into mahasiswa (NIM, Nama, Jurusan, Alamat) values ('$nim','$nama', '$jurusan','$alamat')";
            $q1   = mysqli_query($koneksi,$sql1);
    
            if ($q1) {
                $success      = "Berhasil Memasukkan Data Baru";
            }
            else {
                $error        = "Gagal Memasukkan Data Baru";
            }
        }   
    }else {
        $error            = "Masukkan Semua Data dengan Benar";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Mahasiswa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <style>
            .mx-auto{
                width : 800px
            }
            .card{
                margin-top : 10px
            }
        </style>
    </head>
    <body>
        <div class = "mx-auto">
            <div class="card">
                <div class="card-header">
                    Input Data
                </div>
                <div class="card-body">
                    <?php if ($error) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error?>
                            </div>
                        <?php
                        header("refresh:5;url=index.php");//5=detik
                    }
                    ?>
                    <?php if ($success) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success?>
                            </div>
                        <?php
                        header("refresh:5;url=index.php");//5=detik
                    }
                    ?>
                    <form action="" method = "POST">
                        <div class="mb-3">
                            <label for="NIM" class="col-sm-2 col-form-label">NIM</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name ="nim" id="NIM" value="<?php echo $nim ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name = "nama" id="Nama" value="<?php echo $nama ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name = "alamat" id="Alamat" value="<?php echo $alamat ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                            <div class="col-sm-10">
                                <select class = "form-control" name="jurusan" id="jurusan">
                                    <option value=""> -- Pilih Jurusan -- </option>
                                    <option value="Teknik Informatika" id = "Teknik Informatika" <?php if ($jurusan == "Teknik Informatika") echo "Selected " ?>>Teknik Informatika</option>
                                    <option value="Teknik Pengolahan Sawit" id = "Teknik Pengolahan Sawit" <?php if ($jurusan == "Teknik Pengolahan Sawit") echo "Selected " ?>>Teknik Pengolahan Sawit</option>
                                    <option value="Perawatan Perbaikan Mesin" id = "Perawatan Perbaikan Mesin" <?php if ($jurusan == "Perawatan Perbaikan Mesin") echo "Selected " ?>>Perawatan Perbaikan Mesin</option>
                                    <option value="Administrasi Bisnis Internasional" id = "Administrasi Bisnis Internasional" <?php if ($jurusan == "Administrasi Bisnis Internasional") echo "Selected " ?>>Administrasi Bisnis Internasional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" name = "simpan" value = "Simpan Data"class="btn btn-primary">Simpan</button>
                        </div> 
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header text-white bg-secondary">
                    Database
                </div>
                <div class="card-body">
                    <table class = "table">
                        <thead>
                            <tr>
                                <th scope = "col">#</th>
                                <th scope = "col">NIM</th>
                                <th scope = "col">Nama</th>
                                <th scope = "col">Jurusan</th>
                                <th scope = "col">Alamat</th>
                                <th scope = "col">Aksi </th>
                            </tr>
                            <tbody>
                                <?php
                                $sql2 = "select * from mahasiswa order by id desc";
                                $q2   = mysqli_query($koneksi, $sql2);
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id         = $r2['ID'];
                                    $nim        = $r2['NIM'];
                                    $nama       = $r2['Nama'];
                                    $jurusan    = $r2['Jurusan'];
                                    $alamat     = $r2['Alamat'];
                                    ?>
                                    <tr>
                                        <th scope = "row"><?php echo $urut++?></th>
                                        <td scope = "row"><?php echo $nim?></td>
                                        <td scope = "row"><?php echo $nama?></td>
                                        <td scope = "row"><?php echo $jurusan?></td>
                                        <td scope = "row"><?php echo $alamat?></td>
                                        <td scope = "row">
                                            <a href="index.php?op=Ubah&id=<?php echo $id?>">
                                                <button type="button" class="btn btn-success">Ubah</button>
                                            </a>
                                            <a href="index.php?op=Hapus&id=<?php echo $id?>" onclick = "return confirm('Apakah Anda Yakin ingin Menghapus Data')">
                                                <button type="button" class="btn btn-danger">Hapus</button>
                                            </a>  
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>