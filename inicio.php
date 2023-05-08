<?php
include 'Model/conexoes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	<style>
		@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css");

		.btn-toggle {
			padding: .25rem .5rem;
			font-weight: 600;
			color: rgba(0, 0, 0, .65);
			background-color: transparent;
		}

		.btn-toggle:hover,
		.btn-toggle:focus {
			color: rgba(0, 0, 0, .85);
			background-color: #d2f4ea;
		}

		.btn-toggle::before {
			width: 1.25em;
			line-height: 0;
			content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
			transition: transform .35s ease;
			transform-origin: .5em 50%;
		}

		.btn-toggle[aria-expanded="true"] {
			color: rgba(0, 0, 0, .85);
		}

		.btn-toggle[aria-expanded="true"]::before {
			transform: rotate(90deg);
		}

		.btn-toggle-nav a {
			padding: .1875rem .5rem;
			margin-top: .125rem;
			margin-left: 1.25rem;
		}

		.btn-toggle-nav a:hover,
		.btn-toggle-nav a:focus {
			background-color: #d2f4ea;
		}
	</style>

</head>

<body class="bg-light">

	<div class="container-fluid">
		<button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">Toggle offcanvas</button>
		<div class="row">

			<div style="height: 100%;" class="col-md-2 col-12">

				<div class="offcanvas-lg offcanvas-start" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
					<div class="offcanvas-header">
						<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body">
						<div class="flex-shrink-0 bg-white" style="width: 200px;">
							<!--
							<img src="" alt="Logo" width="280" height="100" class="d-inline-block align-text-top">
	-->
							<a href="" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
								<span class="h6 text-success">
									<?= $nomeInstituicao ?>
								</span>
								<?php $idInstituicaoLogado ?>
							</a>
							<ul class="list-unstyled ps-0">
								<li class="mb-1">
									<a href="?home" class="btn btn-toggle d-inline-flex align-items-center rounded border-0">
										Home
									</a>
								</li>
								<li class="mb-1">
									<a href="?membros" class="btn btn-toggle d-inline-flex align-items-center rounded border-0">
										Membros
									</a>
								</li>
								<li class="mb-1">
									<button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#cadastros-collapse" aria-expanded="false">
										Cadastros </button>
									<div class="collapse" id="cadastros-collapse">
										<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
											<li><a href="?grupos" class="link-dark d-inline-flex text-decoration-none rounded">Grupos</a></li>
											<li><a href="?cargos" class="link-dark d-inline-flex text-decoration-none rounded">Cargos</a></li>
										</ul>
									</div>
								</li>
								<li class="mb-1">
									<button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
										Minha conta
									</button>
									<div class="collapse" id="account-collapse">
										<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
											<li><a href="?sair" class="link-dark d-inline-flex text-decoration-none rounded" onClick="return confirm('Deseja sair do Sistema?')">Sair</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>


			<div class="col ms-4">

				<?php

				if (!isset($_SESSION['msg'])) {
					$_SESSION['msg'] = null;
				} else {
				?>
					<div class="modal fade show" id="exemplomodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>
									<?php
									if (!isset($_SESSION['msg'])) {
									} else {
										echo $_SESSION['msg'];
									}
									?>
								</strong>
							</div>
						</div>
					</div>
				<?php
					echo '<script>$(document).ready(function(){$("#exemplomodal").modal("show");setTimeout(function(){$("#exemplomodal").modal("hide");}, 2000); })</script>';
					unset($_SESSION['msg']);
				}

				//	include 'routers.php';

				if (isset($_REQUEST['home'])) :
					include_once 'views/home.php';
				elseif (isset($_REQUEST['membros'])) :
					include_once 'views/membros.php';
				elseif (isset($_REQUEST['cadastrar-membros'])) :
					include_once 'views/cadastrarMembro.php';
				elseif (isset($_REQUEST['perfil'])) :
					include_once 'views/perfil.php';
				elseif (isset($_REQUEST['grupos'])) :
					include_once 'views/cadastrarGrupos.php';
				elseif (isset($_REQUEST['cargos'])) :
					include_once 'views/cadastrarCargos.php';
				endif;
				?>
			</div>
		</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>

</html>