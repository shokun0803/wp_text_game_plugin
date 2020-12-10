<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */
function plugin_theme_style() {
	$template_dir = plugin_dir_path( __DIR__ ) . 'templates/';
	$template_url = plugin_dir_url( __DIR__ ) . 'templates/';
	$filetime = date( "YmdHi", filemtime( $template_dir . 'dk_plugin_style.css' ) );
	wp_enqueue_style( 'dk_pluginn_style', $template_url . 'dk_plugin_style.css', array(), $filetime );

	wp_enqueue_script('jquery', false, array(), false, false);
	$filetime = date( "YmdHi", filemtime( $template_dir . 'dk_plugin_script.js' ) );
	wp_enqueue_script( 'dk_pluginn_script', $template_url . 'dk_plugin_script.js', array(), $filetime );
}
add_action( 'wp_enqueue_scripts', 'plugin_theme_style' );
get_header(); ?>

		<div id="dk_main">

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				$content = get_the_content();
				//var_dump($content);
				$member = preg_match_all( "/<\!-- wp:heading -->\n<h2>(.*?)<\/h2>\n<\!-- \/wp:heading -->/s", $content, $members );
				$message = preg_match_all( "/<\!-- wp:paragraph -->\n(.*?)\n<\!-- \/wp:paragraph -->/s", $content, $messages );
				$choice = preg_match( "/<\!-- wp:list -->\n(.*?)\n<\!-- \/wp:list -->/s", $content, $choices );
				//var_dump($members[1],$messages[1],$choices[1]);
				foreach( $members[1] as $key => $member ):
					echo '<div class="column">';
					echo '<div class="name">' . $member . '</div>';
					echo '<div class="message">' . $messages[1][$key] . '</div>';
					echo '<div class="next">▶</div>';
					echo '</div>';
				endforeach;
					echo '<div class="column">';
					echo '<div class="message">' . $choices[1] . '</div>';
					echo '</div>';

			endwhile; // End the loop.
			?>

		</div><!-- #dk_main -->

<?php
get_footer();
