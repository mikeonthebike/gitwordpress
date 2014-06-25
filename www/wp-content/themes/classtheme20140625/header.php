<!Doctype html>
<html>
<head>
<title><?php echo GitWordPressLayout::$Viewbag['sTitle'] ?></title>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
</head>
<body>
<div id="wrapper" class="<?php echo GitWordPressLayout::$Viewbag['sPage'] ?>">
<div id="header">
<div id="access" role="navigation">

    <?php /*

    Our navigation menu.  If one isn't filled out, wp_nav_menu falls
    back to wp_page_menu.  The menu assigned to the primary position is
    the one used.  If none is assigned, the menu with the lowest ID is
    used. */

    wp_nav_menu( array( 'menu_class' => 'navbar-collapse collapse') ); ?>

</div><!-- #access -->
<h1><?php echo GitWordPressLayout::$Viewbag['sTitle'] ?></h1>
</div>
