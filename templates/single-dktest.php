<?php
global $template_url;
function plugin_theme_style() {
	global $template_url;
	$template_dir = plugin_dir_path( __DIR__ ) . 'templates/';
	$template_url = plugin_dir_url( __DIR__ ) . 'templates/';
	$filetime = date( "YmdHi", filemtime( $template_dir . 'dk_plugin_style.css' ) );
	wp_enqueue_style( 'dk_pluginn_style', $template_url . 'dk_plugin_style.css', array(), $filetime );

	wp_enqueue_script('jquery', false, array(), false, false);
	$filetime = date( "YmdHi", filemtime( $template_dir . 'dk_plugin_script.js' ) );
	wp_enqueue_script( 'dk_pluginn_script', $template_url . 'dk_plugin_script.js', array(), $filetime );
}
add_action( 'wp_enqueue_scripts', 'plugin_theme_style' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body>

		<div id="dk_main">

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				$content = get_the_content();
				//var_dump($content);
				$image = preg_match_all( "/<\!-- wp:image \{.*?\} -->\n(.*?)\n<\!-- \/wp:image -->/s", $content, $images );
				foreach( $images[1] as $image ) {
					if( strpos( $image, 'background' ) !== false ) {
						$img = preg_match( "/(<img src=.*?\/>)/s", $image, $background );
					} else {
						$img = preg_match( "/(<img src=.*?\/>)<figcaption>(.*?)<\/figcaption>/s", $image, $imgs );
						$frontimg[] = array(
							'img' => $imgs[1],
							'pos' => explode( ',', $imgs[2] ),
						);
					}
				}
				if( !isset( $background ) ) {
					$background[1] = '<img src="' . $template_url . 'img/320x240.png">';
				}
				$member = preg_match_all( "/<\!-- wp:heading -->\n<h2>(.*?)<\/h2>\n<\!-- \/wp:heading -->/s", $content, $members );
				$message = preg_match_all( "/<\!-- wp:paragraph -->\n(.*?)\n<\!-- \/wp:paragraph -->/s", $content, $messages );
				$choice = preg_match( "/<\!-- wp:list -->\n(.*?)\n<\!-- \/wp:list -->/s", $content, $choices );
				if( !isset( $choices[1] ) ) {
					$choices[1] = '';
				}
				//var_dump($background[1], $frontimg, $members[1],$messages[1],$choices[1]);
				foreach( $members[1] as $key => $member ):
					echo '<div class="column">' . "\n";
					echo '<div class="background">' . $background[1] . '</div>' . "\n";
					foreach( $frontimg as $img ) {
						if( explode( ':', $img['pos'][0] )[1] == ( $key + 1 ) ) {
							echo '<div class="frontimg" front-img-x="' . explode( ':', $img['pos'][1] )[1] . '" front-img-y="' . explode( ':', $img['pos'][2] )[1] . '">' . $img['img'] . '</div>' . "\n";
						}
					}
					echo '<div class="name">' . $member . '</div>' . "\n";
					echo '<div class="message">' . $messages[1][$key] . '</div>' . "\n";
					echo '<div class="next">▶</div>' . "\n";
					echo '</div>' . "\n";
				endforeach;
					echo '<div class="column">' . "\n";
					echo '<div class="background">' . $background[1] . '</div>' . "\n";
					echo '<div class="message">' . $choices[1] . '</div>' . "\n";
					echo '</div>' . "\n";

			endwhile; // End the loop.
			?>

		</div><!-- #dk_main -->

<?php wp_footer(); ?>
</body>
</html>
