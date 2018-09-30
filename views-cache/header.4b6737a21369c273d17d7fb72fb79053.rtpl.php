<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>SMS Planejamento | Principal</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="/res/site/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/res/site/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="/res/site/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/res/site/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="/res/site/dist/css/skins/_all-skins.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-blue-light sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="../../index2.html" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>P</b>lan</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Planejamento</b> SMS</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Alternar Navegação</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/res/site/dist/img/avatar.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo getUserName(); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="/res/site/dist/img/avatar.png" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo getUserName(); ?>
                                            <small>Membro desde <?php echo getUserDate(); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="/profile" class="btn btn-default btn-flat">Perfíl</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="/logout" class="btn btn-default btn-flat">Sair</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- MENU LATERAL: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">Menu de Opções</li>
                        <?php if( getMenu() == 'principal' ){ ?>
                        <li class='active'>
                            <?php }else{ ?>
                        <li>
                            <?php } ?>
                            <a href="/">
                                <i class="fa fa-cubes"></i> <span>Principal</span>
                            </a>
                        </li>

                        <!-- Menu de custos-->
                        <?php if( getMenu() == 'custos' ){ ?>
                        <li class="treeview active">
                            <?php }else{ ?>
                        <li class="treeview">
                            <?php } ?>
                            <a href="#">
                                <i class="fa fa-money"></i> <span>Custos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if( getSubmenu() == 'cadastros' ){ ?>
                                <li class="treeview active">
                                    <?php }else{ ?>
                                <li class="treeview">
                                    <?php } ?>
                                    <a href="#"><i class="fa fa-circle-o"></i> Cadastros
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if( getSubSubmenu() == 'unidades' ){ ?>
                                        <li class='active'>
                                            <?php }else{ ?>
                                        <li>
                                            <?php } ?>
                                            <a href="/unidades"><i class="fa fa-circle-o"></i> Unidades</a></li>
                                        <?php if( getSubSubmenu() == 'grupos' ){ ?>
                                        <li class='active'>
                                            <?php }else{ ?>
                                        <li>
                                            <?php } ?>
                                            <a href="/grupos"><i class="fa fa-circle-o"></i> Grupos</a></li>
                                        <?php if( getSubSubmenu() == 'subgrupos' ){ ?>
                                        <li class='active'>
                                            <?php }else{ ?>
                                        <li>
                                            <?php } ?>
                                            <a href="/subgrupos"><i class="fa fa-circle-o"></i> Sub Grupos</a></li>
                                        <?php if( getSubSubmenu() == 'ccustos' ){ ?>
                                        <li class='active'>
                                            <?php }else{ ?>
                                        <li>
                                            <?php } ?>
                                            <a href="/ccustos"><i class="fa fa-circle-o"></i> Centro de Custos</a></li>
                                        <?php if( getSubSubmenu() == 'grupositem' ){ ?>
                                        <li class='active'>
                                            <?php }else{ ?>
                                        <li>
                                            <?php } ?>
                                            <a href="/grupositem"><i class="fa fa-circle-o"></i> Grupo de Lançamento</a></li>
                                        <?php if( getSubSubmenu() == 'itenslanc' ){ ?>
                                        <li class='active'>
                                            <?php }else{ ?>
                                        <li>
                                            <?php } ?>
                                            <a href="/itenslanc"><i class="fa fa-circle-o"></i> Ítens de Lançamento</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Lançamento de Custos</a></li>
                                <?php if( getSubmenu() == 'relcc' ){ ?>
                                <li class='active'>
                                    <?php }else{ ?>
                                <li>
                                    <?php } ?>
                                    <a href="/relcc"><i class="fa fa-calculator"></i> Relatório por Centro de Custo</a></li>
                            </ul>
                        </li>
                        <!-- FIM do Menu de custos-->
                        <!-- Menu Tabelas Auxiliares-->
                        <?php if( getMenu() == 'auxiliar' ){ ?>
                        <li class="treeview active">
                            <?php }else{ ?>
                        <li class="treeview">
                            <?php } ?>
                            <a href="#">
                                <i class="fa fa-list-alt"></i> <span>Tabelas Auxiliares</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if( getSubmenu() == 'folha' ){ ?>
                                <li class='active'>
                                    <?php }else{ ?>
                                <li>
                                    <?php } ?>
                                    <a href="/folha"><i class="fa fa-circle-o"></i> Folha de Pagamento</a></li>
                                <li><a href="/importafolha"><i class="fa fa-upload"></i> Importar Folha de Pagamento</a></li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Consumo Almoxarifado</a></li>
                                <li><a href="#"><i class="fa fa-upload"></i> Importar Consumo Almoxarifado</a></li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Outras Despesas</a></li>
                                <li><a href="#"><i class="fa fa-upload"></i> Importar Outras Despesas</a></li>
                            </ul>
                        </li>
                        <!-- FIM da Tabelas Auxiliares-->
                        <!-- Menu de Contratos-->

                        <?php if( getMenu() == 'contratos' ){ ?>
                        <li class="treeview active">
                            <?php }else{ ?>
                        <li class="treeview">
                            <?php } ?>
                            <a href="#">
                                <i class="fa fa-bank"></i> <span>Contratos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if( getSubmenu() == 'contratos' ){ ?>
                                <li class='active'>
                                    <?php }else{ ?>
                                <li>
                                    <?php } ?>
                                    <a href="/contratos"><i class="fa fa-circle-o"></i> Contratos</a></li>
                                <?php if( getSubmenu() == 'lanccontratos' ){ ?>
                                <li class='active'>
                                    <?php }else{ ?>
                                <li>
                                    <?php } ?>
                                    <a href="/lanccontratos"><i class="fa fa-circle-o-notch"></i> Lançamento de Contratos</a></li>
                            </ul>
                        </li>
                        <!-- FIM do Menu de Contratos-->
                        <!-- Menu de Relatórios-->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-print"></i> <span>Relatórios</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-circle-o"></i> Rel por Centro de Custo</a></li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Rel por Unidade</a></li>
                            </ul>
                        </li>
                        <!-- FIM do Menu de Relatórios-->
                        <!-- Menu de Prestadores-->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-building-o"></i> <span>Prestadores</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-circle-o"></i> Cadastro de Prestadores</a></li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Produção</a></li>
                            </ul>
                        </li>
                        <!-- FIM do Menu de Prestadores-->
                    </ul>
                    <!-- FIM DO MENU LATERAL-->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->
