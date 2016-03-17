<?php  use lib\ViewHelper\HtmlHelper; ?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Pascal Godin">

	<title><?php echo $title_for_layout; ?></title>



 <!-- Bootstrap Core CSS -->
    <link href="<?= lib\App::$_assets_path; ?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= lib\App::$_assets_path; ?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="<?= lib\App::$_assets_path; ?>fonts/icons.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <?= HtmlHelper::css(['sb-admin-2/timeline']); ?>

    <!-- Custom CSS -->
    <?= HtmlHelper::css(['sb-admin-2/sb-admin-2']); ?>


    <!-- Morris Charts CSS -->
    <link href="<?= lib\App::$_assets_path; ?>bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= lib\App::$_assets_path; ?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5351c71a57220102" async="async"></script>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?= link_to('<img style="width:15%;" src="'. lib\App::$_assets_path .'img/logo.png"/>', "/", ["class" => ["navbar-brand"]]);?>
                
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo isset($_SESSION['auth']) ? $_SESSION['auth']->username : ""; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
	                        <?php if (lib\Session::getInstance()->read('auth') == null): ?>
	                            <li>
                                    <?= link_to('<i class="fa fa-sign-in fa-fw"></i> Login', "users/login");?>
	                            </li>
	                        <?php else: ?>
                                <li>
                                    <?= link_to('<i class="fa fa-gear fa-fw"></i> Mon compte', "users/account");?>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <?= link_to('<i class="fa fa-sign-out fa-fw"></i> Logout', "users/logout");?> 
                                </li>
	                        <?php endif ?>

                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li class="hidden">
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <?= link_to('<i class="fa fa-list-alt fa-fw"></i> Home</a>', "/");?>
                            <?= link_to('<i class="fa fa-list-alt fa-fw"></i> Tutoriel</a>', "tutoriel/");?>
                            <?= link_to('<i class="fa fa-list-alt fa-fw"></i> Formation</a>', "formation/");?>
                        </li>
                        <li class="">
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Participer<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <?= link_to('Tutoriel', "participer/tutoriel");?>
                                </li>
                                <li>
                                <?= link_to('Formation', "participer/formation");?>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="hidden">
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="hidden">
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                        <li class="hidden">
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li class="hidden">
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="hidden">
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="hidden">
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">

	<?php if (lib\Session::getInstance()->hasFlashes()): ?>
		<div class="row">
			<div class="col-md-12" style="padding-top:30px;">
				<?php foreach (lib\Session::getInstance()->getFlashes() as $type => $message): ?>
				  <div class="alert alert-<?php echo $type; ?>">
				    <?php echo $message; ?>
				  </div>
				<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>


	<div class="row hidden">
	    <div class="col-lg-12">
	        <h1 class="page-header">
	        	<?php if (isset($title_for_layout)): ?> 
					<?php echo $title_for_layout; ?>
	        	<?php else: ?>
	        		Titre
	        	<?php endif ?> 
	    	</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->

	<?php echo $content_for_layout; ?>






        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   
    <?= HtmlHelper::script(['jquery-2.1.4.min']); ?>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= lib\App::$_assets_path; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= lib\App::$_assets_path; ?>bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?= lib\App::$_assets_path; ?>bower_components/raphael/raphael-min.js"></script>
    <script src="<?= lib\App::$_assets_path; ?>bower_components/morrisjs/morris.min.js"></script>
    <? HtmlHelper::script(['sb-admin-2/morris-data']); ?>

    <!-- Custom Theme JavaScript -->

    
	<?= HtmlHelper::script(['sb-admin-2/sb-admin-2']); ?>
	<?php  if(isset($script)): ?><?= $script; ?><?php endif; ?>

</body>

</html>
