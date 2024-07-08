<?php


if(empty($_SESSION['admin'])){
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if($_SESSION['admin'] != 1 && $_SESSION['admin'] != 2){
        echo '<script language="javascript">
                window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                window.location.href="./admin.php?page=ref";
              </script>';
    } else {

        if(isset($_POST['submit'])){

            //validasi form kosong
            if(empty($_POST['no']) || empty($_POST['pejabat']) || empty($_POST['nama']) || empty($_POST['jabatan']) || empty($_POST['keterangan']) || empty($_POST['maksud']) || empty($_POST['alat']) || empty($_POST['tempat']) || empty($_POST['lamanya']) || empty($_POST['tglberangkat']) || empty($_POST['tglkembali']) || empty($_POST['pembebasan']) || empty($_POST['instansi']) || empty($_POST['mataanggaran']) || empty($_POST['keteranganlain'])){
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                $no = mysqli_real_escape_string($config, $_POST['no']);
                $pejabat = mysqli_real_escape_string($config, $_POST['pejabat']);
                $nama = mysqli_real_escape_string($config, $_POST['nama']);
                $jabatan = mysqli_real_escape_string($config, $_POST['jabatan']);
                $keterangan = mysqli_real_escape_string($config, $_POST['keterangan']);
                $maksud = mysqli_real_escape_string($config, $_POST['maksud']);
                $alat = mysqli_real_escape_string($config, $_POST['alat']);
                $tempat = mysqli_real_escape_string($config, $_POST['tempat']);
                $lamanya = mysqli_real_escape_string($config, $_POST['lamanya']);
                $tglberangkat = mysqli_real_escape_string($config, $_POST['tglberangkat']);
                $tglkembali = mysqli_real_escape_string($config, $_POST['tglkembali']);
                $pembebasan = mysqli_real_escape_string($config, $_POST['pembebasan']);
                $instansi = mysqli_real_escape_string($config, $_POST['instansi']);
                $mataanggaran = mysqli_real_escape_string($config, $_POST['mataanggaran']);
                $keteranganlain = mysqli_real_escape_string($config, $_POST['keteranganlain']);
                
                //validasi input data
                if(!preg_match("/^[a-zA-Z0-9. ]*$/", $no)){
                    $_SESSION['no'] = 'Form No hanya boleh mengandung karakter huruf, angka, spasi dan titik(.)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if(!preg_match("/^[a-zA-Z0-9.,\/ -]*$/", $nama)){
                        $_SESSION['namaref'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.), koma(,) dan minus(-)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if(!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $keterangan)){
                            $_SESSION['keterangan'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            $cek = mysqli_query($config, "SELECT * FROM tbl_surat_perintah WHERE no='$no'");
                            $result = mysqli_num_rows($cek);

                            if($result > 0){
                                $_SESSION['duplikasi'] = 'No sudah ada, pilih yang lainnya!';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                $query = mysqli_query($config, "INSERT INTO tbl_surat_perintah(no, pejabat, nama, jabatan, keterangan, maksud, alat, tempat, lamanya, tglberangkat, tglkembali, pembebasan, instansi, mataanggaran, keteranganlain) VALUES('$no', '$pejabat', '$nama', '$jabatan', '$keterangan', '$maksud', '$alat', '$tempat', '$lamanya', '$tglberangkat', '$tglkembali', '$pembebasan', '$instansi', '$mataanggaran', '$keteranganlain')");

                                if($query){
                                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                    header("Location: ./admin.php?page=ref");
                                    die();
                                } else {
                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query: ' . mysqli_error($config);
                                    echo '<script language="javascript">window.history.back();</script>';
                                }
                            }
                        }
                    }
                }
            }
        } else {
            ?>
            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="?page=ref&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah Surat Perintah</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <?php
                if(isset($_SESSION['errQ'])){
                    $errQ = $_SESSION['errQ'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errQ']);
                }
                if(isset($_SESSION['errEmpty'])){
                    $errEmpty = $_SESSION['errEmpty'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errEmpty']);
                }
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">

                <!-- Form START -->
                <form class="col s12" method="post" action="?page=ref&act=add">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">font_download</i>
                            <input id="no" type="text" class="validate" name="no" required>
                                <?php
                                    if(isset($_SESSION['no'])){
                                        $no = $_SESSION['no'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$no.'</div>';
                                        unset($_SESSION['no']);
                                    }
                                    if(isset($_SESSION['duplikasi'])){
                                        $duplikasi = $_SESSION['duplikasi'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$duplikasi.'</div>';
                                        unset($_SESSION['duplikasi']);
                                    }
                                ?>
                            <label for="no">No</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">account_circle</i>
                            <input id="pejabat" type="text" class="validate" name="pejabat" required>
                            <label for="pejabat">Pejabat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">account_circle</i>
                            <input id="nama" type="text" class="validate" name="nama" required>
                            <label for="nama">Nama</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">work</i>
                            <input id="jabatan" type="text" class="validate" name="jabatan" required>
                            <label for="jabatan">Jabatan</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">subject</i>
                            <textarea id="keterangan" class="materialize-textarea" name="keterangan" required></textarea>
                            <label for="keterangan">Keterangan</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">assignment</i>
                            <textarea id="maksud" class="materialize-textarea" name="maksud" required></textarea>
                            <label for="maksud">Maksud</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">directions_car</i>
                            <input id="alat" type="text" class="validate" name="alat" required>
                            <label for="alat">Alat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">location_on</i>
                            <input id="tempat" type="text" class="validate" name="tempat" required>
                            <label for="tempat">Tempat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">schedule</i>
                            <input id="lamanya" type="date" class="validate" name="lamanya" required>
                            <label for="lamanya">Lamanya</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tglberangkat" type="date" class="validate" name="tglberangkat" required>
                            <label for="tglberangkat">Tanggal Berangkat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tglkembali" type="date" class="validate" name="tglkembali" required>
                            <label for="tglkembali">Tanggal Kembali</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">money_off</i>
                            <input id="pembebasan" type="text" class="validate" name="pembebasan" required>
                            <label for="pembebasan">Pembebasan</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">business</i>
                            <input id="instansi" type="text" class="validate" name="instansi" required>
                            <label for="instansi">Instansi</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">account_balance</i>
                            <input id="mataanggaran" type="text" class="validate" name="mataanggaran" required>
                            <label for="mataanggaran">Mata Anggaran</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">notes</i>
                            <textarea id="keteranganlain" class="materialize-textarea" name="keteranganlain" required></textarea>
                            <label for="keteranganlain">Keterangan Lain</label>
                        </div>
                    </div>
                    <!-- Row in form END -->
                    <div class="row">
                        <div class="col s6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col s6">
                            <a href="?page=ref" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>

                </form>
                <!-- Form END -->

            </div>
            <!-- Row form END -->

<?php
        }
    }
}
?>
