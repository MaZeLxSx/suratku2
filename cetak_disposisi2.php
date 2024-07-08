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
                <table class="bordered" id="tbl" style="border-collapse: collapse; width: 100%;">
    <tbody>
        <tr>
            <td class="tgh" id="lbr" colspan="5" style="text-align: center;">
                Lembar ke: ____ &nbsp;&nbsp;&nbsp;&nbsp; Kode no.: ____ &nbsp;&nbsp;&nbsp;&nbsp; No.: ____
            </td>
        </tr>
        <tr>
            <td class="tgh" id="lbr" colspan="5" style="text-align: center;">
                <strong><u>SURAT PERJALANAN DINAS</u></strong>
                <br>
                <span>(SPPD)</span>
            </td>
        </tr>
            <td id="right" width="35%"><strong>1. Pejabat yang memberi perintah</strong></td>
            <td id="left" style="border-right: none; border-bottom: 1px solid black;" width="50%">: '.$row['indeks'].'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: 1px solid black;"><strong>2. Nama Pegawai yang diperintah</strong></td>
            <td id="left" colspan="5" style="border-bottom: 1px solid black;">: '.$row['asal_surat'].'</td>
        </tr>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;"><strong>3. a. Pangkat dan Golongan menurut PP No 6 tahun 1997</strong></td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;b. Jabatan</td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;c. Tingkat biaya perjalanan Dinas</td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: 1px solid black;"><strong>4. Maksud Perjalanan Dinas</strong></td>
            <td id="left" colspan="5" style="border-bottom: 1px solid black;">: '.$row['no_surat'].'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: 1px solid black;"><strong>5. Alat angkut yang dipergunakan</strong></td>
            <td id="left" colspan="5" style="border-bottom: 1px solid black;">: '.$row['asal_surat'].'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;"><strong>6. a. Tempat berangkat</strong></td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;b. Tempat tujuan</td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;"><strong>7. a. Lamanya perjalanan dinas</strong></td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;b. Tanggal berangkat</td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;c. Tanggal harus kembali</td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: 1px solid black;"><strong>8. Pengikut</strong></td>
            <td id="left" colspan="5" style="border-bottom: 1px solid black;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;"><strong>9. Pembebasan anggaran</strong></td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;a. Instansi</td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
        <tr>
            <td id="right" style="border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;b. Mata Anggaran</td>
            <td id="left" colspan="5" style="border-bottom: none;">: '.indoDate($row['tgl_diterima']).'</td>
        </tr>
            <td id="right" style="border-bottom: 1px solid black;"><strong>10. Keterangan dan lain-lain</strong></td>
            <td id="left" colspan="5" style="border-bottom: 1px solid black;">: </td>
        </tr>
    </tbody>
</table>                
                </tbody>
            </table>
            <div style="text-align: right;">
                <strong><p>KEPALA DESA SIDOWAYAH</p></strong>
            <div style="text-align: left;">
            <strong><p>Dikeluarkan di : SIDOWAYAH</p></strong>
            <strong><p>Pada Tanggal : '.indoDate($row['tgl_diterima']).'</p></strong>
            
            <div id="lead">
                <div style="text-align: right; "height: 100px;"></div>';
                $query = mysqli_query($config, "SELECT kades, nip FROM tbl_instansi");
                list($kades,$nip) = mysqli_fetch_array($query);
                if(!empty($kades)){
                    echo '<p class="lead">'.$kades.'</p>';
                } else {
                    echo '<p class="lead"</p>';
                }
               
                echo '
            </div>
        </div>
        <div class="jarak2"></div>
    <!-- Container END -->

    </body>';
    }
}}
?>
