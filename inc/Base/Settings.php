<?php

/*
*
* @package Yariko
*
*/

namespace Igj\Inc\Base;

use Igj\Inc\Services\AvionteServices;

class Settings{

    public function register(){

        add_action( 'init', array($this, 'cptui_register_my_cpts') );

        add_action( 'init', array($this, 'cptui_register_my_taxes') );

        //add_action('igj_cron_get_taxonomies', array($this, 'igj_cron_get_taxonomies'));
        add_action('igj_fetching_jobs', array($this, 'igj_fetching_jobs'));

        add_shortcode( 'igj_jobs', array($this, 'job_listing') );

        add_filter( 'template_include', array($this, 'post_template') );

        add_shortcode( 'es_states_list', array($this, 'es_states_list') );


    }

    /**
     * @return false|string
     * @description Shortcode to create the ui to select the service and the service interval
     */
    function es_states_list(){
        ob_start();

        $areas = get_terms(array( 'taxonomy' => 'area', 'parent' => 0 ));
        ?>
        <div class="container">
            <div class="row">
                <?php foreach ($areas as $area): ?>
                    <div class="es_area col-4"><a class="area-wrapper" href="/area/<?php echo $area->slug ?>"><span><?php echo $area->description ?></span><span><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></div>

                <?php endforeach; ?>
            </div>
            <div class="row all_areas">
                <button class="all_areas_btn"><a href="/job-listing">Browse all location</a></button>
            </div>
        </div>
        <?php
        return  ob_get_clean();
    }

    function post_template($template)
    {
        if (is_singular( 'job' )){
            $template = IGJ_PLUGIN_PATH . 'templates/post.php';

        }

        if(is_tax('area')){
            $template = IGJ_PLUGIN_PATH . 'templates/jobs-listing.php';
        }

        return $template;
    }

    function job_listing(){
        ob_start();

        //get product business
        $jobs = get_posts(array(
            'numberposts'	=> -1,
            'post_type'		=> 'job',
        ));

        ?>
        <div class="igj_filters"></div>
        <div class="igj_jobs">
            <?php foreach ($jobs as $job){
                $state = get_the_terms( $job->ID, 'state' );
                $city = get_the_terms( $job->ID, 'city' );

                ?>
                <h3><?php echo $job->post_title; ?></h3>
                
                <strong><i class="fa fa-map-marker" aria-hidden="true"></i><span> <?php echo $city[0]->name . ', ' . $state[0]->name; ?></span></strong>
                <p><?php echo substr($job->post_content, 0, 300) . ' ';  ?><a target="_blank" href="<?php echo $job->guid ?>"> More</a></p>
                <hr>
            <?php } ?>
        </div>


        <?php
        return  ob_get_clean();
    }

    /*function igj_cron_get_taxonomies(){

        $avionte = new AvionteServices();

        $jobs = $avionte->getJobs();

        foreach ($jobs as $job){
            if(!empty($job['JobCity'])){
                wp_insert_term($job['JobCity'], 'city');
            }

            if(!empty($job['JobState'])){
                wp_insert_term($job['JobState'], 'state');
            }
        }

    }*/

    function igj_fetching_jobs(){

        $avionte = new AvionteServices();

        $jobs = $avionte->getJobs();

        $job_indexes_wp = unserialize(get_option('igj_indexes'));

        foreach ($jobs as $job){
            if(!in_array($job['PostId'], $job_indexes_wp)){

                $job_indexes_wp[] = $job['PostId'];

                $post_date = date("Y-m-d", strtotime($job['JobDate']));

                $array_post = array(
                    "post_type" => 'job',
                    "post_title" => wp_strip_all_tags( $job['Name'] ),
                    "post_content" =>  $job['JobDesc_HTML'],
                    'post_status'  => 'publish',
                    'post_date' => $post_date,
                    'post_excerpt' => floatval($job['PayActual']) . ''
                );

                $post_id = wp_insert_post( $array_post );

                add_post_meta($post_id, 'job_id', $job['PostId']);
                add_post_meta($post_id, 'job_link_apply', $job['ApplyLink']);
                //add_post_meta($post_id, 'job_date', $job['JobDate']);
                //add_post_meta($post_id, 'job_pay_actual', floatval($job['PayActual']));
                add_post_meta($post_id, 'job_pay_max', floatval($job['PayMax']));
                add_post_meta($post_id, 'job_pay_min', floatval($job['PayMin']));
                add_post_meta($post_id, 'job_owner', $job['Owner']);
                add_post_meta($post_id, 'job_category', $job['Category']);
                add_post_meta($post_id, 'job_board_name', $job['BoardName']);
                add_post_meta($post_id, 'job_country', $job['JobCountry']);
                add_post_meta($post_id, 'job_description', $job['JobDesc_TEXT']);

                //This creates the relation tax-post automatically, it does need the tax sync run (the term is created just in case this one do not exist)
              $state = get_term_by('name', $job['JobState'], 'area');
              $city = get_term_by('name', $job['JobCity'], 'area');

              if(!$state){
                  $state = wp_insert_term($job['JobState'], 'area');
                 // wp_set_post_terms( $post_id, array($job['JobState']), 'area' );
              }

              if(!$city){
                 $city = wp_insert_term($job['JobCity'], 'area', array('parent' => $state->term_id ?: $state['term_id']));
              }

              wp_set_post_terms( $post_id, array($state->term_id ?:  $state['term_id'], $city->term_id ?:  $city['term_id'] ) , 'area' );

              wp_set_post_terms( $post_id, array($job['Category']), 'job-category' );
              wp_set_post_terms( $post_id, array($job['JobType']), 'job-type' );

            }
        }

        update_option('igj_indexes', serialize($job_indexes_wp));

    }

