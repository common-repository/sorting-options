<?php
/**

* @package sorting
* @version 1

**/

/**

  Plugin Name: Sorting Options
  Plugin URI: http://sortingoptions.com/
  Description: Sorting posts couldn’t be easier, or look any better! Populate a button on the front-end then sort your posts. A PRO version is coming soon.
  Author: Cameron Haddock
  Version: 1
  Author URI: http://cameronhaddock.com/
  
**/

	add_action( 'wp_enqueue_scripts', 'user_sort_option_styles' );

    function user_sort_option_styles() {
		

        // Respects SSL, Style.css is relative to the current file
		

        wp_register_style( 'sort-style', plugins_url('style.css', __FILE__) );
		

        wp_enqueue_style( 'sort-style' );	

	}	

	add_filter('query_vars', 'user_sort_options_dropdown');

	function user_sort_options_dropdown($vars) {

                $vars[] = 'title_az';

                $vars[] = 'title_za';

		$vars[] = 'most_commented';
		
		$vars[] = 'most_recent';

                $vars[] = 'oldest';				

		return $vars;

	}

	add_filter('posts_orderby', 'user_sort_options_orderby' );

	function user_sort_options_orderby( $orderby )

	{

global $wpdb;

$getValue=$wpdb->get_row("select default_status from default_sorting_option",ARRAY_N);

if($getValue[0]=='az'){
	$order="post_title ASC";
	}
	if($getValue[0]=='za'){
	$order="post_title DESC";
	
	}
	if($getValue[0]=='most_recent'){
		$order="post_date DESC";
	}
	if($getValue[0]=='most_commented'){
	$order="comment_count DESC";
	}
	if($getValue[0]=='oldest'){
		$order="post_date ASC";
	}

        if(get_query_var('title_az')) {


			// alphabetical order by post title

			   $order="post_title ASC";

		}
        if(get_query_var('title_za')) {

			// alphabetical order by post title

			   $order="post_title DESC";

		}

		if(get_query_var('most_commented')) {

			// alphabetical order by post bomment count

			$order="comment_count DESC";

		}

		if(get_query_var('most_recent')) {

			// alphabetical order by post date

			$order="post_date DESC";

		}
        if(get_query_var('oldest')) {

			// alphabetical order by post date

			$order="post_date ASC";

		}

		 return $order;

	}

	function user_sortby_options_dropdown(){

		global $wpdb;

        $getValue=$wpdb->get_row("select default_status from default_sorting_option",ARRAY_N);

		$scr = get_search_query();

		$scr = str_replace(" ", "+", $scr);

		$scr = "?s=".$scr;

		function CMcurPageURL() {

			$pageURL = 'http';

			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

			$pageURL .= "://";

			if ($_SERVER["SERVER_PORT"] != "80") {

				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

				} else {

				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

			}

			return $pageURL;
		}

		$trueurl = CMcurPageURL();

		$urlsrt = explode("?", $trueurl);

		$urlOne='';

		$urlTwo='';

		$dropTitleOne='All&nbsp;&nbsp;';

		$dropTitleTwo='Select';

			wp_register_style('dropdown.css', plugins_url('dropdown.css', __FILE__));

			wp_enqueue_style('dropdown.css');

wp_register_style('mytheme.css', plugins_url('mytheme.css', __FILE__));

			wp_enqueue_style('mytheme.css');

			wp_enqueue_script('dropdown.js',plugins_url('dropdown.js', __FILE__),array('jquery'),'','true');

		if (is_archive() || is_category() || is_home()){


			$return ='<div class="sort-button-cont"><div class="CM-sorttext">Sort By</div><div style="clear:both;"></div>';

			$return .='	<div class="btn-group">

            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">'.$dropTitleTwo.' <span class="caret"></span></button>

            <ul class="dropdown-menu">

                <li><a href="?';
				
				if(isset($_GET['cat'])){
		$return.="cat=".$_GET['cat']."&";
		}

		if($urlOne!=''){$return.= $urlOne."&oldest=1";}else{$return.= "oldest=1" ;}

		$return.='">Oldest</a></li>

                <li><a href="?';
				
				if(isset($_GET['cat'])){
		$return.="cat=".$_GET['cat']."&";
		}

		if($urlOne!=''){$return.= $urlOne."&title_az=1";}else{$return.= "title_az=1" ;}

		$return.='">Title (A&#8594;Z)</a></li>

                <li><a href="?';
				
				if(isset($_GET['cat'])){
		$return.="cat=".$_GET['cat']."&";
		}

		if($urlOne!=''){$return.= $urlOne."&title_za=1";}else{$return.= "title_za=1" ;}

		$return.='">Title (Z&#8592;A)</a></li>

		<li><a href="?';
		
		if(isset($_GET['cat'])){
		$return.="cat=".$_GET['cat']."&";
		}

		if($urlOne!=''){$return.= $urlOne."&most_recent=1";}else{$return.= "most_recent=1" ;}

		$return.='">Most Recent</a></li>

<li><a href="?';

if(isset($_GET['cat'])){
		$return.="cat=".$_GET['cat']."&";
		}

		if($urlOne!=''){$return.= $urlOne."&most_commented=1";}else{$return.= "most_commented=1" ;}

		$return.='">Most Commented</a></li>

            </ul>

        </div>';

				$return .=	'<div style="clear:both;"></div></div>';

		} else if (is_search()){

			$return ='<div class="sort-button-cont"><div class="CM-sorttext">Sort By</div><div style="clear:both;"></div>';

			$return .='	<div class="btn-group">

            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">'.$dropTitleTwo.' <span class="caret"></span></button>

            <ul class="dropdown-menu">

                <li><a href="?';

		if($urlOne!=''){$return.= $scr."&".$urlOne."&oldest=1";}else{$return.= $scr."&oldest=1" ;}

		$return.='">Oldest</a></li>

                <li><a href="?';

		if($urlOne!=''){$return.= $scr."&".$urlOne."&title_az=1";}else{$return.=  $scr."&title_az=1" ;}

		$return.='">Title (A&#8594;Z)</a></li>

                <li><a href="?';

		if($urlOne!=''){$return.= $scr."&".$urlOne."&title_za=1";}else{$return.=  $scr."&title_za=1" ;}

		$return.='">Title (Z&#8592;A)</a></li>

		<li><a href="?';

		if($urlOne!=''){$return.= $scr."&".$urlOne."&most_recent=1";}else{$return.=  $scr."&most_recent=1" ;}

		$return.='">Most Recent</a></li>

<li><a href="?';

		if($urlOne!=''){$return.= $scr."&".$urlOne."&most_commented=1";}else{$return.=  $scr."&most_commented=1" ;}

		$return.='">Most Commented</a></li>

            </ul>

        </div>';

				$return .=	'<div style="clear:both;"></div></div>';

		}

		echo $return;

	}	

        add_action( 'admin_menu', 'register_my_custom_menu_page' );

        function register_my_custom_menu_page(){

        add_menu_page( 'Sorting', 'Sorting', '', 'sorting/sorting-admin.php', '', plugins_url( 'sorting-options/img/search_16.png' ) );

        add_submenu_page( 'sorting/sorting-admin.php', 'Default Sorting', 'Default Sorting', 'manage_options', 'my-custom-menu-page', 'user_administrator_options_page' ); 

}

        if(isset($_POST['default_option'])){
        
        global $wpdb;

        $wpdb->query("update default_sorting_option set default_status='".$_POST['default_option']."'");
}

        function user_administrator_options_page() {


        global $wpdb;

        $getValue=$wpdb->get_row("select default_status from default_sorting_option",ARRAY_N);
        
	    echo '<h3>Set Default Sorting Option</h3>
	    <form action="" method="post" >
		<p>
			<label style="display:block; float:left; width:200px;">Select Default Value</label> 
			<select name="default_option">
				<option value="">No Default value</option>
				<option value="oldest"';
				if($getValue[0]=='oldest'){
				echo " selected='selected'";
				}
				echo '>Oldest</option>
				<option value="az"';
				if($getValue[0]=='az'){
				echo " selected='selected'";
				}
				echo '>Title (A-Z)</option>
				<option value="za"';
				
				if($getValue[0]=='za'){
				echo " selected='selected'";
				}
				echo '>Title (Z-A)</option>
				<option value="most_recent"';
				if($getValue[0]=='most_recent'){
				echo " selected='selected'";
				}
				echo '>Most Recent</option>
				<option value="most_commented"'; 
				if($getValue[0]=='most_commented'){
				echo " selected='selected'";
				}
				echo '>Most Commented</option>
			</select>
			
		</p>
		<p><input type="submit" value="Save" class="button button-primary" /></p>
	</form>
	
	';
}

    register_activation_hook(__FILE__,'user_install_sorting_options'); 


     /* Runs on plugin deactivation*/

    register_deactivation_hook( __FILE__, 'user_remove_sorting_options' );


    function user_install_sorting_options() {

    global $wpdb;

	$sql = "CREATE TABLE default_sorting_option  (

	`id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,

	`default_status` VARCHAR( 50 ))";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	dbDelta($sql);
	   
	$wpdb->query("insert into default_sorting_option values('','')");

}

    function user_remove_sorting_options() {

    global $wpdb;

	$wpdb->query("drop table default_sorting_option");
	
}