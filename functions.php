<?php
define("CREDIT_HEAD"    	, "\n<!---- Latest News Ticker included this line ------->\n<!---- Shane Jones - www.shanejones.co.uk -->\n");
define("CREDIT_FOOT"    	, "\n<!---- END Latest News Ticker -------------->\n\n");

//options

function sdj_lnt_defaults()
{
	update_option('sdj_lnt_options', array(
											'lnt_location'          => 'bottom',
											'lnt_speed'         	=> '3',
											'lnt_breaking'    		=> '1',
											'lnt_author'    		=> '1',
											'lnt_date'    			=> '1')
										  );	
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

	}
}


function sdj_lnt_build_ticker(){
	
    $options = get_option('sdj_lnt_options');
	
	switch($options['lnt_speed']){
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
	<div id="sdj_ticker_script_<?php echo $options['lnt_location'];?>"> 
    
		<ul id="webticker">   
            <?php 
                if(isset($options['lnt_breaking'])){ 
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
              'caller_get_posts'=> 1
              );
            $my_query = null;
            $my_query = new WP_Query($args);
            if( $my_query->have_posts() ) {
              echo '';
              while ($my_query->have_posts()) : $my_query->the_post(); ?>
              <li><a href="<?php the_permalink() ?>" 
                     title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> 
                     <?php if($options['lnt_authors']){ ?> by <?php the_author();  }?> <?php if($options['lnt_date']){ ?> -  <?php the_time("D M jS G:i:s")?> <?php }?>
              </li>
              <?php
              endwhile;
            }
            wp_reset_query();
        
            ?>
            
            <?php if($credit){ ?>
                <li>Created by <a href="http://www.latestnewsticker.com/?utm_source=wordpress-plugins&utm_medium=users-site&utm_campaign=in-ticker">Latest News Ticker</a> a Plugin by <a href="http://www.shanejones.co.uk/?utm_source=wordpress-plugins&utm_medium=users-site&utm_campaign=lnt-in-ticker">Shane Jones</a></li>
            <?php } ?>
            </ul>
    
    </div>
    <?php echo CREDIT_FOOTER;
	 
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
    
    <h1>Latest News Ticker "Lite" by Shane Jones</h1>
    <div style="float:left; width:420px;">
        <form action="options.php" method="post">
        <?php settings_fields('sdj_lnt_options') ?>
        
        <?php do_settings_sections('sdj_lnt_plugin') ?>
    
        <input style="margin: 10px 0 0 170px;" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    
        </form>
    </div>
    
    <div style="float:left; width:260px;">
    	<h2>Want More Features?</h2>
        <p>Check out <a href="http://www.latestnewsticker.com/?utm_source=wordpress-plugins&utm_medium=users-site&utm_campaign=admin">Latest News Ticker Pro</a> for WordPress for a ton of other features and an exclusive bargain launch price. <a href="http://www.latestnewsticker.com/?utm_source=wordpress-plugins&utm_medium=users-site&utm_campaign=admin">Go there&gt;&gt;</a></p>
    
      <h2>Credits</h2>
        
        <div id="fb-root"></div>
		<script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        
        <div class="fb-like" data-href="http://www.latestnewsticker.com/" data-send="false" data-layout="button_count" data-width="250" data-show-faces="false"></div>
        <br><br>
        <a href="https://twitter.com/shanejones" class="twitter-follow-button" data-show-count="false">Follow @shanejones</a>
        <a href="https://twitter.com/share" data-href="http://www.latestnewsticker.com/" class="twitter-share-button" data-text="Latest News Ticker Lite for WordPress" data-via="shanejones" data-related="mycleveragency" data-hashtags="wordpress">Tweet</a>


<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<br><br>
        <!-- Place this tag where you want the su badge to render -->
        <su:badge layout="3" location="http://www.latestnewsticker.com/"></su:badge>
        
        <!-- Place this snippet wherever appropriate --> 
         <script type="text/javascript"> 
         (function() { 
             var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true; 
             li.src = window.location.protocol + '//platform.stumbleupon.com/1/widgets.js'; 
             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s); 
         })(); 
         </script>

        
        <p>If you'd like to say thanks for this amazing free plugin, you can always drop me a donation?</p>   
            <div style="margin:auto; width:160px">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="TS33GLQZYJ3RA">
                    <input style="text-align:center;" type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
    </div>

<?
}


function sdj_lnt_admin_init(){
    register_setting('sdj_lnt_options', 'sdj_lnt_options');	
    add_settings_section('plugin_main', 'Latest News Ticker', 'lnt_text', 'sdj_lnt_plugin');
	add_settings_field('lnt_location', 'Ticker Location', 'lnt_location', 'sdj_lnt_plugin', 'plugin_main');	
	add_settings_field('lnt_breaking_optin', 'Show Title', 'lnt_breaking_optin', 'sdj_lnt_plugin', 'plugin_main');	
	add_settings_field('lnt_speed_drop', 'Ticker Speed', 'lnt_speed_drop', 'sdj_lnt_plugin', 'plugin_main');	
	add_settings_field('lnt_authors_optin', 'Show Post Authors', 'lnt_authors_optin', 'sdj_lnt_plugin', 'plugin_main');	
	add_settings_field('lnt_date_optin', 'Show Post Date/Time', 'lnt_date_optin', 'sdj_lnt_plugin', 'plugin_main');
}

function lnt_text() {
    echo '<p>You can customise the features of this plugin with these few fields.</p>';
}

function lnt_location() {
    $options = get_option('sdj_lnt_options');
    ?>
    <select id="lnt_location" name="sdj_lnt_options[lnt_location]">
    	<option value="top" <?php echo ($options['lnt_location']=="top"? 'selected':'')?>>Top</option>
    	<option value="bottom" <?php echo ($options['lnt_location']=="bottom"? 'selected':'')?>>Bottom</option>
    </select>
    <?
}


function lnt_breaking_optin() {
    $options = get_option('sdj_lnt_options');
    echo '<input id="lnt_breaking_optin" name="sdj_lnt_options[lnt_breaking]" size="40" type="checkbox" value="1" '.($options['lnt_breaking']==1? 'checked':'').' />';
}


function lnt_speed_drop() {
    $options = get_option('sdj_lnt_options');
    ?>
    <select id="lnt_speed_drop" name="sdj_lnt_options[lnt_speed]">
    	<option value="1" <?php echo ($options['lnt_speed']==1? 'selected':'')?>>Slowest</option>
    	<option value="2" <?php echo ($options['lnt_speed']==2? 'selected':'')?>>Slower</option>
    	<option value="3" <?php echo ($options['lnt_speed']==3? 'selected':'')?>>Slow</option>
        <option value="4" <?php echo ($options['lnt_speed']==4? 'selected':'')?>>Normal</option>
        <option value="5" <?php echo ($options['lnt_speed']==5? 'selected':'')?>>Fast</option>
    </select>
    <?
}

function lnt_authors_optin() {
    $options = get_option('sdj_lnt_options');
    echo '<input id="lnt_authors_optin" name="sdj_lnt_options[lnt_authors]" size="40" type="checkbox" value="1" '.($options['lnt_authors']==1? 'checked':'').' />';
}


function lnt_date_optin() {
    $options = get_option('sdj_lnt_options');
    echo '<input id="lnt_dates_optin" name="sdj_lnt_options[lnt_date]" size="40" type="checkbox" value="1" '.($options['lnt_date']==1? 'checked':'').' />';
}


?>