<?php
define("CREDIT_HEAD"    	, "\n<!---- Latest News Ticker included this line ------->\n<!---- Shane Jones - www.shanejones.co.uk -->\n");
define("CREDIT_FOOT"    	, "\n<!---- END Latest News Ticker -------------->\n\n");

//options

function sdj_lnt_defaults(){
	update_option('sdj_lnt_options', array(
											'lnt_location'          => 'bottom',
											'lnt_speed'         	=> '3',
											'lnt_breaking'    		=> '1',
											'lnt_authors'    		=> '1',
											'lnt_date'    			=> '1')
										  );	
}

function sdj_lnt_defaults_remove(){
	delete_option('sdj_lnt_options');
}


function sdj_lnt_scripts() {


	if (!is_admin()) {

		wp_deregister_script('jquery');
		wp_register_script	('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1');
		wp_enqueue_script	('jquery');
		
		wp_register_script	('webticker', plugins_url('jquery.webticker.js', __FILE__),false,'1.3');
		wp_enqueue_script	('webticker');

		wp_register_style	('basecss', plugins_url('themes/sdj_lnt_main.css', __FILE__), false);
        wp_enqueue_style	('basecss');
		
		wp_register_style	('theme', plugins_url('themes/default.css', __FILE__), 'basecss');
        wp_enqueue_style	('theme');

		wp_enqueue_style	('wp-pointer');
		wp_enqueue_script	('wp-pointer');
	}

}


function sdj_lnt_build_ticker(){
	
    $lnt_options = get_option('sdj_lnt_options');
	
	switch($lnt_options['lnt_speed']){
		case 1:
			$speed=0.015;
			break;
		case 2:
			$speed=0.025;
			break;
		case 3:
			$speed=0.05;
			break;
		case 4:
			$speed=0.1;
			break;
		case 5:
			$speed=0.15;
			break;	
	}
	
	?>
   
	<?php echo CREDIT_HEAD ?>   
    <script type="text/javascript">
		jQuery(function ($) {
            $("#webticker").webTicker({travelocity: <?php echo $speed?>});
        });
    </script>
	<div id="sdj_ticker_script_<?php echo $lnt_options['lnt_location'];?>"> 

        <!----

        <? var_dump($lnt_options) ?>

        -->

		<ul id="webticker">   
            <?php 
                if(isset($lnt_options['lnt_breaking'])){ 
            ?>
                        <li class="first_title">Latest Posts</li>	
            <?php
             	} 
             ?>
            
            
            <?php	
            $args=array(
              'post_type' => 'post',
              'post_status' => 'publish',
              'posts_per_page' => 5,
              'ignore_sticky_posts'=> 1
              );
            $my_query = null;
            $my_query = new WP_Query($args);
            if( $my_query->have_posts() ) {
              echo '';
              while ($my_query->have_posts()) : $my_query->the_post(); ?>
              <li><a href="<?php the_permalink() ?>" 
                     title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> 
                     <?php if($lnt_options['lnt_authors']){ ?> by <?php the_author();  }?> <?php if($lnt_options['lnt_date']){ ?> -  <?php the_time("D M jS G:i:s")?> <?php }?>
              </li>
              <?php
              endwhile;
            }
            wp_reset_query();
        
            ?>
            

            </ul>
    
    </div>
    <?php echo CREDIT_FOOT;
	 
}





/*
 * Admin Settings Related Bits
 *
 */
function sdj_lnt_admin_add_page() {
    add_options_page('Custom Plugin Page', 'Latest News Ticker', 'manage_options', 'sdj_lnt_plugin', 'sdj_lnt_options_page');
}







