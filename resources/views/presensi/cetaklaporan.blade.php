<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }
    #title{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-weight: bold;
    }

    .tabeldataperangkatdesa{
        margin-top: 40px;

    }

   .tabeldataperangkatdesa td{
    padding: 5px;
   }

   .tabelpresensi{
    width: 100%;
    margin-top: 20px;
    font-weight: bold;
    border-collapse: collapse;

   }

   .tabelpresensi tr th{
    border: 1px solid #0a0a0a;
    padding: 8px;
    background-color: #d4d3d3;
   }

   .tabelpresensi tr td{
    border: 1px solid #0a0a0a;
    padding: 5px;
    font-size: 12px;
   }

   .foto{
    width: 80px;
    height: 80;
   }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
   @php
         function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
   @endphp
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%">
        <tr>
            <td style="width: 30px"><img src="{{ asset('assets/img/logo_cibdak.jpeg') }}" alt="" width="70" height="70"></td>
            <td>
            <span id="title">
                LAPORAN KEHADIRAN <br>
                PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }} <br>
                DESA & KELURAHAN CIBADAK
            </span><br>
            <span><i>Jln.Cibadak Kecamatan Cibadak</i></span>
            </td>
        </tr>
    </table>
    <table class="tabeldataperangkatdesa">
        <tr>
            <td rowspan="6">
                @php
                    $path = Storage::url('uploads/perangkatdesa/'.$perangkat_desa->foto);
                @endphp
                <img src="{{ url($path) }}" alt="" width="120" height="150">
            </td>
        </tr>
        <tr>
            <td>Perangkat Desa ID</td>
            <td>:</td>
            <td>{{ $perangkat_desa->PD_ID }}</td>
        </tr>
        <tr>
            <td>Nama Perangkat Desa</td>
            <td>:</td>
            <td>{{ $perangkat_desa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $perangkat_desa->jabatan }}</td>
        </tr>
        <tr>
            <td>Desa</td>
            <td>:</td>
            <td>{{ $perangkat_desa->nama_desa }}</td>
        </tr>
        <tr>
            <td>No Hanphone</td>
            <td>:</td>
            <td>{{ $perangkat_desa->no_hp }}</td>
        </tr>
    </table>
    <table class="tabelpresensi">
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Foto</th>
            <th>Jam Pulang</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Jumlah Jam Kerja</th>
        </tr>
        @foreach ($presensi as $d)
        @php
            $path_in = Storage::url('uploads/absensi/'.$d->foto_in);
            $path_out = Storage::url('uploads/absensi/'.$d->foto_out);
            $jamterlambat = selisih('08:00:00',$d->jam_in);
        @endphp
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
                <td>{{ $d->jam_in }}</td>
                <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                <td>
                    @if ($d->jam_out != null)
                    <img src="{{ url($path_out) }}" alt="" class="foto"></td>
                    @else
                    <img src="{{ asset('assets/img/ok.png') }}" alt="" class="foto">
                    @endif
                <td>
                @if ($d->jam_in >= "08:00")
                    Terlambat {{ $jamterlambat }}
                @else
                    Tepat Waktu
                @endif
                </td>
                <td>
                    @if ($d->jam_out != null)
                        @php
                            $jmljamkerja = selisih($d->jam_in,$d->jam_out);
                        @endphp
                        @else
                        @php
                            $jmljamkerja = 0;
                        @endphp
                    @endif
                    {{ $jmljamkerja }}
                </td>
            </tr>
        @endforeach
    </table>

    <table width="100%" style="margin-top: 100px">
        <tr>
            <td colspan="2" style="text-align: right">......................................., {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="text-align:center; vertical-align:bottom" height="100">
                <u>................................</u><br>
                <i>BINWAS</i>
            </td>
            <td style="text-align:center; vertical-align:bottom" height="100">
                <u>................................</u><br>
                <i>SEKETARIS DESA</i>
            </td>
        </tr>
    </table>
</section>

</body>

</html>