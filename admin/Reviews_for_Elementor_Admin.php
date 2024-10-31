<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'plugins_loaded', 'render_rfe_HTML' );
function render_rfe_HTML()
{
    if (isset($_POST["form_support"]))
{
	$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));

	$to = 'info@nahiro.net';
$subject = 'Wordpress Support Plugin Review';
$body = 'Client Name: ' .sanitize_text_field($_POST["form_support"]["name"]) . " - Telf:" . sanitize_text_field($_POST["form_support"]["field_2"]) . " - Email: "  . sanitize_email($_POST["form_support"]["field_1"]) . " - Website: " . sanitize_text_field($_POST["form_support"]["email"]) . " - Text: " . sanitize_text_field($_POST["form_support"]["message"]) ;
$headers = array('Content-Type: text/html; charset=UTF-8');
 
wp_mail( $to, $subject, $body, $headers );
	
	$to = sanitize_email($_POST["form_support"]["field_1"]);
$subject = 'Wordpress Unterstützung Plugin Review - Nahiro.net';
$body = 'Ihre Anfrage wurde erfolgreich registriert. Wir werden Sie in Kürze kontaktieren.';
$headers = array('Content-Type: text/html; charset=UTF-8');
wp_mail( $to, $subject, $body, $headers );
	
}       
}

