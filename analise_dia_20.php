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
	
	<title>Diaria</title>
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
		<center><h3>Anáise Diaria 20/05</h3></center>
		<div class="col-md-8 col-md-offset-2">
			<div class="row">

				<?php
					set_time_limit(3600);
					include 'server/conexao.php';
					include 'server/funcoes.php';

					$caminhoDB = "C:\RCK\BANCOS\Green_Produtos_Naturais\Conferencia_500\DB_5_22_.RCK";
					$conn = conectaBanco($caminhoDB);

					$db_nome = "DB_5_22_.RCK";

					$data_busca = "5/20/2017";
					$data_exibe = "20/5/2017";

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
							   AND N.DATA_EMISSAO = '$data_busca'
							 GROUP BY I.CFOP,
							 		  I.STR";
							 		  
					$exe = odbc_exec($conn, $sql);
					echo "<table>";
					echo "	<tr>";
					echo "		<th>Contagem</th>";
					echo "		<th>CFOP</th>";
					echo "		<th>STR</th>";
					echo "		<th>Período</th>";
					echo "		<th>DB</th>";
					echo "	</tr>";
					while (odbc_fetch_row($exe)) {
						$CONTAGEM = odbc_result($exe, 'CONTAGEM');
						$CFOP     = odbc_result($exe, 'CFOP');
						$STR      = odbc_result($exe, 'STR');
						echo "	<tr>";
						echo "		<td>".$CONTAGEM."</td>";
						echo "		<td>".$CFOP."</td>";
						echo "		<td>".$STR."</td>";
						echo "		<td>".$data_exibe."</td>";
						echo "		<td>$db_nome</td>";
						echo "	</tr>";
					}

					echo "</table>";
					
					echo "<br>";
					echo "<br>";
					echo "<br>";

					echo "<table>";
					echo "	<tr>";
					echo "		<th>ID_ITEM</th>";
					echo "		<th>ID_PRODUTO</th>";
					echo "		<th>NOME_PRODUTO</th>";
					echo "		<th>CODIGO_TRIBUTACAO</th>";
					echo "		<th>STR</th>";
					echo "		<th>CST_ICMS_NAO_CONTRIB_NA_ST</th>";
					echo "	</tr>";

					$sql = "SELECT T.ID_ITEM,
							       T.ID_PRODUTO,
							       T.STR,
							       T.CST_ICMS_NAO_CONTRIB_NA_ST,
							       P.CODIGO_TRIBUTACAO,
							       P.NOME_PRODUTO
							  FROM TBL_TRIBUTACAO T
							  JOIN TBL_PRODUTO P
							  	ON T.ID_PRODUTO = P.ID_PRODUTO
							 WHERE -- tributacao NN
							 	T.ID_PRODUTO = 1404
							 	OR T.ID_PRODUTO = 1036
							 	OR T.ID_PRODUTO = 1147
							 	OR T.ID_PRODUTO = 1187
							 	OR T.ID_PRODUTO = 1032
							 	-- tributacao FF
							 	OR T.ID_PRODUTO = 1381
							 	OR T.ID_PRODUTO = 1038
							 	OR T.ID_PRODUTO = 2194
							 	OR T.ID_PRODUTO = 2550
							 	OR T.ID_PRODUTO = 1428
							 	-- tributacao 17
							 	OR T.ID_PRODUTO = 1000
							 	OR T.ID_PRODUTO = 1300
							 	OR T.ID_PRODUTO = 1313
							 	OR T.ID_PRODUTO = 1362
							 	OR T.ID_PRODUTO = 1363
							ORDER BY P.CODIGO_TRIBUTACAO,
									 P.NOME_PRODUTO";
							 		  
					$exe = odbc_exec($conn, $sql);

					while (odbc_fetch_row($exe)) {
						$ID_ITEM = odbc_result($exe, 'ID_ITEM');
						$ID_PRODUTO = odbc_result($exe, 'ID_PRODUTO');
						$NOME_PRODUTO = odbc_result($exe, 'NOME_PRODUTO');
						$STR = odbc_result($exe, 'STR');
						$CODIGO_TRIBUTACAO = odbc_result($exe, 'CODIGO_TRIBUTACAO');
						$CST_ICMS_NAO_CONTRIB_NA_ST = odbc_result($exe, 'CST_ICMS_NAO_CONTRIB_NA_ST');
						echo "	<tr>";
						echo "		<td>$ID_ITEM</td>";
						echo "		<td>$ID_PRODUTO</td>";
						echo "		<td>$NOME_PRODUTO</td>";
						echo "		<td>$CODIGO_TRIBUTACAO</td>";
						echo "		<td>$STR</td>";
						echo "		<td>$CST_ICMS_NAO_CONTRIB_NA_ST</td>";
						echo "	</tr>";
					}

					echo "</table>";

					echo "<br>";

					$sql_count = "SELECT COUNT(P.ID_PRODUTO) AS TOTAL_PRODUTO
									FROM TBL_TRIBUTACAO T
									JOIN TBL_PRODUTO P
									  ON T.ID_PRODUTO = P.ID_PRODUTO";
					$exe_count = odbc_exec($conn, $sql_count);

					$TOTAL_PRODUTO = odbc_result($exe_count, 'TOTAL_PRODUTO');

					echo "<table>";
					echo "	<tr>";
					echo "		<th>CONTAGEM => $TOTAL_PRODUTO</th>";
					echo "		<th>CODIGO_TRIBUTACAO</th>";
					echo "		<th>% DE CADASTRO</th>";
					echo "	</tr>";

					$sql = "SELECT COUNT(P.CODIGO_TRIBUTACAO) AS CONTAGEM,
							       P.CODIGO_TRIBUTACAO
							  FROM TBL_TRIBUTACAO T
							  JOIN TBL_PRODUTO P
							  	ON T.ID_PRODUTO = P.ID_PRODUTO
							GROUP BY P.CODIGO_TRIBUTACAO
							ORDER BY P.CODIGO_TRIBUTACAO";
							 		  
					$exe = odbc_exec($conn, $sql);


					while (odbc_fetch_row($exe)) {

						$CONTAGEM = odbc_result($exe, 'CONTAGEM');
						$CODIGO_TRIBUTACAO = odbc_result($exe, 'CODIGO_TRIBUTACAO');
						
						echo "	<tr>";
						echo "		<td>$CONTAGEM </td>";
						echo "		<td>$CODIGO_TRIBUTACAO</td>";
						echo "		<td>".to_decimal(($CONTAGEM/$TOTAL_PRODUTO)*100)."%</td>";
						echo "	</tr>";
						
					}

					echo "</table>";
				?>
			</div>
		</div>
	</div>
</body>
</html>