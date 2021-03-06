<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content">

	<?php

	$archive_title    = '';
	$archive_subtitle = '';

	if ( is_search() ) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __( 'Search:', 'twentytwenty' ) . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ( $wp_query->found_posts ) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n( $wp_query->found_posts )
			);
		} else {
			$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty' );
		}
	} elseif ( is_archive() && ! have_posts() ) {
		$archive_title = __( 'Nothing Found', 'twentytwenty' );
	} elseif ( ! is_home() ) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ( $archive_title || $archive_subtitle ) {
		?>

		<header class="archive-header has-text-align-center header-footer-group">

			<div class="archive-header-inner section-inner medium">

				<?php if ( $archive_title ) { ?>
					<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
				<?php } ?>

				<?php if ( $archive_subtitle ) { ?>
					<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
				<?php } ?>

			</div><!-- .archive-header-inner -->

		</header><!-- .archive-header -->

		<?php
	}

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			if ( $i > 1 ) {
				echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			}
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		}
	} elseif ( is_search() ) {
		?>

		<div class="no-search-results-form section-inner thin">

			<?php
			get_search_form(
				array(
					'aria_label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?>

		</div><!-- .no-search-results -->

		<?php
	}
	?>

	<?php/* get_template_part( 'template-parts/pagination' );*/ ?>

</main><!-- #site-content -->

<?php 
	$max_pages = $wp_query->max_num_pages;
	// echo $max_pages;
?>

<div class="load-imp" style="display: flex;justify-content: center;padding: 20px;">
	<a id="load-more" href="#" data-pagenum="1" data-maxpages='<?php echo $max_pages;?>'  style="padding: 12px;border: 1px solid black;border-radius: 20px;font-size: 16px;text-decoration:none;">Load more</a>
	<p style="display:none;">No more posts available</p>
</div>

<?php /*get_template_part( 'template-parts/footer-menus-widgets' ); */ ?>

<?php 

//Displaying the custom post type services on homepage using wp query START
$args = array(
	'post_type' => 'Services',
	'post_status' => 'publish',
	'posts_per_page' => 6
);

$services_query = new WP_Query( $args );

if ( $services_query->have_posts() ) : ?>

<div>
	<h2 style="text-align:center;">SERVICES</h2>
	<div style="display: flex;justify-content: space-evenly;">
	<?php while( $services_query->have_posts() ) : $services_query->the_post(); ?>
		<div style="border:1px solid black;padding: 20px 10px; text-align:center;">
			<h4><?php the_title(); ?></h4>
			<h5><?php the_content(); ?></h5>
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
			<?php endif; ?>	
		</div>
	<?php endwhile; ?>
</div>
</div>
<?php endif; 

//Displaying the custom post type services on homepage using wp query END
?>

<?php
get_footer();
