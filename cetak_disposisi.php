<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
        header("Location: ./");
        die();
    } else {

        echo '
        <style type="text/css">
            table {
                background: #fff;
                padding: 5px;
            }
            tr, td {
                border: table-cell;
                border: 1px  solid #444;
            }
            tr,td {
                vertical-align: top!important;
            }
            #right {
                border-right: none !important;
            }
            #left {
                border-left: none !important;
            }
            .isi {
                height: 300px!important;
            }
            .disp {
                text-align: center;
                padding: 1.5rem 0;
                margin-bottom: .5rem;
            }
            .logodisp {
                float: left;
                position: relative;
                width: 110px;
                height: 110px;
                margin: 0 0 0 1rem;
            }
            #lead {
                width: auto;
                position: relative;
                margin: 25px 0 0 75%;
            }
            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }
            .tgh {
                text-align: center;
            }
            #nama {
                font-size: 2.1rem;
                margin-bottom: -1rem;
            }
            #alamat {
                font-size: 16px;
            }
            .up {
                text-transform: uppercase;
                margin: 0;
                line-height: 2.2rem;
                font-size: 1.5rem;
            }
            .status {
                margin: 0;
                font-size: 1.3rem;
                margin-bottom: .5rem;
            }
            #lbr {
                font-size: 20px;
                font-weight: bold;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: -1.3rem 0 1.5rem;
            }
            @media print{
                body {
                    font-size: 12px;
                    color: #212121;
                }
                nav {
                    display: none;
                }
                table {
                    width: 100%;
                    font-size: 12px;
                    color: #212121;
                }
                tr, td {
                    border: table-cell;
                    border: 1px  solid #444;
                    padding: 8px!important;

                }
                tr,td {
                    vertical-align: top!important;
                }
                #lbr {
                    font-size: 20px;
                }
                .isi {
                    height: 200px!important;
                }
                .tgh {
                    text-align: center;
                }
                .disp {
                    text-align: center;
                    margin: -.5rem 0;
                }
                .logodisp {
                    float: left;
                    position: relative;
                    width: 80px;
                    height: 80px;
                    margin: .5rem 0 0 .5rem;
                }
                #lead {
                    width: auto;
                    position: relative;
                    margin: 15px 0 0 75%;
                }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-bottom: -10px;
                }
                #nama {
                    font-size: 20px!important;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin: -10px 0 -20px 0;
                }
                .up {
                    font-size: 17px!important;
                    font-weight: normal;
                }
                .status {
                    font-size: 17px!important;
                    font-weight: normal;
                    margin-bottom: -.1rem;
                }
                #alamat {
                    margin-top: -15px;
                    font-size: 13px;
                }
                #lbr {
                    font-size: 17px;
                    font-weight: bold;
                }
                .separator {
                    border-bottom: 2px solid #616161;
                    margin: -1rem 0 1rem;
                }

            }
        </style>

        <body onload="window.print()">

        <!-- Container START -->
            <div id="colres">
                <div class="disp">';
                    $query2 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                    list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query2);
                        echo '<img class="logodisp" src="./upload/'.$logo.'"/>';
                        echo '<h6 class="up">'.$institusi.'</h6>';
                        echo '<h5 class="up" id="nama">'.$nama.'</h5><br/>';
                        echo '<h6 class="status">'.$status.'</h6>';
                        echo '<span id="alamat">'.$alamat.'</span>';

                    echo '
                </div>
                <div class="separator"></div>';

                $id_surat = mysqli_real_escape_string($config, $_REQUEST['id_surat']);
                $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");

                if(mysqli_num_rows($query) > 0){
                $no = 0;
                while($row = mysqli_fetch_array($query)){

                echo '
 
                <div class="container">
                <h1 style="font-size: 15px; text-align: center;"><strong>LAPORAN HASIL PERJALANAN DINAS TAHUN ANGGARAN 2024</strong></h1>

    <table>
        <tr>
            <td>Yang bertanda tangan dibawah ini:</td>
            <td>Jabatan:</td>
        </tr>
        <tr>
            <td>Nama : WAWAN ROCHMAT W</td>
            <td>KAUR UMUM DAN PERENCANAAN</td>
        </tr>
        <tr>
            <td class="pengikut">Pengikut :</td>
            <td></td>
        </tr>
        <tr>
            <td>Nama : WINA SRI RETNANI</td>
            <td>KAUR KEUANGAN</td>
        </tr>
        <tr>
            <td>Nama :</td>
            <td></td>
        </tr>
        <tr>
            <td>Nama :</td>
            <td></td>
        </tr>
        <tr>
            <td>Nama :</td>
            <td></td>
        </tr>
        <tr>
            <td>Nama :</td>
            <td></td>
        </tr>
    </table>

    <p>Bahwa berdasarkan Surat Perintah Tugas Kepala Desa SIDOWAYAH Nomor:  /   /2024, maka dengan ini kami laporkan sebagai berikut:</p>

    <div style="height: 100px;"></div>  

    <p class="ttd">Demikian untuk menjadikan periksa.</p>

    <div class="mengetahui" style="float: left; width: 45%; text-align: left;">
        <p>Mengetahui,</p>
        <img src="ttd_kepala_desa.png" alt="Tanda Tangan Kepala Desa" width="150">
        <p>Nama Kepala Desa</p>
        <p>NIP.</p>
    </div>

    <div class="pelapor" style="float: right; width: 45%; text-align: right;">
        <p>Sidowayah, 23-Apr-24</p>
        <p>Yang melaporkan,</p>
        <img src="ttd_pelapor.png" alt="Tanda Tangan Pelapor" width="150">
        <p>WAWAN ROCHMAT W</p>
    </div>
</div>

            
                </body>
                </html>
                
        <div class="jarak2"></div>
    <!-- Container END -->

    </body>';
    }
}}
?>
