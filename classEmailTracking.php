<?php

class EmailTracking {
    
    public static function init(){
        self::hooks_init();
    }
    
    public static function hooks_init(){
        add_action( 'init', array('EmailTracking', 'rewrites_init') );
        add_filter('template_include', array('EmailTracking', 'template_init'));        
    }
    
    public static function rewrites_init(){
        global $wp_rewrite;
        add_rewrite_tag( '%et-images%', '([^&]+)'); 
        add_rewrite_rule('^et-images/?', 'index.php?et-images=et-images', 'top' );
        add_rewrite_endpoint( 'et-images', EP_PERMALINK | EP_PAGES );
    }
    
    public static function template_init($template)
    {
        global $wp_query;

        if ($wp_query->is_404) {
            $wp_query->is_404 = false;
            header("HTTP/1.1 200 OK");
        }
        
        if (isset($wp_query->query_vars['name']) && $wp_query->query_vars['name'] === 'et-images') {            
            include EMAILTRACKING__PLUGIN_DIR . 'templates/image_creater.php';
            exit;
        }
        return $template;
    }
   
    public static function plugin_activation() {
        
	}
    
	public static function plugin_deactivation( ) {
		
	}
    
    public static function create_image(){
        header("Content-Type: image/jpg");
        
        $im = imagecreate(1,1) or die("Cannot Initialize new GD image stream");
        $background_color = imagecolorallocate($im, 255, 255, 255);
        imagejpeg($im);
        imagedestroy($im);
    }
    
    public static function get_email_tracking_image(){
                
        if(self::check_sdk()){
            self::sdk_init();
            self::create_image();
        } else
            echo 'Please check Email Tracking Infusionsoft SDK settings.';
        
        die();
    }
    
    public static function check_sdk(){        
        if(get_option('emailtracking_isdk_app_name') == '' || get_option('emailtracking_isdk_api_key') == '')
            return false;        
        else
            return true;        
    }
        
    public static function sdk_init(){        
        $appname = get_option('emailtracking_isdk_app_name');
        $apikey = get_option('emailtracking_isdk_api_key');
        
        if(isset($_REQUEST['cid']) && isset($_REQUEST['asid'])) {
            $cid = (int)$_REQUEST['cid'];
            $asid = (int)$_REQUEST['asid'];
        } else 
            return;
        
        $app = new iSDK(); 
        $app->cfgCon($appname, $apikey);
        
        
        $as = $app->runAS($cid, $asid);        
    }
}
