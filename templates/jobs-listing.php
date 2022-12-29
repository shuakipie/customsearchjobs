<?php
/**
 *
 *
 */

get_header();

$state_id = -1;
$city_id = -1;
$cities = array();
$state_param = isset($_GET['state']) ? $_GET['state'] : 'all';
$city_param = isset($_GET['city']) ? $_GET['city'] : 'all';
$job_category_param = isset($_GET['job_category']) ? $_GET['job_category'] : 'all';
$job_search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$current_location = isset($_GET['current_location']) && $_GET['current_location'] == 1 ? $_GET['current_location'] : 0;

$states = get_terms(array( 'taxonomy' => 'area', 'parent' => 0, 'hide_empty' => false ));
$job_categories = get_terms(array( 'taxonomy' => 'job-category' ));

if(is_tax('area')){
    $queried_object = get_queried_object();

    if($queried_object->parent == 0){
	    $state_id = $queried_object->term_id;
    }else{
        $city_id = $queried_object->term_id;
       // $state_term = get_term($queried_object->parent, 'area', OBJECT);
        $state_id = $queried_object->parent;

    }

	$cities = get_terms(array( 'taxonomy' => 'area', 'parent' => $state_id ));

}else{
	$cities = get_terms(array( 'taxonomy' => 'area', 'parent' => intval($state_param), 'hide_empty' => false ));
}

if($state_param == 'all' && $state_id != -1){
    $state_param = $state_id;
}

if($city_param == 'all' && $state_id != -1){
	$city_param = $city_id;
}

