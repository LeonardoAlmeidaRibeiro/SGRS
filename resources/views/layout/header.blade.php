<html lang="pt">

	<head>
		<title>DTEP - Sistemas de Gestão de Eventos</title>
        <link rel="shortcut icon" href="{{ url ('assets/imagens/logo.png') }}" type="image/x-icon">
		<meta charset="utf-8" />
		<meta name="robots" content="noindex,nofollow">
		<meta NAME="robots" CONTENT="noarchive">
		<meta NAME="robots" CONTENT="index, nofollow, noarchive">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ url ('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ url ('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ url ('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<style>
		#loading{
		position: fixed;
		width: 100%;
		height: 100vh;
		background: #fff no-repeat center center;	
		z-index: 99999;
	}
		
		.loading{
			margin: 0 auto;
			display: flex;
		}

		.container{
			height: 100vh;
			align-items: center;
    		display: flex;
		}

		::-webkit-scrollbar:horizontal{
		height: 10px;
		background-color: rgb(255, 251, 251);}
		
		::-webkit-scrollbar-thumb:horizontal{
				background: #cbcbcc;
				border-radius: 10px;}
				
		::-webkit-scrollbar-thumb:horizontal:hover{
			background: #a1a5b7;
			border-radius: 10px;
			
		}
				
		</style>
	
	<body   id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled">
		<div id="loading"><div class="container"><img class="loading" src="{{ url ('assets/imagens/loading.gif') }}"  /></div></div>

		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">

			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">

            
				<!--begin::Menu Lateral-->
				@include('layout.menu')
				<!--end::Menu Lateral-->


				<!--begin::Wrapper-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

					<!--begin::Topo-->
					@include('layout.topo')
					<!--end::Topo-->

					<script>
						
						window.addEventListener('load', (event) => {
							var preloader = document.getElementById("loading");
							preloader.style.display = 'none';
					});
							
					</script>
