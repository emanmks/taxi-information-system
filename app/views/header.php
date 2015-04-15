<!DOCTYPE html>
<html lang="en">
	<!-- This is Just a Header
	================================================= -->
	<head>
    <meta charset="utf-8">
    <title>Taxi Information System (TaxIS) Gowata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link href="<? echo URL; ?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/bootstrap-wysihtml5.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/style.css" rel="stylesheet" media="screen">
    <link href="<? echo URL; ?>assets/css/print.css" rel="stylesheet" media="print">
    <link href="<? echo URL; ?>assets/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" media="screen">

    <script src="<? echo URL; ?>assets/js/jquery.js"></script>
    <script src="<? echo URL; ?>assets/js/app.js"></script>

    <script src="<? echo URL; ?>assets/js/bootstrap-collapse.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-dropdown.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-modal.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-transition.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-button.js"></script>
    <script src="<? echo URL; ?>assets/js/bootstrap-typeahead.js"></script>
    <script src="<? echo URL; ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<? echo URL; ?>assets/js/jquery.printElement.min.js" ></script>

    <link rel="shortcut icon" href="<? echo URL; ?>assets/img/favicon.ico">
	 <link rel="icon" href="<? echo URL; ?>assets/img/favicon.ico">
	
	</head>
	<!-- End of Header -->

	<body>

	<!-- TOP Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="<? echo URL; ?>"><? echo APPNAME; ?></a>
				<div class="nav-collapse collapse">
				<?
				$isLoggedIn = Session::get('user_loggedIn');
				if($isLoggedIn): ?>
				<ul class="nav">
					<? if(Session::get('user_akses') == 'root') : ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Basis Data <b class="caret"></b></a>
            <ul class="dropdown-menu">
           		 <li class=""><a href="<? echo URL; ?>armada">Armada</a></li>
	             <li class=""><a href="<? echo URL; ?>pengemudi">Pengemudi</a></li>
	             <li class=""><a href="<? echo URL; ?>pegawai">Pegawai</a></li>
	             <li class=""><a href="<? echo URL; ?>parts">Master Suku Cadang</a></li>
            </ul>
          </li>
          <? endif; ?>

          <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'parts') : ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Suku Cadang <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class=""><a href="<? echo URL; ?>parts">Master Suku Cadang</a></li>
              <li class=""><a href="<? echo URL; ?>parts/order">Purchase Order</a></li>
              <li class=""><a href="<? echo URL; ?>parts/supply">Realisasi PO</a></li>
              <li class=""><a href="<? echo URL; ?>parts/opname">Opname</a></li>
              <li class=""><a href="<? echo URL; ?>perawatan">Perawatan</a></li>
            </ul>
          </li>
          <? endif; ?>

          <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'operation') : ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Operasional <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class=""><a href="<? echo URL; ?>parts">Master Suku Cadang</a></li>
              <li class=""><a href="<? echo URL; ?>laka">Kecelakaan</a></li>
              <li class=""><a href="<? echo URL; ?>perawatan">Perawatan</a></li>
              <li class=""><a href="<? echo URL; ?>ownership">Ownership</a></li>
            </ul>
          </li>
          <? endif; ?>	

          <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'loket') : ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Loket <b class="caret"></b></a>
            <ul class="dropdown-menu">
           		<li class=""><a href="<? echo URL; ?>sro">SRO</a></li>
          		<li class=""><a href="<? echo URL; ?>setoran">Setoran</a></li>
            </ul>
         	</li>
          <? endif; ?>
          
          <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'money') : ?>
         	<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Keuangan <b class="caret"></b></a>
            <ul class="dropdown-menu">
           		<li class=""><a href="<? echo URL; ?>transaksi">Transaksi Keuangan</a></li>
              <li class=""><a href="<? echo URL; ?>parts/pencairan">Pencairan PO</a></li>
            </ul>
         	</li>
         <? endif; ?>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'operation' || Session::get('user_akses') == 'loket' || Session::get('user_akses') == 'money')  : ?>
              <li class=""><a href="<? echo URL; ?>report/sro">Armada Keluar / SRO Terbit</a></li>
              <li class=""><a href="<? echo URL; ?>report/nosro">Armada Belum Keluar</a></li>
              <li class="divider"></li>
              <li class=""><a href="<? echo URL; ?>report/setoran">Setoran</a></li>
              <li class=""><a href="<? echo URL; ?>report/belumsetor">Belum Setor</a></li>
              <? endif; ?>
              <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'operation' || Session::get('user_akses') == 'money') : ?>
              <li class="divider"></li>
              <li class=""><a href="<? echo URL; ?>report/kurangsetoran">Rekap Kurang Setoran Pengemudi</a></li>
              <li class=""><a href="<? echo URL; ?>report/saldoks">Rekap Saldo KS</a></li>
              <li class=""><a href="<? echo URL; ?>report/rekapks">Rekap Akumulasi KS</a></li>
              <li class=""><a href="<? echo URL; ?>report/bayarks">Rekap Pembayaran KS</a></li>
              <li class="divider"></li>
              <li class=""><a href="<? echo URL; ?>report/loanlaka">Rekap Cicilan Laka Pengemudi</a></li>
              <li class=""><a href="<? echo URL; ?>report/saldolaka">Rekap Saldo Tagihan Laka</a></li>
              <li class=""><a href="<? echo URL; ?>report/rekaploanlaka">Rekap Akumulasi Tagihan Laka</a></li>
           	  <li class=""><a href="<? echo URL; ?>report/rekapbayarloanlaka">Rekap Pembayaran Tagihan Laka</a></li>
              <li class="divider"></li>
              <li class=""><a href="<? echo URL; ?>report/tabungan">Rekap Saldo Tabungan</a></li>
              <li class="divider"></li>
              <li class=""><a href="<? echo URL; ?>report/armada">Rekap Target/Pencapaian Armada</a></li>
              <li class=""><a href="<? echo URL; ?>report/pengemudi">Rekap Target/Pencapaian Pengemudi</a></li>
              <? endif; ?>
              <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'money')  : ?>
              <li class="divider"></li>
              <li class=""><a href="<? echo URL; ?>report/kas">Arus KAS</a></li>
              <? endif; ?>
              <? if(Session::get('user_akses') == 'root' || Session::get('user_akses') == 'parts' || Session::get('user_akses') == 'operation')  : ?>
              <li class="divider"></li>
              <li class=""><a href="<? echo URL; ?>report/parts">Opname Spare Parts</a></li>
              <li class=""><a href="<? echo URL; ?>report/perawatan">Perawatan</a></li>
              <li class=""><a href="<? echo URL; ?>report/perawatanparts">Pemakaian Spare Parts</a></li>
              <? endif; ?>
            </ul>
       	  </li>
          
          <? if(Session::get('user_akses') == 'root') : ?>
          <li class=""><a href="<? echo URL; ?>user">User</a></li>
          <? endif; ?>

				</ul>

        <ul class="nav pull-right">
        	<li><a href="javascript:void(0)"><? echo Session::get('user_namaLengkap'); ?></a></li>
        	<li><a href="javascript:void(0)" onClick="logout()">Logout</a></li>
        </ul>
            	<? endif; ?>
				</div>
			</div>
		</div>
    </div> 
	<!-- End of TOP Navbar -->
	
	<!-- Content
	=================================================== -->
	<div id="content" class="container">