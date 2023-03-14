<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Surat Peminjaman | <?= $df['head']; ?></title>
  <link rel="icon" type="image/png" href="<?= $df['favicon']; ?>">

  <style>
    * {
      margin: 0;
      font-size: 16px;
      font-family: "Times New Roman", serif;
    }

    body {
      margin: 0;
      margin-top: .5cm;
      margin-bottom: .5cm;

      margin-left: 1cm;
      margin-right: 1cm;
    }

    .isi_surat {
      margin-top: .5cm;
      margin-left: 1cm;
      margin-right: 1cm;
    }

    .tabel_barang {
      width: 100%;
      border-collapse: collapse;
      border: none;
      border: solid windowtext 1.0pt;
      font-size: 16px;
    }

    .tabel_barang th {
      text-align: center;
      padding: 5px 5px;
    }

    .tabel_barang td {
      padding: 5px 5px;
    }
  </style>
</head>

<body>
  <img src="<?= $backurl . 'admin/export/kop.png' ?>" style="width:100%">

  <div class="isi_surat">

    <p style='text-align:center;font-size:21px;font-weight:bold;text-decoration:underline;'>SURAT PEMINJAMAN PERALATAN</p>

    <p style='text-align:center;'>NOMOR : 000/SARPRAS/REKTORAT/2021</p>

    <br>
    <br>

    <p>Yang bertanda tangan dibawah ini :</p>

    <table style="margin-left: 20px;">
      <tbody>
        <tr>
          <td style="width: 120px;">Nama</td>
          <td style="width: 10px; text-align:center;">:</td>
          <td>.................................</td>
        </tr>
        <tr>
          <td style="width: 120px;">Jabatan</td>
          <td style="width: 10px; text-align:center;">:</td>
          <td>.................................</td>
        </tr>
      </tbody>
    </table>

    <p>Dalam hal ini disebut sebagai <b>PIHAK PERTAMA</b> (yang menyerahkan)</p>

    <table style="margin-left: 20px;">
      <tbody>
        <tr>
          <td style="width: 120px;">Nama</td>
          <td style="width: 10px; text-align:center;">:</td>
          <td>.................................</td>
        </tr>
        <tr>
          <td style="width: 120px;">NPM/NIDN</td>
          <td style="width: 10px; text-align:center;">:</td>
          <td>.................................</td>
        </tr>
        <tr>
          <td style="width: 120px;">Alamat Lengkap</td>
          <td style="width: 10px; text-align:center;">:</td>
          <td>.................................</td>
        </tr>
      </tbody>
    </table>

    <p>Dalam hal ini disebut sebagai <strong>PIHAK KEDUA</strong> (yang menerima)</p>

    <br>

    <p style='text-align:justify;'>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;Dengan ini menyatakan bahwa <b>PIHAK PERTAMA</b> telah menyerahkan kepada <b>PIHAK KEDUA</b> dan <b>PIHAK KEDUA</b> telah menerima penyerahan barang milik Universitas Ibnu Sina yaitu:</span></p>

    <br>

    <table border="1" class="tabel_barang">
      <tbody>
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>SN/Spesifikasi</th>
          <th>Qty</th>
          <th>Tanggal Peminjaman</th>
        </tr>
        <tr>
          <th>1</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </td>
        </tr>
        <tr>
          <th>2</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </td>
        </tr>
        <tr>
          <th>3</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </td>
        </tr>
      </tbody>
    </table>

    <br>

    <p style='text-align:justify;'>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;Demikian surat&nbsp;<b>PEMINJAMAN PERALATAN</b> ini dibuat dengan sesungguhnya untuk dipergunakan sebagaimana mestinya.</p>

    <br>

    <p style='text-align:right;'>Batam, <?= tanggal_indo(date('Y-m-d')); ?></p>




    <table style="float: right;">
      <tr>
        <td style="text-align:center;">PIHAK PERTAMA,</td>
      </tr>
      <tr>
        <td style="height: 100px;"></td>
      </tr>
      <tr>
        <td style="text-align:center;">............................</td>
      </tr>
    </table>

    <table style="float: left;">
      <tr>
        <td style="text-align:center;">PIHAK KEDUA,</td>
      </tr>
      <tr>
        <td style="height: 100px;"></td>
      </tr>
      <tr>
        <td style="text-align:center;">............................</td>
      </tr>
    </table>

    <table style="width:100%;">
      <tr>
        <td style="text-align:center;">DIKETAHUI,</td>
      </tr>
      <tr>
        <td style="height: 100px;"></td>
      </tr>
      <tr>
        <td>
          <div style='margin:auto; width: 155px; font-size:16px;'><span style="font-weight: bold; text-decoration: underline">Dr. Andi Khairunnisa</span><br>Ka. Sarpras UIS</div>
        </td>
    </table>

  </div>
</body>

</html>