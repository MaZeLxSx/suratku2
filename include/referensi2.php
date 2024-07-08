<?php
    // Check session
    if(empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
        if(isset($_REQUEST['act'])) {
            $act = $_REQUEST['act'];
            switch ($act) {
                case 'add':
                    include "tambah_klasifikasi.php";
                    break;
                case 'edit':
                    include "edit_klasifikasi.php";
                    break;
                case 'del':
                    include "hapus_klasifikasi.php";
                    break;
                case 'print':
                    include "cetak_laporanperjalanan.php";
                    break;
            }
        } else {
            $query = mysqli_query($config, "SELECT referensi FROM tbl_sett");
            list($referensi) = mysqli_fetch_array($query);

            // Pagination
            $limit = $referensi;
            $pg = @$_GET['pg'];
            if(empty($pg)) {
                $curr = 0;
                $pg = 1;
            } else {
                $curr = ($pg - 1) * $limit;
            }

            echo '<!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <div class="z-depth-1">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <div class="col m7">
                                    <ul class="left">
                                        <li class="waves-effect waves-light hide-on-small-only">
                                            <a href="?page=ref2" class="judul">
                                                <i class="material-icons">class</i> Surat Perintah Tugas
                                            </a>
                                        </li>';
            if($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2) {
                echo '<li class="waves-effect waves-light">
                        <a href="?page=ref2&act=add">
                            <i class="material-icons md-24">add_circle</i> Tambah Data
                        </a>
                      </li>';
            }
            echo '
                                    </ul>
                                </div>
                                <div class="col m5 hide-on-med-and-down">
                                    <form method="post" action="?page=ref2">
                                        <div class="input-field round-in-box">
                                            <input id="search" type="search" name="cari" placeholder="Ketik dan tekan enter mencari data..." required>
                                            <label for="search"><i class="material-icons">search</i></label>
                                            <input type="submit" name="submit" class="hidden">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->';

            // Display success messages if set
            $successMessages = ['succAdd', 'succEdit', 'succDel', 'succUpload'];
            foreach ($successMessages as $msg) {
                if(isset($_SESSION[$msg])) {
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card green lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$_SESSION[$msg].'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION[$msg]);
                }
            }

            echo '
            <!-- Row form Start -->
            <div class="row jarak-form">';

            if(isset($_REQUEST['submit'])) {
                $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                echo '
                <div class="col s12" style="margin-top: -18px;">
                    <div class="card blue lighten-5">
                        <div class="card-content">
                            <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=ref2"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                        </div>
                    </div>
                </div>

                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="10%">No</th>
                                <th width="15%">Pejabat</th>
                                <th width="15%">Nama</th>
                                <th width="15%">Jabatan</th>
                                <th width="15%">Keterangan</th>
                                <th width="15%">Maksud Penugasan</th>
                                <th width="15%">Alat Angkut</th>
                                <th width="15%">Tempat Tujuan</th>
                                <th width="15%">Lamanya Perjalanan</th>
                                <th width="15%">Tanggal Berangkat</th>
                                <th width="15%">Tanggal Harus Kembali</th>
                                <th width="15%">Pembebanan Anggaran</th>
                                <th width="15%">Instansi</th>
                                <th width="15%">Mata Anggaran</th>
                                <th width="15%">Keterangan dan Lain Lain</th>
                                <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                            </tr>
                        </thead>
                        <tbody>';

                        // Script to display data
                        $query = mysqli_query($config, "SELECT * FROM tbl_surat_perintah WHERE uraian LIKE '%$cari%' ORDER BY no DESC LIMIT $curr, $limit");
                        if(mysqli_num_rows($query) > 0) {
                            while($row = mysqli_fetch_array($query)) {
                                echo '
                                <tr>
                                    <td>'.$row['no'].'</td>
                                    <td>'.$row['pejabat'].'</td>
                                    <td>'.$row['nama'].'</td>
                                    <td>'.$row['jabatan'].'</td>
                                    <td>'.$row['keterangan'].'</td>
                                    <td>'.$row['maksud'].'</td>
                                    <td>'.$row['alat'].'</td>
                                    <td>'.$row['tempat'].'</td>
                                    <td>'.$row['lamanya'].'</td>
                                    <td>'.$row['tglberangkat'].'</td>
                                    <td>'.$row['tglkembali'].'</td>
                                    <td>'.$row['pembebasan'].'</td>
                                    <td>'.$row['instansi'].'</td>
                                    <td>'.$row['mataanggaran'].'</td>
                                    <td>'.$row['keteranganlain'].'</td>
                                    <td>';

                                    if($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2) {
                                        echo '<a class="btn small blue waves-effect waves-light" href="?page=ref&act=edit&no='.$row['no'].'">
                                                <i class="material-icons">edit</i> EDIT</a>
                                              <a class="btn small deep-orange waves-effect waves-light" href="?page=ref&act=del&no='.$row['no'].'">
                                                <i class="material-icons">delete</i> DEL</a>
                                              <a class="btn small green waves-effect waves-light" href="?page=ref&act=print&no='.$row['no'].'">
                                                <i class="material-icons">print</i> CETAK</a>';
                                    } else {
                                        echo '<a class="btn small blue-grey waves-effect waves-light disabled"><i class="material-icons">edit</i> EDIT</a>
                                              <a class="btn small blue-grey waves-effect waves-light disabled"><i class="material-icons">delete</i> DEL</a>
                                              <a class="btn small blue-grey waves-effect waves-light disabled"><i class="material-icons">print</i> CETAK</a>';
                                    }

                                    echo '</td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="16"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
                        }
                      echo '</tbody></table><br/><br/>
                    </div>
                </div>
                <!-- Row form END -->';

            } else {

                echo '<div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="15%">Pejabat</th>
                                    <th width="15%">Nama</th>
                                    <th width="15%">Jabatan</th>
                                    <th width="15%">Keterangan</th>
                                    <th width="15%">Maksud Penugasan</th>
                                    <th width="15%">Alat Angkut</th>
                                    <th width="15%">Tempat Tujuan</th>
                                    <th width="15%">Lamanya Perjalanan</th>
                                    <th width="15%">Tanggal Berangkat</th>
                                    <th width="15%">Tanggal Harus Kembali</th>
                                    <th width="15%">Pembebanan Anggaran</th>
                                    <th width="15%">Instansi</th>
                                    <th width="15%">Mata Anggaran</th>
                                    <th width="15%">Keterangan dan Lain Lain</th>
                                    <th width="18%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                            // Script to display data
                            $query = mysqli_query($config, "SELECT * FROM tbl_surat_perintah ORDER BY no DESC LIMIT $curr, $limit");
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_array($query)) {
                                    echo '
                                    <tr>
                                        <td>'.$row['no'].'</td>
                                        <td>'.$row['pejabat'].'</td>
                                        <td>'.$row['nama'].'</td>
                                        <td>'.$row['jabatan'].'</td>
                                        <td>'.$row['keterangan'].'</td>
                                        <td>'.$row['maksud'].'</td>
                                        <td>'.$row['alat'].'</td>
                                        <td>'.$row['tempat'].'</td>
                                        <td>'.$row['lamanya'].'</td>
                                        <td>'.$row['tglberangkat'].'</td>
                                        <td>'.$row['tglkembali'].'</td>
                                        <td>'.$row['pembebasan'].'</td>
                                        <td>'.$row['instansi'].'</td>
                                        <td>'.$row['mataanggaran'].'</td>
                                        <td>'.$row['keteranganlain'].'</td>
                                        <td>';

                                        if($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2) {
                                            echo '<a class="btn small blue waves-effect waves-light" href="?page=ref&act=edit&no='.$row['no'].'">
                                                    <i class="material-icons">edit</i> EDIT</a>
                                                  <a class="btn small deep-orange waves-effect waves-light" href="?page=ref&act=del&no='.$row['no'].'">
                                                    <i class="material-icons">delete</i> DEL</a>
                                                  <a class="btn small green waves-effect waves-light" href="?page=ref&act=print&no='.$row['no'].'">
                                                    <i class="material-icons">print</i> CETAK</a>';
                                        } else {
                                            echo '<a class="btn small blue-grey waves-effect waves-light disabled"><i class="material-icons">edit</i> EDIT</a>
                                                  <a class="btn small blue-grey waves-effect waves-light disabled"><i class="material-icons">delete</i> DEL</a>
                                                  <a class="btn small blue-grey waves-effect waves-light disabled"><i class="material-icons">print</i> CETAK</a>';
                                        }

                                        echo '</td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="16"><center><p class="add">Tidak ada data yang ditemukan. <u><a href="?page=ref&act=add">Tambah data baru</a></u></p></center></td></tr>';
                            }
                          echo '</tbody></table><br/><br/>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_surat_perintah");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ) {

                        // First and previous pagination
                        if($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=ref&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=ref&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        // Middle pagination numbers
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg) echo '<li class="active waves-effect waves-dark"><a href="?page=ref&pg='.$i.'"> '.$i.' </a></li>';
                                else echo '<li class="waves-effect waves-dark"><a href="?page=ref&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        }

                        // Last and next pagination
                        if($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=ref&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=ref&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>';
                        }
                        echo '
                        </ul>';
                } else {
                    echo '';
                }
            }
        }
    }
?>
