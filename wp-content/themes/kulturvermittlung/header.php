<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!--------------------------
	* Powered by:
	*
	* Cortex Media Framework v2.4
	*
	* Cortex Media GmbH, Ulm.
	* https://cortex-media.de
	---------------------------->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Celitement GmbH & Co.KG" />
	<meta name="Copyright" content="Celitement GmbH & Co.KG" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php $template_dir = get_template_directory_uri(); ?>
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $template_dir; ?>/static/favicons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $template_dir; ?>/static/favicons/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $template_dir; ?>/static/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $template_dir; ?>/static/favicons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $template_dir; ?>/static/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo $template_dir; ?>/static/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $template_dir; ?>/static/favicons/ms-icon-144x144.png">
	<meta name="theme-color" content="#00C1D4">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $template_dir;?>/static/favicons/favicon.ico">

	<?php wp_head(); ?>

    <script type="text/javascript">
        jQuery(function(){
            Project.ajaxUrl = "<?php echo admin_url('admin-ajax.php') ?>";
            <?php if(is_user_logged_in()) { ?>
                Favorites.loggedIn = true;
            <?php } ?>
        });
    </script>
</head>
<body>

<div class="wrapper">
    <div class="content <?php if(get_field('beiger_hintergrund')) {?>internal-background<?php } ?>">
        <header class="<?php if(get_field('beiger_hintergrund')) {?>internal<?php }?>">
            <div class="grid-inner align-items-center">
                <div class="logo-container">
                    <?php $home_url = apply_filters('wpml_home_url', get_option('home')); ?>
                    <a href="<?php echo $home_url;?>" title="<?php _e('Zurück zur Startseite','kulturvermittlung');?>"><img src="<?php echo $template_dir;?>/static/img/ulmutopia_logo.svg" class="main-logo" alt="<?php _e('Logo Ulmutopia','kulturvermittlung');?>"></a>
                    <a href="<?php echo $home_url;?>" title="<?php _e('Zurück zur Startseite','kulturvermittlung');?>"><img src="<?php echo $template_dir;?>/static/img/ulmutopia_logo_small.svg" class="small-logo" alt="<?php _e('Logo Ulmutopia klein','kulturvermittlung');?>"></a>
                </div>

                <nav aria-label="<?php _e('Hauptnavigation','teilhabekultur');?>">
                    <div class="menu-container">
                        <?php
                            $user = wp_get_current_user();
                            if(!empty($user)) {
                                if(in_array('artist', (array) $user->roles)) {
                                    wp_nav_menu(array(
                                        'theme_location' => 'primary_logged_in',
                                        'menu_class'     => 'main-navigation',
                                        'container'      => ''
                                    ));
                                } else{
                                    wp_nav_menu(array(
                                        'theme_location' => 'primary',
                                        'menu_class'     => 'main-navigation',
                                        'container'      => ''
                                    ));
                                }
                            } else {
                                wp_nav_menu(array(
                                    'theme_location' => 'primary',
                                    'menu_class'     => 'main-navigation',
                                    'container'      => ''
                                ));
                            }
                        ?>

                        <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('favorites'));?>" id="header-favorites" title="<?php _e('Meine Favoriten','kulturvermittlung');?>"><img src="<?php echo $template_dir;?>/static/img/icons/heart_header.svg" alt="<?php _e('Icon Herz','kulturvermittlung');?>"/></a>
                        <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('search'));?>" id="header-search" title="<?php _e('Suche','kulturvermittlung');?>"><img src="<?php echo $template_dir;?>/static/img/search_icon.svg" alt="<?php _e('Icon Lupe','kulturvermittlung');?>" /></a>
                        <?php
                            if(!empty($user)) {
                                if(in_array('artist', (array) $user->roles)) {?>
                                    <a href="<?php echo wp_logout_url(home_url()); ?>" id="header-logout" title="<?php _e('Ausloggen','kulturvermittlung');?>"><img src="<?php echo $template_dir;?>/static/img/icons/logout.svg" alt="<?php _e('Icon Logout','kulturvermittlung');?>" /></a>
                            <?php }
                            }
                        ?>
                    </div>
                </nav>

                <div class="hamburger hamburger--3dx">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <?php if(get_field('buhne') == 'gross' || get_field('buhne') == 'klein' || is_single() || is_404() || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('profile')  || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('my_profile')) {?>
                <?php if(is_singular('tip')){
                    the_widget('Hero_Element_Widget', array('island' => true, 'heading_strong' => translate('Tipps', 'teilhabekultur'), 'blue_background' => true));
                } else {
                        $copyrightNotice = '';
                        if(get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('my_profile')) {
                            $titleImageArray = get_field('titelbild', 'user_' . get_current_user_id());
                            $copyrightNotice = Get_field('copyright_titelbild','user_' . get_current_user_id());
                        } elseif(get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('profile')) {
                            $titleImageArray = get_field('titelbild', 'user_' . intval($_GET['profileId']));
                            $copyrightNotice = Get_field('copyright_titelbild','user_' . intval($_GET['profileId']));
                        } elseif(is_singular('angebot')) {
                            $titleImageArray = get_field('titelbild', 'user_' . get_post_field( 'post_author', get_the_ID()));
                            $copyrightNotice = Get_field('copyright_titelbild', 'user_' . get_post_field( 'post_author', get_the_ID()));
                        } elseif(get_field('buhne') == 'klein' || is_single()) {
                            $titleImage =  $template_dir . '/static/img/ulm_utopia_header_small.jpg';
                        } else {
                            $titleImage =  $template_dir . '/static/img/ulm_utopia_header.jpg';
                        }

                        if(!empty($titleImageArray)) {
                            $titleImage = wp_get_attachment_image_url($titleImageArray['ID'], 'large');
                        }
                    ?>
                    <div class="stage <?php if(get_field('buhne') == 'klein' || is_single() || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('profile')  || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('my_profile')) {?>small<?php } ?>" style="background-image: url('<?php echo $titleImage;?>'); <?php if(get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('profile')  || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('my_profile')) {?>background-position: center;<?php } ?>">
                        <div class="grid-inner">
                            <?php if(have_rows('buhnentext')) {?>
                                <div class="title">
                                    <?php while(have_rows('buhnentext')) { the_row(); ?>
                                        <div class="title-row"><?php echo get_sub_field('textzeile');?></div><br/>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <?php if(!empty($copyrightNotice)) {?>
                                <div class="copyright-notice"><?php _e('Copyright:', 'teilnahmekultur');?> <?php echo $copyrightNotice;?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="stage-mobile <?php if(is_front_page()){?>frontpage<?php } ?> <?php if(is_single() || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('profile')  || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('my_profile')) {?>no-margin-bottom<?php } ?>" style="<?php if(!is_front_page()){?>background-image: url('<?php echo $titleImage;?>');<?php } ?> <?php if(get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('profile')  || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('my_profile')) {?>background-position: center;<?php } ?>">
                        <?php if(is_front_page()){?>
                            <img src="<?php echo $template_dir;?>/static/img/ulm_utopia_header_mobile.jpg" alt="<?php _e('Stylisierte Ansicht Ulmutopia Kultureinrichtungen','kulturvermittlung');?>"/>
                        <?php } ?>
                    </div>
               <?php }
            } ?>