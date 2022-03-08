        <?php $template_dir = get_template_directory_uri(); ?>
            <?php if(get_field('jetzt_anmelden_banner')){ ?>
                <div class="register-now-container">
                    <div class="grid-inner">
                        <div class="left-image"><img src="<?php echo $template_dir;?>/static/img/bibliothek.png" alt=""/></div>
                        <div class="text-content">
                            <div class="register-now-title">
                                Melde dich jetzt an und<br/>entdecke alle Vorteile!
                            </div>
                            <div class="register-now-text">Profile speichern, Benachrichtigungen erhalten, <br/>Angebote sichern, direkter Austausch, komplett gratis</div>
                            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('registration'));?>" class="button-link"><?php _e('Jetzt anmelden','teilnahmekultur');?></a>
                        </div>

                        <div class="right-image"><img src="<?php echo $template_dir;?>/static/img/neuulm.png" alt="<?php _e('Illustrierte Häuser','teilnahmekultur');?>"/></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <footer>
        <div class="grid-inner">
            <div class="logos">
                <a href="https://www.ulm.de/" target="_blank"><img class="logo" src="<?php echo $template_dir;?>/static/img/stadt_ulm.svg" alt="Ulm/Neu Ulm"/></a>
                <div class="divider"></div>
                <a href="https://www.ulm.de/leben-in-ulm/digitale-stadt" target="_blank"><img class="logo" src="<?php echo $template_dir;?>/static/img/ulm_clever_city.svg" alt="Ulm 4 Clever City"/></a>
                <div class="divider"></div>
                <a href="https://www.bmi.bund.de/" target="_blank"><img class="logo" src="<?php echo $template_dir;?>/static/img/bim_foederung.png" alt="Gefördert durch das Bundesministerium des Inneren, für Bau und Heimat"/></a>
                <div class="divider"></div>
                <a href="#" target="_blank"><img class="logo" src="<?php echo $template_dir;?>/static/img/kfw.svg" alt="KFW"/></a>
            </div>

            <div class="right-col">
                <div class="footer-navigation-container">
                    <nav aria-label="<?php _e('Menü mit rechtlichen Links','teilhabekultur');?>">
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-navigation',
                                'container'      => ''
                            ));

                        ?>
                    </nav>
                </div>

                <div class="social-icons">
                    <a href="https://www.instagram.com/kultur.in.ulm/" target="_blank"><img class="social-icon" src="<?php echo $template_dir;?>/static/img/social-icons/instagram_black.svg" alt="Instagram"/></a><a href="https://www.facebook.com/kulturinulm" target="_blank"><img class="social-icon" src="<?php echo $template_dir;?>/static/img/social-icons/facebook_black.svg" alt="Facebook"/></a><a href="https://www.youtube.com/channel/UCOCvSl-qIC2kTVwu3uejSSg" target="_blank"><img class="social-icon" src="<?php echo $template_dir;?>/static/img/social-icons/youtube_black.svg" alt="YouTube"/></a>
                </div>
            </div>
        </div>
    </footer>
</div>

<div class="mobile-navbar">
    <nav class="flex full-width" aria-label="<?php _e('Mobile Schnellnavigation','teilhabekultur');?>">
        <?php
            $home_url = apply_filters('wpml_home_url', get_option('home'));
            $template_path = get_template_directory();
        ?>

        <a href="<?php echo $home_url;?>" class="navbar-item <?php if(is_front_page()) {?>active<?php }?>">
            <?php include($template_path . '/static/img/navbar/start.svg');?>
            <div class="navbar-item-title"><?php _e('Start', 'teilhabekultur');?></div>
        </a>

        <?php
            $user = wp_get_current_user();
            if(!empty($user)) {
                if(in_array('artist', (array) $user->roles)) {
                    $loggedIn = true;
                } else {
                    $loggedIn = false;
                }
            } else {
                $loggedIn = false;
            }
        ?>

        <?php if($loggedIn) {?>
            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'));?>" class="navbar-item">
                <?php include($template_path . '/static/img/navbar/mein_profil.svg');?>
                <div class="navbar-item-title"><?php _e('Mein Profil', 'teilhabekultur');?></div>
            </a>
        <?php } else { ?>
            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'));?>" class="navbar-item <?php if(get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('login_register') || get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('registration')) {?>active <?php } ?>">
                <?php include($template_path . '/static/img/navbar/mein_profil.svg');?>
                <div class="navbar-item-title"><?php _e('Login', 'teilhabekultur');?></div>
            </a>
        <?php } ?>

        <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('offer_overview'));?>" class="navbar-item <?php if(get_the_ID() == Cortex_Kulturvermittlung_Config::getPageId('offer_overview') || is_singular('angebot')) {?>active <?php } ?>">
            <?php include($template_path . '/static/img/navbar/angebote.svg');?>
            <div class="navbar-item-title"><?php _e('Angebote', 'teilhabekultur');?></div>
        </a>

        <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('favorites'));?>" class="navbar-item">
            <?php include($template_path . '/static/img/navbar/favoriten.svg');?>
            <div class="navbar-item-title"><?php _e('Favoriten', 'teilhabekultur');?></div>
        </a>

        <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('tip_overview'));?>" class="navbar-item">
            <?php include($template_path . '/static/img/navbar/tipps.svg');?>
            <div class="navbar-item-title"><?php _e('Tipps', 'teilhabekultur');?></div>
        </a>
    </nav>
</div>


<div class="mobile-menu">
    <div class="logo-and-back-container">
        <div class="logo">
            <img src="<?php echo $template_dir;?>/static/img/ulmutopia_logo_white.svg" alt=""/>
        </div>

        <div class="back"></div>
    </div>

    <nav aria-label="<?php _e('Mobiles Navigationsmenü','teilhabekultur');?>">
        <div class="menu-container">
            <?php if($loggedIn) {
                wp_nav_menu(array(
                    'theme_location' => 'primary_logged_in',
                    'menu_class'     => 'mobile-navigation',
                    'container'      => ''
                ));
            } else {
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'mobile-navigation',
                    'container'      => ''
                ));
            }?>

            <ul>
                <li>
                    <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('favorites'));?>"><?php _e('Favoriten','teilhabekultur');?></a>
                </li>
                <li>
                    <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('search'));?>" id="header-search"><?php _e('Suche','teilhabekultur');?></a>
                </li>
                <?php
                if(!empty($user)) {
                    if(in_array('artist', (array) $user->roles)) {?>
                        <li><a href="<?php echo wp_logout_url(home_url()); ?>" id="header-logout"><?php _e('Logout','teilhabekultur');?></a></li>
                    <?php }
                }
                ?>
            </ul>
        </div>
    </nav>
</div>

<?php wp_footer(); ?>
</body>
</html>
