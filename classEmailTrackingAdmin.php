<?php

class EmailTrackingAdmin {
    
	public static function init() {
		add_action( 'admin_menu', array('EmailTrackingAdmin', 'admin_menu') );
	}
    
	public static function admin_menu () {
		add_options_page( 'Email Open Tracking Settings', 'Email Open Tracking', 'manage_options', 'email_tracking_settings', array('EmailTrackingAdmin', 'settings_page') );
	}    
    
	public static function  settings_page () {
        self::save_options();
		?>
        <div class="pageparentdiv">
            <h2 class="hndle">
                <span>Email Open Tracking Settings</span>
            </h2>                 
            <div class="inside">
                <form action="" method="post">                    
                    <table class="form-table">                        
                        <tr>
                            <th scope="row">
                                <strong>iSDK App Name:</strong>
                            </th>
                            <td>
                                https://<input type="text" class="text" name="et_appname" value="<?php echo get_option('emailtracking_isdk_app_name'); ?>">.infusionsoft.com
                                <br>
                                <span class="description">Your app name is the URL you use to access Infusionsoft.</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <strong>iSDK API Key:</strong>
                            </th>
                            <td>
                                <input type="text" class="text" size="45" name="et_apikey" value="<?php echo get_option('emailtracking_isdk_api_key'); ?>">
                            </td>
                        </tr>
                    </table>                                  
                    <p>
                        <input class="button button-primary button-large" type="submit" value="Save">
                    </p>

                </form>
                <h2>Simple Setup</h2>
                <p>Take the image code below and paste it into an html block in your email, or into a webpage to create a tracking pixel.</p>
                <p>You need to set up an Action Set to trigger what you'd like to happen, and put the Acition Set ID in place of YOURASID</p>
                <p><strong>Image code:</strong>&lt;img src=&quot;<?php echo get_home_url() .'/et-images?cid=~Contact.Id~&asid=YOURASID'; ?>&quot; /&gt;</p>
            </div>
        </div>
        <?php
	}
    
    public static function save_options(){
        if(!isset($_POST['et_appname']) || !isset($_POST['et_apikey']))
            return;
        
        $appname = trim($_POST['et_appname']);
        $apikey = trim($_POST['et_apikey']);
        
        update_option('emailtracking_isdk_app_name', $appname);
        update_option('emailtracking_isdk_api_key', $apikey);
    }
    
}