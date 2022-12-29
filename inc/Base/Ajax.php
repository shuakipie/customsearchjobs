<?php

/*
*
* @package Yariko
*
*/

namespace Igj\Inc\Base;

class Ajax{

    public function register(){

        /**
         * Ajax actions
         */
        add_action( 'wp_ajax_igj_get_jobs', array($this,'get_jobs'));
        add_action( 'wp_ajax_nopriv_igj_get_jobs', array($this,'get_jobs'));

        add_action( 'wp_ajax_igj_job_suggestion', array($this,'get_jobs_suggestions'));
        add_action( 'wp_ajax_nopriv_igj_job_suggestion', array($this,'get_jobs_suggestions'));

        add_action( 'wp_ajax_igj_job_cities', array($this,'get_cities'));
        add_action( 'wp_ajax_nopriv_igj_job_cities', array($this,'get_cities'));

    }

    function get_jobs_suggestions(){
        global $wpdb;

        $search = $_POST['search'];

        $jobs = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->prefix" . "posts WHERE post_type = 'job' AND post_status = 'publish' AND post_title LIKE '%$search%'  LIMIT 5 ", ARRAY_A);


        echo json_encode(array('success' => true,'jobs' => $jobs));
        wp_die();
    }

    function get_cities(){

        $cities = get_terms(array( 'taxonomy' => 'area', 'parent' => $_POST['state'] ));

        echo json_encode(array('success' => true,'cities' => $cities));
        wp_die();
    }

     function get_jobs(){
         global $wpdb;
         $length = $_POST['length'];
         $page = $_POST['page'];
         $city = $_POST['city'];
         $state = $_POST['state'];
         $job_category = $_POST['job_category'];
         $job_search = $_POST['search'];
         $sort = $_POST['sort'];
         $current_location = $_POST['current_location'];

         $offset = $length * ($page - 1);

         $rel_query_city = '';
         $rel_query_state = '';
         $rel_query_job_category = '';
         $search_query = '';

         if(!empty($current_location)){
	         $city_job = igj_get_user_city();
             $term = get_term_by('name', $city_job, 'city');
             if($term){
                 $city = $term->term_id;
             }
         }

         if($state !== 'all'){
             $rel_query_state = "AND ID IN (SELECT object_id FROM $wpdb->prefix" . "term_relationships WHERE term_taxonomy_id=$state) ";
         }

         if($city !== 'all'){
             $rel_query_city = " AND ID IN (SELECT object_id FROM $wpdb->prefix" . "term_relationships WHERE term_taxonomy_id=$city) ";
         }

         if($job_category !== 'all'){
             $rel_query_job_category = " AND ID IN (SELECT object_id FROM $wpdb->prefix" . "term_relationships WHERE term_taxonomy_id=$job_category) ";
         }

         if(!empty($job_search)){
             $search_query = 'AND (post_title LIKE "%'. $job_search .'%" OR post_content LIKE "%'. $job_search .'%")';
         }

         $ordering = '';

         if($sort == 'title_desc'){ $ordering = ' ORDER BY post_title DESC'; }
         if($sort == 'title_asc'){ $ordering = ' ORDER BY post_title ASC'; }
         if($sort == 'date_desc'){ $ordering = ' ORDER BY post_date DESC'; }
         if($sort == 'date_asc'){ $ordering = ' ORDER BY post_date ASC'; }
         if($sort == 'pay_desc'){ $ordering = ' ORDER BY post_excerpt DESC'; }
         if($sort == 'pay_asc'){ $ordering = ' ORDER BY post_excerpt ASC'; }

        $jobs = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $wpdb->prefix" . "posts WHERE post_type = 'job' AND post_status = 'publish' $rel_query_city $rel_query_state $rel_query_job_category $search_query $ordering  LIMIT $offset,$length ", ARRAY_A);
        $found_rows = $wpdb->get_results('SELECT FOUND_ROWS() as count', OBJECT);

         if($found_rows > 0){
             $total = intval($found_rows[0]->count);
         }
         ob_start();
         if(count($jobs) > 0){
             foreach ($jobs as $job){
                 $pay = $job['post_excerpt'];
                 $date = date('m-d-Y', strtotime($job['post_date']));
                 $terms = get_the_terms( $job['ID'], 'area' );
                 if($terms[0]->name && strlen($terms[0]->name) == 2){
                     $state = $terms[0];
                     $city = $terms[1];
                 }else{
                     $state = $terms[1];
                     $city = $terms[0];
                 }
                 $description = get_post_meta($job['ID'], 'job_description', true);
                 $job_description = !empty($job_search) ? str_ireplace($job_search, "<span class='igj-highlight-term'>".$job_search."</span>", $description) : $description;
                 $job_title  = !empty($job_search) ? str_ireplace($job_search, "<span class='igj-highlight-term'>".$job_search."</span>", $job['post_title']) : $job['post_title'];
                 ?>
                 <a href="<?php echo $job['guid']; ?>"><h3 class="job-title"><?php echo  $job_title ?></h3></a>
                 <strong class="job-meta"><i class="fa fa-map-marker" aria-hidden="true"></i><span> <?php echo $city->name . ', ' . $state->name; ?></span></strong>
                 <strong class="job-meta"><i class="fa fa-calendar" aria-hidden="true"></i><span> <?php echo $date ?></span></strong>
                 <strong class="job-meta"><i class="fa fa-money" aria-hidden="true"></i><span> <?php echo '$' . number_format($pay, 2, ".", ","); ?></span></strong>
                 <strong class="post_reference">Reference: <?php echo get_post_meta($job['ID'],'job_id', true); ?></strong>
                 <p class="post_content"><?php echo substr($job_description, 0, 300) . ' ';  ?><a class="job-more-link" target="_blank" href="<?php echo $job['guid']; ?>"> More</a></p>
                 <hr>
                 <?php
             }
         }else{
             ?>
             <p class="text-center">There is not job with that criteria</p>
             <?php
         }

         $html_result = ob_get_clean();

         echo json_encode(array('success' => true,'jobs' => $html_result, 'totalJobs' => $total, 'page' => $page, 'length' => $length));
         wp_die();
     }
}