function sdj_lnt_options_page() {
?>
	<link href="../wp-content/plugins/latest_news_ticker/admin.css" rel="stylesheet" type="text/css">
    <div class="sdj_lnt_admin_wrap">
        <div class="sdj_lnt_admin_top">
            <h1>Latest News Ticker <small> - A plugin by Shane Jones <a href="https://twitter.com/shanejones" class="twitter-follow-button" data-show-count="false">Follow @shanejones</a></small></h1>
        </div>

        <div class="sdj_lnt_admin_main_wrap">
            <div class="sdj_lnt_admin_main_left">
                <div class="sdj_lnt_admin_signup">
                    Want to know about updates to this plugin without having to log into your site every time? Want to know about other cool plugins we've made? Add your email and we'll add you to our very rare mail outs.

                    <!-- Begin MailChimp Signup Form -->
                    <div id="mc_embed_signup">
                    <form action="http://latestnewsticker.us2.list-manage.com/subscribe/post?u=20ee43e7ba838878374172f82&amp;id=ed4b38bd9a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div class="mc-field-group">
                        <label for="mce-EMAIL">Email Address
                    </label>
                        <input type="email" value="<?php echo get_bloginfo('admin_email');?>" name="EMAIL" class="required email" id="mce-EMAIL"><button type="submit" name="subscribe" id="mc-embedded-subscribe" class="sdj_lnt_admin_green">Sign Up!</button>
                    </div>
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none">
                            </div>
                            <div class="response" id="mce-success-response" style="display:none">
                            </div>
                        </div>	
                        <div class="clear"></div>
                    </form>
               </div>

                    <!--End mc_embed_signup-->
                </div>
                <div class="sdj_lnt_admin_options">
                    <form action="options.php" method="post">
                    
                    <?php settings_fields('sdj_lnt_options') ?>
                    
                    <?php do_settings_sections('sdj_lnt_plugin') ?>
                	<hr>
                    <button class="sdj_lnt_admin_green" style="margin: 10px 0 0 228px;" name="Submit" type="submit"><?php esc_attr_e('Save Changes'); ?></button>
                
                    </form>
                </div>

			</div>

			<div class="sdj_lnt_admin_main_right">

                <div class="sdj_lnt_admin_box">
                    <h2>About the Author</h2>
                    <p>Shane Jones is a Facebook App developer and Wordpress developer who specialises in PHP based web apps.</p>
                    <h2>Want More Features?</h2>
        <p>Check out <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/">Latest News Ticker Pro</a> for WordPress for a ton of other features.<a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/">Go there&gt;&gt;</a></p>

                    <?php
                    $size = 50;
                    $shane_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( "me@shanejones.co.uk" ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
                    ?>

                    <p class="sdj_lnt_admin_clear"><img class="sdj_lnt_admin_fl" src="<?php echo $shane_url; ?>" alt=Shane Jones"" /> <strong>Shane Jones</strong><br><a href="https://twitter.com/shanejones" class="twitter-follow-button" data-show-count="false">Follow @shanejones</a></p>

                </div>

                <div class="sdj_lnt_admin_box">
                    <h2>Like this Plugin?</h2>
                            <div id="fb-root"></div>
							<script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            
                            <div class="fb-like" data-href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" data-send="false" data-layout="button_count" data-width="250" data-show-faces="false"></div>
                            <br><br>
                            <a href="https://twitter.com/share" data-url="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" class="twitter-share-button" data-text="Latest News Ticker Lite for WordPress" data-via="shanejones" data-hashtags="wordpress">Tweet</a>
                    
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            <br><br>
                            <!-- Place this tag where you want the su badge to render -->
                            <su:badge layout="3" location="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/"></su:badge>
                            
                            <!-- Place this snippet wherever appropriate --> 
                             <script type="text/javascript"> 
                             (function() { 
                                 var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true; 
                                 li.src = window.location.protocol + '//platform.stumbleupon.com/1/widgets.js'; 
                                 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s); 
                             })(); 
                             </script>
                             <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="hidden" name="cmd" value="_s-xclick">
                                <input type="hidden" name="hosted_button_id" value="TS33GLQZYJ3RA">
                                <input style="text-align:center;" type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
                                <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                            </form>

                </div>

            </div>
        </div>
    </div>






<?
}