?>
    <div class="main">
        <div class="container igj-container">
            <div class="row filter-ordering">
                <div class="col-12">
                    <select name="job_ordering" id="job_ordering">
                        <option <?php echo $sort == 'title_asc' ? 'selected' : ''  ?> value="title_asc">Job Title (A-z)</option>
                        <option <?php echo $sort == 'title_desc' ? 'selected' : ''  ?> value="title_desc">Job Title (Z-a)</option>
                        <option <?php echo $sort == 'date_desc' ? 'selected' : ''  ?> value="date_desc">Newest</option>
                        <option <?php echo $sort == 'date_asc' ? 'selected' : '' ?> value="date_asc">Oldest</option>
                        <option <?php echo $sort == 'pay_desc' ? 'selected' : '' ?> value="pay_desc">$ Max</option>
                        <option <?php echo $sort == 'pay_asc' ? 'selected' : '' ?> value="pay_asc">$ Min</option>
                    </select>
                </div>
            </div>
            <div class="igj-wrapper">
                <div class="col-md-4 igj_filters">
                    <div class="row">
                        <div class="col-12 mb-4 ui-widget">
                            <input type="text" id="job_search" placeholder="Search" value="<?php echo $job_search ?>" >
                            <div class="job-result-wrapper" style="display: none"></div>
                        </div>
                        <div class="col-12 mb-4 location_filter" <?php echo $current_location == 1 ? 'style="display:none"' : '' ?>>
                            <select class="igj_field_filter" name="igj_states" id="igj_states">
                                <option value="all">All States</option>
                                <?php foreach ($states as $state){ ?>
                                    <option <?php echo $state->term_id == $state_param ? 'selected' : '' ?> value="<?php echo $state->term_id ?>"><?php echo $state->name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 mb-4 location_filter" <?php echo $current_location == 1 ? 'style="display:none"' : '' ?>>
                            <select <?php echo  count($cities) == 0 ? 'disabled' : ''  ?> class="igj_field_filter" name="igj_cities" id="igj_cities">
                                <option value="all">All Cities</option>
                                <?php
                                    if(count($cities) > 0){
                                        foreach ($cities as $city){ ?>
                                            <option <?php echo $city->term_id == $city_param ? 'selected' : '' ?> value="<?php echo $city->term_id ?>"><?php echo $city->name ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <select class="igj_field_filter" name="igj_job_categories" id="igj_job_categories">
                                <option value="all">All Job Categories</option>
                                <?php foreach ($job_categories as $job_category){ ?>
                                    <option <?php echo $job_category->term_id == $job_category_param ? 'selected' : '' ?> value="<?php echo $job_category->term_id ?>"><?php echo $job_category->name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 mb-4 mt-4">
                            <input <?php echo $current_location == 1 ? 'checked' : '' ?>  type="checkbox" id="current_location">
                            <label class="current_location_label" for="current_location">Get result only in my area</label>
                        </div>

                        <div class="col-12 mb-4">
                            <button id="get_jobs_btn" class=" igj_field_filter">Get Jobs</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 igj_jobs">

                </div>
            </div>

            <div class="igj_pagination-container">
                <div class="igj_pagination-wrapper">
                    <nav aria-label="Jobs Pagination" class="text-center">
                        <ul class="igj_pagination pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-content">
		<div class="row">
			<div class="bialty-container">
		<div id="fws_63ac84d6de40b" data-column-margin="default" data-midnight="dark" data-top-percent="4%" data-bottom-percent="4%" class="wpb_row vc_row-fluid vc_row top-level full-width-section first-section loaded" style="padding-top: calc(100vw * 0.04); padding-bottom: calc(100vw * 0.04); "><div class="row-bg-wrap" data-bg-animation="none" data-bg-overlay="false"><div class="inner-wrap"><div class="row-bg viewport-desktop" style=""></div></div></div><div class="row_col_wrap_12 col span_12 dark left">
	<div class="vc_col-sm-12 wpb_column column_container vc_column_container col padding-4-percent inherit_tablet inherit_phone " data-padding-pos="bottom" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner">
			<div class="wpb_wrapper">
				<div id="fws_63ac84d6e0e30" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 vc_hidden-sm vc_hidden-xs wpb_column column_container vc_column_container col child_column has-animation no-extra-padding inherit_tablet inherit_phone triggered-animation animated-in" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in-from-bottom" data-delay="0" style="opacity: 1; transform: none;">
		<div class="vc_column-inner">
		<div class="wpb_wrapper ">
			
		</div> 
	</div>
	</div> 
 
	
			<?php  if ( is_tax('area', 'tx') OR ($state_param==482)){
           
                ?>
                <div class="vc_col-sm-6 vc_col-xs-12 wpb_column column_container vc_column_container col child_column centered-text has-animation no-extra-padding inherit_tablet inherit_phone triggered-animation animated-in" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in-from-bottom" data-delay="0" style="opacity: 1; transform: none;">
		<div class="vc_column-inner">
		<div class="wpb_wrapper">

                <div class="wpb_text_column wpb_content_element " style=" max-width: 600px; display: inline-block;">
	<div class="wpb_wrapper space">
		<h2>Texas Locations</h2>
	</div>
</div>




		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 vc_hidden-sm vc_hidden-xs wpb_column column_container vc_column_container col child_column no-extra-padding inherit_tablet inherit_phone " data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner">
		<div class="wpb_wrapper ">
			
		</div> 
	</div>
	</div> 
</div></div>
</div></div><div id="texas" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="0" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720294058">Dallas, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:469-486-2487">Call: 469-486-2487</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="300" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="300" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720298164">Irving, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:773-939-7841">Call: 773-939-7841</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="600" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="600" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720301236">Hutchins, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:214-549-2097">Call: 214-549-2097</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="900" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="900" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720304250">Wilmer, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:817-264-2703">Call: 817-264-2703</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 
</div></div><div id="fws_63ac84d6e72d2" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="0" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720310831">Roanoke, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:214-708-3143">Call: 214-708-3143</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="300" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="300" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720314352">Garland, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:682-240-0242">Call: 682-240-0242</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="600" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="600" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720318176">Fort Worth, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:469-682-6649">Call: 469-682-6649</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="900" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="900" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720322069">Arlington, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:817-703-4738">Call: 817-703-4738</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 
</div></div><div id="fws_63ac84d6ea113" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="0" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720333106">Grand Prarie, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:469-901-9898">Call: 469-901-9898</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="300" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="300" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720335841">Lancaster, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:972-914-0753">Call: 682-240-0242</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="600" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="600" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720338753">Lewisville, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:469-705-9953">Call: 469-705-9953</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge triggered-animation animated-in" data-border-animation="true" data-border-animation-delay="900" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="900" style="opacity: 1; transform: none;">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap animation completed" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720341993">Paris, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:903-900-0413">Call: 903-900-0413</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 
</div></div><div id="fws_63ac84d6ed34b" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone " data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="0">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720894106">Houston, TX</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:281-224-4871">Call: 281-224-4871</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 
</div></div><div id="ohio" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row" style="padding-top: 3%; padding-bottom: 3%; "><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 vc_hidden-sm vc_hidden-xs wpb_column column_container vc_column_container col child_column has-animation no-extra-padding inherit_tablet inherit_phone " data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in-from-bottom" data-delay="0">
		<div class="vc_column-inner">
		<div class="wpb_wrapper ">
			
		</div> 
	</div>
	</div> 
            <?php } 
            
            ?>
<?php  if (is_tax('area', 'oh')  OR ($state_param==497) ){ ?>
    <div class="vc_col-sm-6 vc_col-xs-12 wpb_column column_container vc_column_container col child_column centered-text has-animation no-extra-padding inherit_tablet inherit_phone " data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in-from-bottom" data-delay="0">
		<div class="vc_column-inner">
		<div class="wpb_wrapper ">
			
<div class="wpb_text_column wpb_content_element " style=" max-width: 600px; display: inline-block;">
	<div class="wpb_wrapper space">
		<h2>Ohio Locations</h2>
	</div>
</div>




		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 vc_hidden-sm vc_hidden-xs wpb_column column_container vc_column_container col child_column no-extra-padding inherit_tablet inherit_phone " data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner">
		<div class="wpb_wrapper ">
			
		</div> 
	</div>
	</div> 
</div></div><div id="fws_63ac84d6ef150" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both" data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="0">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720403103">New Concord, OH</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:740-221-6920">Call: 740-221-6920</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge" data-border-animation="true" data-border-animation-delay="300" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="300">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720410292">Columbus, OH</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:513-658-6595">Call: 614-530-0811</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both" data-border-animation="true" data-border-animation-delay="600" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="600">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720415230">Cincinnati, OH</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:513-658-6595">Call: 513-658-6595</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths right-edge" data-border-animation="true" data-border-animation-delay="900" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="900">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1610720421891">Fairfield, OH</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:513-658-6595">Call: 513-374-4987</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 
</div></div><div id="ohio" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone " data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="0">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1604451677025">Sharonville, OH</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:513-978-3404">Call: 513-978-3404</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 
</div></div><div id="georgia" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row" style="padding-top: 3%; padding-bottom: 3%; "><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 vc_hidden-sm vc_hidden-xs wpb_column column_container vc_column_container col child_column has-animation no-extra-padding inherit_tablet inherit_phone " data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in-from-bottom" data-delay="0">
		<div class="vc_column-inner">
		<div class="wpb_wrapper">
			
		</div> 
	</div>
	</div> 
   
   <?php } 
            
            ?>

<?php  if (is_tax('area', 'ga') OR ($state_param==485) ){ ?>
    
	<div class="vc_col-sm-6 vc_col-xs-12 wpb_column column_container vc_column_container col child_column centered-text has-animation no-extra-padding inherit_tablet inherit_phone " data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in-from-bottom" data-delay="0">
		<div class="vc_column-inner">
		<div class="wpb_wrapper">
			
<div class="wpb_text_column wpb_content_element " style=" max-width: 600px; display: inline-block;">
	<div class="wpb_wrapper space">
		<h2>Georgia Locations</h2>
	</div>
</div>




		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 vc_hidden-sm vc_hidden-xs wpb_column column_container vc_column_container col child_column no-extra-padding inherit_tablet inherit_phone " data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner">
		<div class="wpb_wrapper ">
			
		</div> 
	</div>
	</div> 
</div></div><div id="fws_63ac84d6f422b" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both" data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="300">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1616093062359">Jonesboro, GA</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:470-507-8005">Call: 470-507-8005</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:404-403-6184">Call: 404-403-6184</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column padding-4-percent inherit_tablet inherit_phone one-fourths right-edge" data-border-animation="true" data-border-animation-delay="300" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1612547364633">Austell, GA</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:470-637-3383">Call: 470-637-3383</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:404-824-8009">Call: 404-824-8009</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column padding-4-percent inherit_tablet inherit_phone one-fourths clear-both" data-border-animation="true" data-border-animation-delay="600" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1635351574112">Lithia Springs, GA</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:470-560-7401">Call: 470-560-7401</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:470-420-5635">Call: 470-420-5635</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column padding-4-percent inherit_tablet inherit_phone one-fourths right-edge" data-border-animation="true" data-border-animation-delay="900" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1635351052347">Acworth, GA</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:404-402-1803">Call: 404-402-1803</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:404-402-2450">Call: 404-402-2450</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 
</div></div><div id="fws_63ac84d703bdf" data-midnight="" data-column-margin="default" class="wpb_row vc_row-fluid vc_row inner_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" style=""><div class="row-bg-wrap"> <div class="row-bg"></div> </div><div class="row_col_wrap_12_inner col span_12  left">
	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column has-animation padding-4-percent inherit_tablet inherit_phone one-fourths clear-both" data-border-animation="true" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="fade-in" data-delay="300">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1635350726722">Newnan, GA</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:470-792-5451">Call: 470-792-5451</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

	<div class="vc_col-sm-3 wpb_column column_container vc_column_container col child_column padding-4-percent inherit_tablet inherit_phone one-fourths right-edge" data-border-animation="true" data-border-animation-delay="300" data-border-width="2px" data-border-style="solid" data-border-color="#000000" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-animation="" data-delay="0">
		<div class="vc_column-inner" style="border: 2px solid rgba(255,255,255,0); "><span class="border-wrap" style="border-color: #000000;"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>
		<div class="wpb_wrapper border-round">
			<h4 style="color: #0a0a0a;text-align: left" class="vc_custom_heading vc_custom_1635351586577">Union City, GA</h4><div class="divider-wrap" data-alignment="default"><div style="height: 30px;" class="divider"></div></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="tel:470-307-0453">Call: 470-307-0453</a></span></h5></div><div class="nectar-cta  alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit " data-color="default" data-using-bg="false" data-display="block" data-style="underline" data-alignment="left" data-text-color="custom"><h5 style="color: #fe0200;"> <span class="text"> </span><span class="link_wrap"><a target="_blank" class="link_text" style="border-color: #fe0200;" href="mailto:info@inergroup.com">Email Office</a></span></h5></div>
		</div> 
	</div>
	</div> 

    <?php } 
            
            ?>


</div></div>
			</div> 
		</div>
	</div> 
</div></div>
</div>
		</div>
	</div>

    <?php
get_footer();
