<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Restaurant</title>
    <!-- Favicon icon -->
    <link rel="icon" type="<?= base_url() ?>image/png" sizes="16x16" href="<?= base_url() ?>/images/favicon.png">
	<link rel="stylesheet" href="<?= base_url() ?>/vendor/chartist/css/chartist.min.css">
    <link href="<?= base_url() ?>/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?= base_url() ?>/css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
        }

        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
    </style>
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="<?= base_url() ?>" class="brand-logo">
                <img class="logo-compact" src="<?= base_url() ?>/images/logo-text1.png" alt="">
                <img class="brand-title" src="<?= base_url() ?>/images/logo-text1.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
								Dashboard
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    <img src="<?= base_url() ?>images/profile/17.jpg" width="20" alt=""/>
									<div class="header-info">
										<span class="text-black"><strong><?= ucwords($user['username']) ?></strong></span>
										<p class="fs-12 mb-0">Admin</p>
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="<?= base_url() ?>/logout" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li><a class=" ai-icon" href="<?= base_url() ?>" >
							<i class="flaticon-381-networking"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                    </li>
					<?php if($user['role']==1){ ?>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Suppliers</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url() ?>/suppliers/add_new">Add Supplier</a></li>
                            <li><a href="<?= base_url() ?>/suppliers">View Suppliers</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Categories</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url() ?>/categories/add_new">Add Category</a></li>
                            <li><a href="<?= base_url() ?>/categories">View Categories</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Sub Categories</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url() ?>/sub_categories/add_new">Add Sub Category</a></li>
                            <li><a href="<?= base_url() ?>/sub_categories">View Sub Categories</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Items</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url() ?>/items/add_new">Add Item</a></li>
                            <li><a href="<?= base_url() ?>/items">View Items</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class=" ai-icon" href="<?= base_url() ?>orders" >
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Orders</span>
						</a>
                    </li>
					<?php } ?>
                </ul>
                <div class="copyright">
					<p><strong>Info Solution Admin Dashboard</strong> © 2022 All Rights Reserved</p>
					<p>Made with <span class="heart"></span> by <a href="https://github.com/rayigraph" target="_blank" rel="noopener noreferrer">rayigraph</a></p>
				</div>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->