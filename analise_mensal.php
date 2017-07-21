<!DOCTYPE html>
<html lang="PT-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/index.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- Customized -->
	<script src="js/index.js"></script>
	
	<title>Mensal</title>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">RCK</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a class="btn btn-warning" style="color: white !important;" href="analise_dia_18.php">Dia 18</a></li>
					<li><a class="btn btn-warning" style="color: white !important;" href="analise_dia_19.php">Dia 19</a></li>
					<li><a class="btn btn-danger" style="color: white !important;" href="analise_dia_20.php">Dia 20</a></li>
					<li><a class="btn btn-warning" style="color: white !important;" href="analise_dia_22.php">Dia 22</a></li>
					<li><a class="btn btn-primary" style="color: white !important;" href="analise_diaria.php">Diaria</a></li>
					<li><a class="btn btn-info" style="color: white !important;" href="analise_mensal.php">Mensal</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="col-xs-12">
		<center><h3>Anáise Mensal</h3></center>
		<div class="col-md-6 col-md-offset-3">
			<div class="row">
				<table>
					<tr>
						<th>Contagem</th>
						<th>CFOP</th>
						<th>STR</th>
						<th>Data</th>
						<th>Período</th>
						<th>DB</th>
					</tr>
				<?php
					set_time_limit(3600);
					include 'server/conexao.php';

					$caminhoDB = "C:\RCK\BANCOS\Green_Produtos_Naturais\Conferencia_500";
					$dados = scandir($caminhoDB);
					$maiorDia = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
					
					for ($i=2; $i < count($dados); $i++) {

						$caminhoDB = "C:\RCK\BANCOS\Green_Produtos_Naturais\Conferencia_500";
						$caminhoDB .= "\\".$dados[$i];
						
						$data_dados = explode("_",$dados[$i]);
						$dia = $data_dados[2];
						$mes = $data_dados[1];
						$data = $dia."/".$mes."/2017";
						
						$conn = conectaBanco($caminhoDB);
						
						$periodo_D = $mes."/1/2017";
						$periodo_A = $mes."/".($maiorDia[$mes-1])."/2017";;

						$sql = "SELECT COUNT(I.CFOP) AS CONTAGEM,
								       I.CFOP,
								       I.STR
								  FROM TBL_NOTA_FISCAL N
								 INNER JOIN TBL_ITENS_ESTOQUE I
								    ON N.ID_NOTA_FISCAL = I.ID_NOTA
								 WHERE N.ORIGEM='NFCe'
								   AND N.ID_EMPRESA=1
								   AND N.ID_EMISSOR=1
								   AND N.COD_MODELO='65'
								   AND N.NF_CANCELADA='N'
								   AND (N.DATA_EMISSAO BETWEEN '$periodo_D' AND '$periodo_A')
								 GROUP BY I.CFOP,
								 		  I.STR";
						$exe = odbc_exec($conn, $sql);
						while (odbc_fetch_row($exe)) {
							$CONTAGEM = odbc_result($exe, 'CONTAGEM');
							$CFOP     = odbc_result($exe, 'CFOP');
							$STR      = odbc_result($exe, 'STR');
							echo "	<tr>";
							echo "		<td>".$CONTAGEM."</td>";
							echo "		<td>".$CFOP."</td>";
							echo "		<td>".$STR."</td>";
							echo "		<td>".$data."</td>";
							echo "		<td>".$periodo_D." até ".$periodo_A."</td>";
							echo "		<td>".$dados[$i]."</td>";
							echo "	</tr>";
						}
					}
				?>
				</table>
			</div>
		</div>
	</div>
</body>
</html>