<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title>Laporan <?= $title ?> - <?= get_formatted_date(date('Y-m-d')) ?> <?php echo date('h:i'); ?></title>

	<link rel="icon" href=<?= base_url('assets/themes/argon/img/brand/favicon.png'); ?> type="image/png">
	<style>
		.clearfix:after {
			content: "";
			/* display: table.items; */
			/* clear: both; */
		}

		a {
			color: #5D6975;
			text-decoration: underline;
		}

		body {
			position: relative;
			/* width: 21cm; */
			width: auto;
			height: 29.7cm;
			margin: 0 auto;
			color: #001028;
			background: #FFFFFF;
			font-family: Arial, sans-serif;
			font-size: 12px;
			font-family: Arial;
		}

		header {
			padding: 10px 0;
			margin-bottom: 30px;
		}

		#logo {
			text-align: center;
			margin-bottom: 10px;
		}

		#logo img {
			width: 90px;
		}

		h1 {
			border-top: 1px solid #5D6975;
			border-bottom: 1px solid #5D6975;
			color: #5D6975;
			font-size: 2.4em;
			line-height: 1.4em;
			font-weight: normal;
			text-align: center;
			margin: 0 0 20px 0;
			background: url(dimension.png);
		}

		#project {
			float: left;
		}

		#project span {
			color: #5D6975;
			text-align: right;
			width: 52px;
			margin-right: 100px;
			display: inline-block;
			font-size: 0.8em;
		}

		#company {
			float: right;
			text-align: right;
		}

		#project div,
		#company div {
			white-space: nowrap;
		}

		table.items {
			width: 100%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 20px;
		}

		table.items tr:nth-child(2n-1) td {
			background: #F5F5F5;
		}

		table.items th,
		table.items td {
			text-align: center;
		}

		table.items th {
			padding: 5px 20px;
			color: white;
			background-color: #5D6975;
			border-bottom: 1px solid #C1CED9;
			white-space: nowrap;
			font-weight: normal;
		}

		table.items .left,
		table.items .desc {
			text-align: left;
		}

		table.items td {
			padding: 20px;
			text-align: center;
			font-size: 15px;
		}

		table.items td.service,
		table.items td.desc {
			vertical-align: top;
		}

		table.items td.unit,
		table.items td.qty,
		table.items td.total {
			font-size: 1.2em;
		}

		table.items td.grand {
			border-top: 1px solid #5D6975;
			;
		}

		#notices .notice {
			color: #5D6975;
			font-size: 1.2em;
		}

		col-xl-3 footer {
			color: #5D6975;
			width: 100%;
			height: 30px;
			position: absolute;
			bottom: 0;
			border-top: 1px solid #C1CED9;
			padding: 8px 0;
			text-align: center;
		}

		.data {
			width: 96%;
			margin-bottom: 30px;
		}
	</style>

</head>

<body>
	<header class="clearfix">
		<h1>Laporan <?= $title ?></h1>
		<table class="data">
			<tr>
				<td>
					<div id="project" class="clearfix">
						<div>Sistem Informasi Inventaris SD Negeri 41 Kota Bengkulu </div>

					</div>
				</td>
				<td style="float: right;">
					<div id="company" class="clearfix">

						<div> </div>
						<div><?php echo get_formatted_date(date('Y-m-d')) ?></div>
					</div>
				</td>
			</tr>
		</table>
	</header>
	<main>
		<table class="items">
			<?php foreach ($datas as $data) : ?>
				<thead>
					<tr>
						<!-- <th colspan="2" class="service">No</th> -->
						<th colspan="2" class="">
							<h3><?php echo strtoupper($data->nama_gedung); ?></h3>
						</th>
						<th class="">
							<h3><?php echo strtoupper('Kapasitas'); ?></h3>
						</th>
						<th class="">
							<h3><?php echo strtoupper('terisi'); ?></h3>
						</th>
						<th class="">
							<h3><?php echo strtoupper('tersedia'); ?></h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php $ruangans = ruangan_in_gedung($data->id_gedung) ?>
					<?php if (count($ruangans) > 0) : ?>
						<?php foreach ($ruangans as $ruangan) :
						?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td class="left"><?php echo $ruangan->nama_ruangan; ?></td>
								<td class=""><?php echo $ruangan->kapasitas_ruangan; ?></td>
								<td class=""><?php echo $ruangan->terisi_ruangan; ?></td>
								<td class=""><?php echo ($ruangan->kapasitas_ruangan - $ruangan->terisi_ruangan); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5"> Belum Ada Data Ruangan</td>
						</tr>
					<?php endif; ?>
				</tbody>
			<?php endforeach; ?>
		</table>
	</main>
	<footer>
		Laporan ini dicetak pada <?php echo get_formatted_date(date('Y-m-d H:i:s')); ?> <?php echo date('h:i'); ?> dan merupakan Laporan yang sah.
	</footer>
</body>

</html>