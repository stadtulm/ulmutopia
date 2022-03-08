<?php
get_header();

$widgetoptions = array(
	"size" => "groß",
	"heading_strong" => __('Suche', 'teilhabekultur'),
	"blue_background" => true,
	"island" => "insel01"
);
the_widget('Hero_Element_Widget', $widgetoptions);?>

<?php

if(!empty(get_search_query())) {
    global $wp_query;
    global $query_string;

    $query_args = explode("&", $query_string);
    $search_query = array();


    if(strlen($query_string) > 0) {
        foreach($query_args as $key => $string) {
            $query_split = explode("=", $string);
            $search_query[$query_split[0]] = urldecode($query_split[1]);
        }
    }

    $search_query['posts_per_page'] = 24;
    $query_result = new WP_Query($search_query);
    $cortexSearch = new Cortex_Kulturvermittlung_Search();

    $user_search_args = array (
        'order'      => 'DESC',
        /*'orderby'    => 'meta_key',
        'meta_key'   => 'name_institution_kuenstlerin',*/
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => 'name_institution_kuenstlerin',
                'value'   => get_search_query(),
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'untertitel',
                'value'   => get_search_query(),
                'compare' => 'LIKE'
            ),
        )
    );

    $user_search_query = new WP_User_Query($user_search_args);
    $users = $user_search_query->get_results();
}
?>


	<div class="grid-inner margin-top">

        <div class="full-width margin-bottom-double search-form-container">
            <h3 class="full-width"><?php _e('Neue Suche', 'teilhabekultur'); ?></h3>
            <p><?php _e('Gib einfach einen Suchbegriff und klick auf die Schaltfläche um die Webseite zu durchsuchen.','teilhabekultur');?></p>
            <div class="col7">
                <form action="/" method="get" class="search-form">
                    <input type="text"
                           name="s"
                           class="margin-bottom"
                           value="<?php echo get_search_query(); ?>"
                           placeholder="Suche&hellip;"
                    />
                    <input type="submit" value="<?php _e('Suchen', 'teilhabekultur');?>"/>
                </form>
            </div>
        </div>

        <?php if(!empty(get_search_query())) {?>
            <h2><?php echo $query_result->found_posts + sizeof($users); ?> <?php _e('Treffer für', 'teilhabekultur'); ?> <em><?php echo get_search_query(); ?></em></h2>
            <div class="search-results margin-bottom-double full-width">
                <?php foreach($users as $user) {
                    $userId = 'user_' . $user->ID;
                    ?>
                    <div class="search-item">
                        <div class="flex">
                            <div class="search-preview-image">
                                <img src="<?php echo get_field('profilbild', $userId)['sizes']['medium'];?>"/>
                            </div>
                            <div class="search-preview-text">
                                <div class="over-heading">
                                    <strong>
                                        <?php  _e('Profil', 'teilhabekultur'); ?>
                                    </strong>
                                </div>
                                <h2><?php echo get_field('name_institution_kuenstlerin', $userId);?></h2>
                                <div class="subtitle"><?php echo get_field('untertitel', $userId);?></div>

                                <a href="<?php echo Cortex_Kulturvermittlung_Profiles::generateProfileLink($user->ID); ?>"><?php _e('Diese Ergebnis aufrufen', 'infoma-theme')?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($query_result->have_posts()) {?>

                    <?php /* Start the Loop */ ?>
                    <?php while ($query_result->have_posts()) : $query_result->the_post(); ?>
                        <?php
                            if(get_post_type() == 'angebot') {
                                $link = get_the_permalink();
                            } else if(get_post_type() == 'tip') {

                            } else if(get_post_type() == 'author') {

                            } else {
                                $link = get_the_permalink();
                            }
                        ?>

                        <div class="search-item">
                            <?php if(get_post_type() == 'angebot') { ?>
                                <div class="flex">
                                    <div class="search-preview-image">
                                        <img src="<?php echo get_field('bild')['sizes']['medium'];?>"/>
                                    </div>
                                    <div class="search-preview-text">
                                        <div class="over-heading">
                                            <strong>
                                                <?php echo $cortexSearch->postTypes[get_post_type()]; ?>
                                            </strong>
                                        </div>
                                        <h2><?php the_title();?></h2>
                                        <?php echo wp_trim_words(get_field('beschreibung'), 55);?>

                                        <a href="<?php echo $link; ?>"><?php _e('Diese Ergebnis aufrufen', 'teilhabekultur')?></a>
                                    </div>
                                </div>

                            <?php } else if(get_post_type() == 'page') { ?>
                                <div class="flex">
                                    <div class="search-preview-image">&nbsp;</div>
                                    <div class="search-preview-text">
                                        <div class="over-heading">
                                            <strong>
                                                <?php echo $cortexSearch->postTypes[get_post_type()]; ?>
                                            </strong>
                                        </div>
                                        <h2><?php the_title();?></h2>

                                        <?php
                                        $post_meta = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
                                        if(!empty($post_meta)) {
                                            echo $post_meta;
                                        }?>

                                        <a href="<?php echo $link; ?>"><?php _e('Diese Ergebnis aufrufen', 'teilhabekultur')?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php endwhile; wp_reset_postdata(); ?>


                    <?php if($query_result->max_num_pages > 1) { ?>

                        <div class="pagination">
                            <?php previous_posts_link('<span class="pagination-prev"></span>'); ?>
                            <?php
                            for($i = 1; $i <= $query_result->max_num_pages; $i++) {
                                ?>
                                <a <?php if($paged == $i) {echo 'class="active"'; }?> href="?s=<?php echo get_search_query() ?>&paged=<?php echo $i;?>"><?php echo $i; ?></a>
                                <?php
                            }
                            ?>
                            <?php next_posts_link('<span class="pagination-next"></span>', $query_result->max_num_pages) ?>
                        </div>

                    <?php } ?>


                <?php } else if(sizeof($users) == 0){ ?>
                    <div class="margin-top">
                        <h4><?php _e('Keine Suchergebnisse gefunden', 'teilhabekultur');?></h4>
                        <p><?php _e('Für Ihre Suchanfrage konnten leider keine Suchergebnisse gefunden werden.', 'teilhabekultur');?></p>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
	</div>
<?php get_footer();