    function cptui_register_my_cpts(){

        /**
         * Post Type: Jobs.
         */

        $labels = [
            "name" => esc_html__( "Jobs", "storefront" ),
            "singular_name" => esc_html__( "Job", "storefront" ),
            "menu_name" => esc_html__( "My Jobs", "storefront" ),
            "all_items" => esc_html__( "All Jobs", "storefront" ),
            "add_new" => esc_html__( "Add new", "storefront" ),
            "add_new_item" => esc_html__( "Add new Job", "storefront" ),
            "edit_item" => esc_html__( "Edit Job", "storefront" ),
            "new_item" => esc_html__( "New Job", "storefront" ),
            "view_item" => esc_html__( "View Job", "storefront" ),
            "view_items" => esc_html__( "View Jobs", "storefront" ),
            "search_items" => esc_html__( "Search Jobs", "storefront" ),
            "not_found" => esc_html__( "No Jobs found", "storefront" ),
            "not_found_in_trash" => esc_html__( "No Jobs found in trash", "storefront" ),
            "parent" => esc_html__( "Parent Job:", "storefront" ),
            "featured_image" => esc_html__( "Featured image for this Job", "storefront" ),
            "set_featured_image" => esc_html__( "Set featured image for this Job", "storefront" ),
            "remove_featured_image" => esc_html__( "Remove featured image for this Job", "storefront" ),
            "use_featured_image" => esc_html__( "Use as featured image for this Job", "storefront" ),
            "archives" => esc_html__( "Job archives", "storefront" ),
            "insert_into_item" => esc_html__( "Insert into Job", "storefront" ),
            "uploaded_to_this_item" => esc_html__( "Upload to this Job", "storefront" ),
            "filter_items_list" => esc_html__( "Filter Jobs list", "storefront" ),
            "items_list_navigation" => esc_html__( "Jobs list navigation", "storefront" ),
            "items_list" => esc_html__( "Jobs list", "storefront" ),
            "attributes" => esc_html__( "Jobs attributes", "storefront" ),
            "name_admin_bar" => esc_html__( "Job", "storefront" ),
            "item_published" => esc_html__( "Job published", "storefront" ),
            "item_published_privately" => esc_html__( "Job published privately.", "storefront" ),
            "item_reverted_to_draft" => esc_html__( "Job reverted to draft.", "storefront" ),
            "item_scheduled" => esc_html__( "Job scheduled", "storefront" ),
            "item_updated" => esc_html__( "Job updated.", "storefront" ),
            "parent_item_colon" => esc_html__( "Parent Job:", "storefront" ),
        ];

        $args = [
            "label" => esc_html__( "Jobs", "storefront" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => [ "slug" => "job", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "editor", "thumbnail" ],
            "show_in_graphql" => false,
        ];

        register_post_type( "job", $args );
    }

    function cptui_register_my_taxes() {

        /**
         * Taxonomy: Areas.
         */

        $labels = [
            "name" => esc_html__( "Areas", "storefront" ),
            "singular_name" => esc_html__( "Area", "storefront" ),
        ];


        $args = [
            "label" => esc_html__( "Areas", "storefront" ),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => true,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'area', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "area",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ];
        register_taxonomy( "area", [ "job" ], $args );

        /**
         * Taxonomy: States.
         */

       /* $labels = [
            "name" => esc_html__( "States", "storefront" ),
            "singular_name" => esc_html__( "State", "storefront" ),
        ];*/


        /*$args = [
            "label" => esc_html__( "States", "storefront" ),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'state', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "state",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ];
        register_taxonomy( "state", [ "job" ], $args );*/

        /**
         * Taxonomy: Job Categories.
         */

        $labels = [
            "name" => esc_html__( "Job Categories", "storefront" ),
            "singular_name" => esc_html__( "Job Category", "storefront" ),
        ];

        $args = [
            "label" => esc_html__( "Job Categories", "storefront" ),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'job-category', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "job-category",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ];
        register_taxonomy( "job-category", [ "job" ], $args );

        /**
         * Taxonomy: Job Type.
         */

        $labels = [
            "name" => esc_html__( "Job Types", "storefront" ),
            "singular_name" => esc_html__( "Job Type", "storefront" ),
        ];

        $args = [
            "label" => esc_html__( "Job Types", "storefront" ),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'job-type', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "job-type",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ];
        register_taxonomy( "job-type", [ "job" ], $args );
    }

}