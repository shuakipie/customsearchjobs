<?php
/**
 * The template for displaying single posts.
 *
 * @package Salient WordPress Theme
 * @version 13.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$job_id = get_post_meta($post->ID, 'job_id', true) ? get_post_meta($post->ID, 'job_id', true) : -1;
$job_apply_link = get_post_meta($post->ID, 'job_link_apply', true);
$job_type = get_post_meta($post->ID, 'job_type', true);
$job_pay_actual = get_post_meta($post->ID, 'job_pay_actual', true);
$job_pay_max = get_post_meta($post->ID, 'job_pay_max', true);
$job_pay_min = get_post_meta($post->ID, 'job_pay_min', true);
$job_owner = get_post_meta($post->ID, 'job_owner', true);
$job_category = get_post_meta($post->ID, 'job_category', true);
$job_board_name = get_post_meta($post->ID, 'job_board_name', true);
$job_country = get_post_meta($post->ID, 'job_country', true);

$terms = get_the_terms( $post->ID, 'area' );
if($terms[0]->name && strlen($terms[0]->name) == 2){
    $state = $terms[0];
    $city = $terms[1];
}else{
    $state = $terms[1];
    $city = $terms[0];
}

get_header();

$draft_post = false;
$job_avionte = igj_single_job($job_id);

if(!isset(igj_single_job($job_id)['PostId'])){
    $draft_post = true;
    wp_update_post(array('ID' => $post->ID, 'post_status' => 'draft'));
}


?>



<div class="container job_single">

    <?php if(!$draft_post){ ?>

    <div class="row heading-title hentry" data-header-style="default_minimal">
        <div class="col span_12 section-title blog-title">
            <h1 class="job-title entry-title"><?php echo get_the_title(); ?></h1>

        </div>
    </div>

    <div class="row">
        <div class="col span_2 job-location">
            <strong><i class="fa fa-map-marker" aria-hidden="true"></i><span> <?php echo $city->name . ', ' . $state->name; ?></span></strong>
        </div>
        <div class="col span_2 job-date">
            <strong><i class="fa fa-calendar" aria-hidden="true"></i><span> <?php echo date('m-d-Y', strtotime($post->post_date)) ?></span></strong>
        </div>
        <!--<div class="col span_2">
            <strong><i class="fa fa-user" aria-hidden="true"></i><span> <?php /*echo $job_owner */?></span></strong>
        </div>-->
        <div class="col span_2 job-pay">
            <strong><i class="fa fa-money" aria-hidden="true"></i><span> <?php echo '$' . number_format($post->post_excerpt, 2, ".", ","); ?></span></strong>
        </div>
        <div class="col span_6 job-id">
            <strong class="post_reference">Reference: <?php echo $job_id ?></strong>
        </div>
    </div>

    <div class="row">

        <div class="post-area job-content col">

            <?php
            // Main content loop.
            if ( have_posts() ) :
                while ( have_posts() ) :

                    the_post();
                    echo "<p class='job-description'><strong>Description:</strong></p>";
                    get_template_part( 'includes/partials/single-post/post-content' );

                endwhile;
            endif;


            ?>

        </div><!--/post-area-->

    </div><!--/row-->
    <div class="row">
        <div class="col">
            <a href="<?php echo $job_apply_link  ?>" class="apply-link button_solid_color" >Apply Now</a>
        </div>
    </div>


    <?php }else{ ?>
        <div class="row">
            <div class="col">
                <h3>This job is not longer available</h3>
            </div>
        </div>
    <?php } ?>


</div><!--/container main-content-->

<?php get_footer(); ?>