function sdj_lnt_admin_init(){
    register_setting('sdj_lnt_options', 'sdj_lnt_options');	
    add_settings_section('plugin_main', 'Settings', 'lnt_text', 'sdj_lnt_plugin');
    
    add_settings_field('lnt_upgrade1', 'Choose Category', 'lnt_upgrade1', 'sdj_lnt_plugin', 'plugin_main');
    add_settings_field('lnt_upgrade2', 'Posts to Display', 'lnt_upgrade2', 'sdj_lnt_plugin', 'plugin_main');
    add_settings_field('lnt_upgrade3', 'Link to Posts', 'lnt_upgrade3', 'sdj_lnt_plugin', 'plugin_main');
    
	add_settings_field('lnt_location', 'Ticker Location', 'lnt_location', 'sdj_lnt_plugin', 'plugin_main');
    add_settings_field('lnt_speed_drop', 'Ticker Speed', 'lnt_speed_drop', 'sdj_lnt_plugin', 'plugin_main');

	add_settings_field('lnt_breaking_optin', 'Show Title', 'lnt_breaking_optin', 'sdj_lnt_plugin', 'plugin_main');
    add_settings_field('lnt_upgrade4', 'Custom Title Text', 'lnt_upgrade4', 'sdj_lnt_plugin', 'plugin_main');

	add_settings_field('lnt_authors_optin', 'Show Post Authors', 'lnt_authors_optin', 'sdj_lnt_plugin', 'plugin_main');	
	add_settings_field('lnt_date_optin', 'Show Post Date/Time', 'lnt_date_optin', 'sdj_lnt_plugin', 'plugin_main');
    add_settings_field('lnt_upgrade5', 'Date / Time Format', 'lnt_upgrade5', 'sdj_lnt_plugin', 'plugin_main');

    add_settings_field('lnt_upgrade6', 'All Caps', 'lnt_upgrade6', 'sdj_lnt_plugin', 'plugin_main');
    add_settings_field('lnt_upgrade7', 'Colour Scheme', 'lnt_upgrade7', 'sdj_lnt_plugin', 'plugin_main');
}

function lnt_text() {
    echo '<p>You can customise the features of this plugin with these few fields. To gain access to app the other features of this application, please consider upgrading for the small price of $19.99 for a single site (discounts available).</p>';
}


function lnt_upgrade1() {
    ?>
    <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" target="_blank">Upgrade to Activate.</a>
    <?
}
function lnt_upgrade2() {
    ?>
    <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" target="_blank">Upgrade to Activate.</a>
    <?
}
function lnt_upgrade3() {
    ?>
    <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" target="_blank">Upgrade to Activate.</a>
    <?
}
function lnt_upgrade4() {
    ?>
    <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" target="_blank">Upgrade to Activate.</a>
    <?
}
function lnt_upgrade5() {
    ?>
    <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" target="_blank">Upgrade to Activate.</a>
    <?
}
function lnt_upgrade6() {
    ?>
    <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" target="_blank">Upgrade to Activate.</a>
    <?
}
function lnt_upgrade7() {
    ?>
    <a href="http://peadig.com/wordpress-plugins/latest-news-ticker-pro/" target="_blank">Upgrade to Activate.</a>
    <?
}
    

function lnt_location() {
    $lnt_options = get_option('sdj_lnt_options');
    ?>
    <select id="lnt_location" name="sdj_lnt_options[lnt_location]">
    	<option value="top" <?php echo ($lnt_options['lnt_location']=="top"? 'selected':'')?>>Top</option>
    	<option value="bottom" <?php echo ($lnt_options['lnt_location']=="bottom"? 'selected':'')?>>Bottom</option>
    </select>
    <?
}


function lnt_breaking_optin() {
    $lnt_options = get_option('sdj_lnt_options');
    echo '<input id="lnt_breaking_optin" name="sdj_lnt_options[lnt_breaking]" size="40" type="checkbox" value="1" '.($lnt_options['lnt_breaking']==1? 'checked':'').' />';
}


function lnt_speed_drop() {
    $lnt_options = get_option('sdj_lnt_options');
    ?>
    <select id="lnt_speed_drop" name="sdj_lnt_options[lnt_speed]">
    	<option value="1" <?php echo ($lnt_options['lnt_speed']==1? 'selected':'')?>>Slowest</option>
    	<option value="2" <?php echo ($lnt_options['lnt_speed']==2? 'selected':'')?>>Slower</option>
    	<option value="3" <?php echo ($lnt_options['lnt_speed']==3? 'selected':'')?>>Slow</option>
        <option value="4" <?php echo ($lnt_options['lnt_speed']==4? 'selected':'')?>>Normal</option>
        <option value="5" <?php echo ($lnt_options['lnt_speed']==5? 'selected':'')?>>Fast</option>
    </select>
    <?
}

function lnt_authors_optin() {
    $lnt_options = get_option('sdj_lnt_options');
    echo '<input id="lnt_authors_optin" name="sdj_lnt_options[lnt_authors]" size="40" type="checkbox" value="1" '.($lnt_options['lnt_authors']==1? 'checked':'').' />';
}


function lnt_date_optin() {
    $lnt_options = get_option('sdj_lnt_options');
    echo '<input id="lnt_dates_optin" name="sdj_lnt_options[lnt_date]" size="40" type="checkbox" value="1" '.($lnt_options['lnt_date']==1? 'checked':'').' />';
}


?>