if ( ! class_exists ( 'Reviews_for_Elementor_Admin' ) ) {

    class Reviews_for_Elementor_Admin {

        public function __construct() {
            //
        }

        public function init() {
            add_action ( 'admin_menu', array ( $this, 'add_admin_testimonial_rfe_menu' ) );
            add_action ( 'admin_init', array ( $this, 'register_review_rfe_settings' ) );
            add_action ( 'admin_init', array ( $this, 'register_reviews_rfe_list' ) );
            add_action ( 'admin_init', array ( $this, 'register_support_rfe_options' ) );
            add_action ( 'admin_enqueue_scripts', array ( $this, 'enqueue_scripts_rfe_admin' ) );

            add_action( 'admin_init', array( $this, 'save_options_rfe_popup' ) );
            add_action( 'wp_ajax_fetch_google_reviews', array($this,'fetch_google_rfe_reviews'));
        }

        public function register_support_rfe_options() {

            register_setting ( 'testimonials_support', 'testimonials_support_settings' );

            add_settings_section (
                'testimonials_support_section','',
                array ( $this, 'support_settings_section_callback' ),
                'testimonials_support'
            );

            add_settings_field (
                'heading_text',
                __( 'Header Text', 'nahiro-popup' ),
                array ( $this, 'heading_text_render_popup' ),
                'testimonials_content',
                'testimonials_content_section'
            );
        }
        
        public function register_reviews_rfe_list() {
            register_setting ( 'testimonials_reviews_list', 'testimonials_reviews_list_options' );

            add_settings_section (
                'testimonials_reviews_list_section',
                __( 'Reviews List', 'testimonials-plugin' ),
                array ( $this, 'testimonials_reviews_list_callback' ),
                'testimonials_reviews_list'
            );
        }
		
		

        public function fetch_google_rfe_reviews(){
                
                if ( ! current_user_can( 'manage_options' ) ) {
                    return;
                }
        
                if ( ! isset( $_POST['security_nonce'])  ){
                    return; 
                }
                
                if ( !wp_verify_nonce($_POST['security_nonce'], 'ajax_check_nonce' ) ){
                   return;  
                }
                
                global $testimonials_review_settings_options;
                
                $location  = $blocks = $premium_status = $g_api = $reviews_api = $reviews_api_status = '';

                                
                if(isset($_POST['location'])){
                    $location = sanitize_text_field($_POST['location']);
                }
                
                if(isset($_POST['g_api'])){                    
                    $g_api = sanitize_text_field($_POST['g_api']);                                        
                }
                
                if(isset($_POST['premium_status'])){
                    $premium_status = sanitize_text_field($_POST['premium_status']);
                }
                
                if(isset($_POST['blocks'])){
                    $blocks = intval(sanitize_text_field($_POST['blocks']));
                }
                                                
                if($location){
                    
                   if(isset($testimonials_review_settings_options['locations_names'])){
                          
                       if(!in_array($location, $testimonials_review_settings_options['locations_names'])){
                           array_push($testimonials_review_settings_options['locations_names'], $location);                       
                       }
                                              
                   }else{
                       $testimonials_review_settings_options['locations_names'] = array($location);  
                       
                   }
                                      
                   if(isset($testimonials_review_settings_options['reviews_locations'])){
                          
                       if(!in_array($blocks, $testimonials_review_settings_options['reviews_locations'])){
                           array_push($testimonials_review_settings_options['reviews_locations'], $blocks);                       
                       }
                                              
                   }else{
                       
                           $testimonials_review_settings_options['reviews_locations'] = array($blocks);  
                       
                   }
                
                    if($g_api){
                        $result = $this->get_reviews_data($location,$g_api);
                    }
                                                             
                  echo json_encode($result);
                    
                }else{
                    
                  echo json_encode(array('status' => false, 'message' => esc_html__( 'Place id is empty', 'testimonials-plugin' ))); 
                  
                }
                
                wp_die();
        
            }

public function get_attachment_details($attachments, $post_id = null) {
        
        $response = array();
        
        $cached_data = get_transient('imageobject_' .$post_id); 
        
        if (empty($cached_data)) {
                       
            foreach ($attachments as $url){
             
            $image_data = array();    
            $image = @getimagesize($url);
                     
            $image_data[0] =  $image[0]; //width
            $image_data[1] =  $image[1]; //height
            

                if(empty($image) || $image == false){
                    
                    $img_id           = attachment_url_to_postid($url);
                    $imageDetail      = wp_get_attachment_image_src( $img_id , 'full');
                    $image_data[0]    = $imageDetail[1]; // width
                    $image_data[1]    = $imageDetail[2]; // height
                    
                }
                
              $response[] = $image_data;  
            }
                                  
            set_transient('imageobject_' .$post_id, $response,  24*30*HOUR_IN_SECONDS );   

            $cached_data = $response;
        }
                                            
        return $cached_data;
                    
}

public function save_reviews_data($result_total, $result, $place_id) {
        $allposts= get_posts( array('post_type'=>'testimonial') );
        foreach ($allposts as $eachpost) {
            wp_delete_post( $eachpost->ID, true );
    
        }

        $args = array(
            'post_type'  => 'location',
            'meta_query' => array(
            array(
                'key'   => 'location_id',
                'value' => $result['place_id'],
            )
            )
        );
        $postslist = get_posts( $args );
        foreach ($postslist as $eachpost) {
            wp_delete_post( $eachpost->ID, true );
        }

        $place_saved   = array();
        $reviews_saved = array();
        
        if (isset($result['place_id']) && $result['place_id'] != '') {
                                                                   
                $user_id     = get_current_user_id();
                $postarr = array(
                    'post_author'           => $user_id,                                                            
                    'post_title'            => $result['name'],
                    'post_status'           => 'publish',                                                            
                    'post_name'             => $result['name'],                                                            
                    'post_type'             => 'location',
                                                                             
                );
                   
                $post_id = wp_insert_post(  $postarr );   
                $place_saved[] = $post_id;                                                  
                $review_meta = array(
                        'location_id'                 => $result['place_id'],      
                        'location_review_count'       => $result['user_ratings_total'], 
                        'location_avg_rating'         => $result['rating'],
                        'location_icon'               => $result['icon'],
                        'location_address'            => $result['formatted_address'],
                );

                if($post_id && !empty($review_meta) && is_array($review_meta)){
                                        
                    foreach ($review_meta as $key => $val){                     
                        update_post_meta($post_id, $key, $val);  
                    }
            
                 }
                            
        }

        $allposts= get_posts( array('post_type'=>'testimonial','numberposts'=>-1) );
        foreach ($allposts as $eachpost) {
            wp_delete_post( $eachpost->ID, true );
        }
        
                                            
        if (isset($result['reviews'])) {
            
            $reviews = $result['reviews'];
            
            foreach ($reviews as $review) {
                $user_id     = get_current_user_id();
                $postarr = array(
                    'post_author'           => $user_id,                                                            
                    'post_title'            => $review['author_name'],
                    'post_content'          => $review['text'],
                    'post_status'           => 'publish',                                                            
                    'post_name'             => 'Review for Elementor by Nahiro.net',                                                                       'post_date'             => substr($review['datetime'], 0, strlen($review['datetime']) - 1),
                    'post_type'             => 'testimonial',
                                                                             
                );
                   
                $post_id = wp_insert_post(  $postarr );   
                $reviews_saved[] = $post_id;
                $term     = get_term_by( 'slug','google', 'platform' );
                
                $media_detail = array();
                
                if(isset($review['profile_photo_url'])){
                    
                    $image_details = $this->get_attachment_details(array($review['profile_photo_url']));   
                    
                    $media_detail = array(                                                    
                        'width'      => $image_details[0][0],
                        'height'     => $image_details[0][1],
                        'thumbnail'  => $review['profile_photo_url'],
                    );
                    
                }  
                
                $review_meta = array(
                        'testimonial_id'             => $review['id'],
                        'testimonial_platform'       => $term->term_id,
                        'testimonial_location_id'    => $place_id,
                        'testimonial_time'           => DateTime::createFromFormat("Y-m-d",date('Y-m-d',$review['time'])),
                        'testimonial_rating'         => $review['rating'],
                        'testimonial_text'           => $review['text'],                                
                        'testimonial_lang'         => $review['language'],
                        'testimonial_name'         => $review['author_name'],
                        'testimonial_link'           => isset($review['author_url']) ? $review['author_url'] : null,
                        'testimonial_image'        => isset($review['profile_photo_url']) ? $review['profile_photo_url'] : null,
                        'testimonial_image_detail' => $media_detail
                );

                if($post_id && !empty($review_meta) && is_array($review_meta)){
                                        
                    foreach ($review_meta as $key => $val){                     
                        update_post_meta($post_id, $key, $val);  
                    }
            
                 }
                
            }
        }
        
        if(!empty($place_saved) || !empty($reviews_saved)){
            return true;
        }else{
            return false;
        }
                
    }

public function get_reviews_data($place_id, $g_api){
                                                   
        $result = @wp_remote_get('https://maps.googleapis.com/maps/api/place/details/json?placeid='.trim($place_id).'&key='.trim($g_api));
    
        
        
        if(isset($result['body'])){
            
           $result = json_decode($result['body'],true);  
            $result_total = array();
            
           if($result['result']){
               $response = $this->save_reviews_data($result_total,$result['result'],  $place_id);
               
               if($response){
                    return array('status' => true, 'message' => esc_html__( 'Fetched Successfully', 'testimonials-plugin' ));
               }else{                                             
                    return array('status' => false, 'message' => esc_html__( 'Not fetched', 'testimonials-plugin' ));
               }
               
           }else{
               if($result['error_message']){
                   return array('status' => false, 'message' => $result['error_message']);
               }else{
                   return array('status' => false, 'message' => esc_html__( 'Something went wrong', 'testimonials-plugin' ));
               }                             
           }
                                                       
        }else{
           return null;
        }                         
    }       

        public function save_options_rfe_popup() {
            $options = get_option( 'testimonials_settings' );
            $options['wisdom_registered_setting'] = 1;
            update_option( 'testimonials_settings', $options );
        }

        public function enqueue_scripts_rfe_admin() {
            $data = array(                                    
            'post_id'                      => get_the_ID(),
            'ajax_url'                     => admin_url( 'admin-ajax.php' ),            
            'security_nonce'         => wp_create_nonce('ajax_check_nonce'),  
            'new_url_selector'             => esc_url(admin_url()).'post-new.php?post_type=saswp',
            'new_url_href'                 => htmlspecialchars_decode(wp_nonce_url(admin_url('index.php?page=add_new_data_type&'), '_wpnonce')),            
            'collection_post_add_url'      => esc_url(admin_url()).'post-new.php?post_type=google-review',
            'collection_post_add_new_url'  => htmlspecialchars_decode(wp_nonce_url(admin_url('admin.php?page=collection'), '_wpnonce')),
            'post_type'                    => $post_type,   
            'page_now'                     => $hook,
            'settings_url'           => esc_url(admin_url('edit.php?post_type=testimonials&page=structured_data_options'))                       
        );
            wp_enqueue_style( 'timepicker-css', RFE_PLG_URL. 'assets/css/jquery.timepicker.css' , array( 'wp-admin' ), '0.1');
            wp_enqueue_script( 'timepicker-js', RFE_PLG_URL.  'assets/js/jquery.timepicker.js' , array( 'jquery-core' ), '0.1' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_script( 'main-review', RFE_PLG_URL . 'assets/js/main-review.js', ['jquery'] );
            wp_enqueue_style ( 'cpo-admin-style', RFE_PLG_URL . 'assets/css/style_admin.css' );
            wp_enqueue_style('style-reviews', RFE_PLG_URL . 'assets/css/style_reviews.css'); 
            wp_localize_script( 'main-review', 'localize_data', $data );
            
            wp_register_script( 'datatables-js', RFE_PLG_URL . 'assets/js/datatables.min.js', null, null, true );
            wp_enqueue_script('datatables-js');
            
            wp_register_style( 'datatables-css',  RFE_PLG_URL . 'assets/css/datatables.min.css' );
            wp_enqueue_style('datatables-css');
        }

        public function add_js_admin() {
            $screen = get_current_screen();
            if ( $screen -> id == 'settings_page_cpo' ) {
            ?>
                <script>
                    jQuery(document).ready(function($){
                        $('.cpo-color-field').wpColorPicker();
                    });
                </script>
            <?php           }
        }

        public function add_admin_testimonial_rfe_menu(  ) {
            add_menu_page ( __('Reviews for Elementor Settings by Nahiro.net', 'testimonials-plugin'), __('Reviews for Elementor', 'testimonials-plugin'), 'manage_options', 'testimonials', array ( $this, 'options_page' ) , null, 2);
        }

        public function register_review_rfe_settings(  ) {

            register_setting ( 'testimonials_review_settings', 'testimonials_review_settings_options' );

            add_settings_section (
                'testimonials_review_settings_section',
                __( 'Review Setting', 'testimonials-plugin' ),
                array ( $this, 'review_setting_section_callback' ),
                'testimonials_review_settings'
            );

            add_settings_field (
                'google_api',
                __( 'Google Place API Key', 'testimonials-plugin' ),
                array ( $this, 'testimonials_review_settings_render' ),
                'testimonials_review_settings',
                'testimonials_review_settings_section'
            );
        }

        public function sanitize_content( $input ){
            $output = array();
            foreach( $input as $key=>$value ) {
                if( isset($input[$key] ) ) {
                    if( $key == 'notification_text' ) {
                        $output[$key] = esc_attr( $input[$key] );
                    } else if( $key == 'more_info_url' ) {
                        $output[$key] = esc_url( $input[$key] );
                    } else {
                        $output[$key] = sanitize_text_field( $input[$key] );
                    }
                }
            }
            return $output;
        }
        

        public function testimonials_review_settings_render()
        {
            $testimonials_review_settings_options = get_option( 'testimonials_review_settings_options' ); ?>
            <div style="display: flex;"><div style="width:80%;"><input required='' class="inp-grfe-np" id="google_place_api_key" type="text" name="testimonials_review_settings_options[google_api]" value="<?php echo esc_attr( $testimonials_review_settings_options['google_api'] ); ?>">
            <label class="lbl-grfe-np" alt='<?php _e( 'Set Google API Keys', 'testimonials-plugin' ); ?>' placeholder="<?php _e( 'Set Google API Keys', 'testimonials-plugin' ); ?>"></label></div><a style="margin-left:2%; padding-top:20px !important;" class="square_btn button-default btn-add-location"><?php echo esc_html__( 'Add Place', 'testimonials-plugin' ); ?></a></div>
            <!--<p class="description"><?php _e( 'Set Google API Keys', 'testimonials-plugin' ); ?></p>-->
            <?php
            if(isset($testimonials_review_settings_options['locations_names']) && !empty($testimonials_review_settings_options['locations_names'])){
                                
                                $rv_loc    = $testimonials_review_settings_options['locations_names'];
                                $rv_blocks = isset($testimonials_review_settings_options['reviews_locations'])? $testimonials_review_settings_options['reviews_locations']:array();
                                
                                $i=0;
                                
                                foreach($rv_loc as $rvl){
                                    
                                    if($rvl){
                                                                                
                                        $blocks_fields = apply_filters('saswp_modify_blocks_field', '<input class="blocks-field" name="testimonials_review_settings_options[reviews_locations][]" type="number" min="5" step="5" placeholder="5" value="5" disabled="disabled">', isset($rv_blocks[$i])? $rv_blocks[$i]: 5);
                                        
                                        $location .= '<tr>'
                                        . '<td style="width:80%;"><input required="" class="inp-grfe-np location-field" name="testimonials_review_settings_options[locations_names][]" type="text" value="'. esc_attr($rvl).'"><label class="lbl-grfe-np" alt="' . esc_html__( 'Place ID', 'testimonials-plugin' ) . '" placeholder="' . esc_html__( 'Place ID', 'testimonials-plugin' ) . '"></label></td>'
                                        . '<td style="width:0%; display:none;"><strong>'.esc_html__( 'Reviews', 'testimonials-plugin' ).'</strong></td>'
                                        . '<td style="width:0%;display:none;">'.$blocks_fields.'</td>'                                        
                                        . '<td style="width:10%;vertical-align: baseline;"><a style="margin-top: 5%;" class="square_btn button-default fetch-reviews">'.esc_html__( 'Import', 'testimonials-plugin' ).'</a></td>'
                                        . '<td style="width:10%;vertical-align: baseline;"><a type="button" class="square_btn btn-remove-review-item">'.esc_html__( 'Remove', 'testimonials-plugin' ).'</a></td>'
                                        . '<td style="width:10%;"><p class="saswp-rv-fetched-msg"></p></td>'        
                                        . '</tr>'; 
                                    }
                                   $i++;
                                }
                                
                            }
            $reviews = '<div class="saswp-g-reviews-settings saswp-knowledge-label">'                                                                
                                . '<table class="saswp-g-reviews-settings-table" style="width:100%">'
                                . $location                                 
                                . '</table>'   
                                . '</div>'
                . '<div><a class="square_btn" target="_blank" href="https://console.developers.google.com/apis/library">Get place API Key</a><a class="square_btn" target="_blank" href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder">'. __( 'Google ID Finder', 'testimonials-plugin' ).'</a></div>';
            echo $reviews;
        }

        
        public function duration_render_popup() {
            $options = get_option( 'testimonials_settings_settings' ); ?>
            <input type="number" min="1" name="testimonials_settings_settings[duration]" value="<?php echo esc_attr( $options['duration'] ); ?>" class="cpo-input-text">
            <p class="description"><?php _e( 'If you chose Timer as the close method, enter how many seconds the notification should display for', 'testimonials-plugin' ); ?></p>
        <?php
        }

        public function heading_text_render_popup() {
            $cpo_content_settings = get_option( 'cpo_content_settings' ); ?>
            <input type="text" name="cpo_content_settings[heading_text]" value="<?php echo esc_attr( $cpo_content_settings['heading_text'] ); ?>" class="cpo-input-text">
            <p class="description"><?php _e( 'Set the header text on popup', 'testimonials-plugin' ); ?></p>
        <?php
        }
        
        function get_rating_html_by_value($rating_val){
            
        $starating = '';
        
        $starating .= '<div class="saswp-rvw-str">';
        for($j=0; $j<5; $j++){  

              if($rating_val >$j){

                    $explod = explode('.', $rating_val);

                    if(isset($explod[1])){

                        if($j <$explod[0]){

                            $starating.='<span class="str-ic"></span>';   

                        }else{

                            $starating.='<span class="half-str"></span>';   

                        }                                           
                    }else{

                        $starating.='<span class="str-ic"></span>';    

                    }

              } else{
                    $starating.='<span class="df-clr"></span>';   
              }                                                                                                                                
            }
        $starating .= '</div>';
        
        return $starating;
        
}

        public function support_settings_section_callback() {
            
            echo '<div style="height:50px;"></div><div class="elementor-column-wrap  elementor-element-populated"><div class="elementor-widget-wrap"><div class="elementor-element elementor-element-a547f22 elementor-widget elementor-widget-heading" data-id="a547f22" data-element_type="widget" data-widget_type="heading.default"><div class="elementor-widget-container"><h2 class="elementor-heading-title elementor-size-default">Was können wir für Sie tun?</h2></div></div><div class="elementor-element elementor-element-76dffe2 elementor-button-align-center elementor-widget elementor-widget-form" data-id="76dffe2" data-element_type="widget" data-widget_type="form.default"><div class="elementor-widget-container"><form class="elementor-form" method="post" name="New Form"> <input type="hidden" name="post_id" value="274"> <input type="hidden" name="form_id" value="76dffe2"><div class="elementor-form-fields-wrapper elementor-labels-"><div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-50 elementor-field-required"> <label for="form-field-name" class="elementor-field-label elementor-screen-only">Ihr Name</label><input size="1" type="text" name="form_support[name]" id="form-field-name" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Ihr Name" required="required" aria-required="true"></div><div class="elementor-field-type-number elementor-field-group elementor-column elementor-field-group-field_2 elementor-col-50 elementor-field-required"> <label for="form-field-field_2" class="elementor-field-label elementor-screen-only">Telefonnummer</label><input type="number" name="form_support[field_2]" id="form-field-field_2" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Telefonnummer" required="required" aria-required="true" min="" max=""></div><div class="elementor-field-type-email elementor-field-group elementor-column elementor-field-group-field_1 elementor-col-50 elementor-field-required"> <label for="form-field-field_1" class="elementor-field-label elementor-screen-only">Ihre E-Mail Adresse</label><input size="1" type="email" name="form_support[field_1]" id="form-field-field_1" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Ihre E-Mail Adresse" required="required" aria-required="true"></div><div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-email elementor-col-50 elementor-field-required"> <label for="form-field-email" class="elementor-field-label elementor-screen-only">Ihre Website</label><input size="1" type="text" name="form_support[email]" id="form-field-email" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Ihre Website" required="required" aria-required="true"></div><div class="elementor-field-type-textarea elementor-field-group elementor-column elementor-field-group-message elementor-col-100 elementor-field-required"> <label for="form-field-message" class="elementor-field-label elementor-screen-only">Wie können wir helfen?</label><textarea class="elementor-field-textual elementor-field  elementor-size-sm" name="form_support[message]" id="form-field-message" rows="8" placeholder="Wie können wir helfen?" required="required" aria-required="true"></textarea></div><div class="elementor-field-type-acceptance elementor-field-group elementor-column elementor-field-group-field_3 elementor-col-100 elementor-field-required"> <label for="form-field-field_3" class="elementor-field-label elementor-screen-only">Datenschutzerklärung</label><div class="elementor-field-subgroup"><span class="elementor-field-option"><input type="checkbox" name="form_support[field_3]" id="form-field-field_3" class="elementor-field elementor-size-sm  elementor-acceptance-field" required="required" aria-required="true"> <label for="form-field-field_3">Ich bin mit der <a href="/datenschutzerklaerung/" target="blank" rel="nofollow">Datenschutzerklärung DSGVO einverstanden</a></label></span></div></div><div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100"> <button id="form_support" type="submit" class="elementor-button elementor-size-sm"> <span> <span class=" elementor-button-icon"> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> </span> <span class="elementor-button-text">unverbindlich Anfrage senden</span> </span> </button></div></div></form></div></div></div></div>';
        }
        
		
        public function testimonials_reviews_list_callback() { ?>
            <table id="example" class="display wp-list-table widefat fixed striped posts">
    <thead>
    <tr>
        <th style="width:10%;" scope="col" id="saswp_reviewer_image" class="manage-column column-saswp_reviewer_image"><a><?php echo esc_html__( 'Image','testimonials-plugin' ); ?></a><a></a></th><th style="width:15%;" scope="col" id="title" class="manage-column column-title column-primary sortable desc"><span><?php echo esc_html__( 'Name','testimonials-plugin' ); ?></span><span class="sorting-indicator"></span></th><th style="width:12%;" scope="col" id="saswp_review_rating" class="manage-column column-saswp_review_rating"><a><?php echo esc_html__( 'Rating','testimonials-plugin' ); ?></a><a></a></th><th scope="col" id="saswp_review_text" class="manage-column column-saswp_review_rating" style="width:25%;"><a><?php echo esc_html__( 'Review','testimonials-plugin' ); ?></a><a></a></th><th style="width:8%;" scope="col" id="saswp_review_platform" class="manage-column column-saswp_review_platform"><a><?php echo esc_html__( 'Platform','testimonials-plugin' ); ?></a><a></a></th><th style="width:10%;"scope="col" id="saswp_review_date" class="manage-column column-saswp_review_date"><a><?php echo esc_html__( 'Review Date','testimonials-plugin' ); ?></a><a></a></th><th style="width:10%;" scope="col" id="saswp_review_place_id" class="manage-column column-saswp_review_place_id"><a><?php echo esc_html__( 'Place ID','testimonials-plugin' ); ?></a><a></a></th></tr>
    </thead>
    <tbody id="the-list">
    <?php
        $args = array(
            'post_type'      => 'testimonial',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'posts_per_page'   => -1
        );

        $wp_query = new \WP_Query($args);

        if($wp_query->have_posts()) {
            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );        

                if ( ! $testimonial_thumb ) {
                    $testimonial_thumb = get_post_meta( get_the_ID(), 'testimonial_image', true );
                } else {
                    $testimonial_thumb = $testimonial_thumb[0];
                }

    ?>
        <tr id="<?php echo get_the_ID(); ?>" class="iedit author-self level-0 <?php echo get_the_ID(); ?> type-saswp_reviews status-publish hentry">
            <td class="saswp_reviewer_image column-saswp_reviewer_image" data-colname="Image"><div class="saswp-rv-img"><span><img src="<?php echo get_post_meta( get_the_ID(), 'testimonial_image', true ); ?>"  alt="<?php echo esc_html__( 'Reviewer','testimonials-plugin' ); ?>" width="65" height="65"></span></td><td class="title column-title has-row-actions column-primary page-title" data-colname="Title"><div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
<strong><?php echo esc_attr(get_the_title( get_the_ID() )); ?></strong></td><td class="saswp_review_rating column-saswp_review_rating" data-colname="Rating"><?php echo $this->get_rating_html_by_value(get_post_meta( get_the_ID(), 'testimonial_rating', true )); ?></td><td class="saswp_review_place_id column-saswp_review_place_id" data-colname="Review"><?php echo get_post_meta( get_the_ID(), 'testimonial_text', true ); ?></td><td class="saswp_review_platform column-saswp_review_platform" data-colname="Platform"><span class="saswp-g-plus"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>images/google-img.png" alt="Icon"></span></td><td class="saswp_review_date column-saswp_review_date" data-colname="Review Date"><?php echo /*date('d/m/Y',get_post_meta( get_the_ID(), 'testimonial_time', true ));*/ get_post_meta( get_the_ID(), 'testimonial_time', true )->format('d/m/Y'); ?></td><td class="saswp_review_place_id column-saswp_review_place_id" data-colname="Place ID"><?php echo get_post_meta( get_the_ID(), 'testimonial_location_id', true ); ?></td></tr>
    <?php endwhile;

    } ?>

            </tbody>

</table>

<?php
	
        }

        public function review_setting_section_callback() {
            echo '';
        }

        public function options_page() {
            $reset = isset ( $_GET['reset'] ) ? $_GET['reset'] : '';
            if ( isset ( $_POST['reset'] ) ) {


            }
            $current = (null !== sanitize_text_field($_GET['tab']) && "" != sanitize_text_field($_GET['tab']) ) ? sanitize_text_field($_GET['tab']) : 'review_settings';
            $title =  __( 'Reviews for Elementor by Nahiro.net', 'testimonials-plugin' );
            $tabs = array (
                'review_settings'       =>  __( 'Reviews Settings', 'testimonials-plugin' ),
                'reviews_list'      =>  __( 'Reviews List', 'testimonials-plugin' ),
                'support'       =>  __( 'Wordpress Support', 'testimonials-plugin' )
            );?>

            <div class="wrap">
                <h1><?php echo $title; ?></h1>
                <div class="cpo-outer-wrap">
                    <div class="cpo-inner-wrap">
                        <h2 class="nav-tab-wrapper">
                            <?php foreach( $tabs as $tab => $name ) {
                                $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                                echo "<a class='nav-tab$class' href='?page=testimonials&tab=$tab'>$name</a>";
                            } ?>
                        </h2>
                        <form action='options.php' method='post'>
                            <?php
                            settings_fields( 'testimonials_' . strtolower ( $current ) );
                            do_settings_sections( 'testimonials_' . strtolower ( $current ) );
                            if (strtolower ( $current ) == "review_settings")
                            {
                                submit_button();
                            }
                            ?>
                        </form>
                        <?php if (strtolower ( $current ) == "review_settings")
                            { ?>
                        <form method="post" action="">
                            <p class="submit">
                                <input name="reset" class="button button-secondary" type="submit" value="<?php _e( 'Reset plugin defaults', 'testimonials-plugin' ); ?>" >
                                <input type="hidden" name="action" value="reset" />
                            </p>
                        </form>
                        <?php  } ?>
                    </div><!-- .cpo-inner-wrap -->

                </div><!-- .cpo-outer-wrap -->
            </div><!-- .wrap -->
            <?php
        }
    }
}