<?php
/** Single learning resource. @package NotOnlyBook_Modern */
get_header(); ?>
<main id="main" class="nob-section">
	<div class="nob-container">
		<div class="nob-content-grid">
			<div class="nob-main-panel">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'nob-article' ); ?>>
						<header class="nob-article-header">
							<?php nob_breadcrumbs(); ?>
							<h1><?php the_title(); ?></h1>
							<div class="nob-article-meta">
								<span><?php echo esc_html( get_the_date() ); ?></span>
								<span><?php echo esc_html( sprintf( _n( '%s min read', '%s min read', nob_reading_time(), 'notonlybook-modern' ), number_format_i18n( nob_reading_time() ) ) ); ?></span>
								<?php $category = nob_primary_category(); if ( $category ) : ?>
									<a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
								<?php endif; ?>
							</div>
						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<div class="nob-article-hero"><?php the_post_thumbnail( 'large', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async' ) ); ?></div>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); wp_link_pages(); ?>
						</div>

						<footer class="nob-post-footer">
							<?php
							$tags = get_the_tags();
							if ( $tags ) {
								echo '<div class="nob-post-tags" aria-label="' . esc_attr__( 'Topics', 'notonlybook-modern' ) . '">';
								foreach ( array_slice( $tags, 0, 10 ) as $tag ) {
									printf( '<a href="%1$s">%2$s</a>', esc_url( get_tag_link( $tag ) ), esc_html( $tag->name ) );
								}
								echo '</div>';
							}
							?>
						</footer>
					</article>

					<?php nob_render_widget_ad_area( 'ad_bottom_post', 'nob-ad-zone--bottom' ); ?>
					<?php nob_render_ad( 'article_end' ); ?>

					<?php
					$previous_post = get_previous_post();
					$next_post     = get_next_post();
					if ( $previous_post || $next_post ) :
					?>
						<nav class="nob-post-navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'notonlybook-modern' ); ?>">
							<?php foreach ( array( 'previous' => $previous_post, 'next' => $next_post ) as $direction => $nav_post ) : if ( ! $nav_post ) { continue; } ?>
								<a class="nob-post-nav-card nob-post-nav-card--<?php echo esc_attr( $direction ); ?>" href="<?php echo esc_url( get_permalink( $nav_post ) ); ?>">
									<span class="nob-post-nav-thumb" aria-hidden="true">
										<?php
										if ( has_post_thumbnail( $nav_post ) ) {
											echo get_the_post_thumbnail( $nav_post, 'nob-nav-thumb', array( 'loading' => 'lazy', 'decoding' => 'async' ) );
										} else {
											echo '<span class="nob-card-placeholder">N</span>';
										}
										?>
									</span>
									<span class="nob-post-nav-copy">
										<small><?php echo 'previous' === $direction ? esc_html__( 'Previous article', 'notonlybook-modern' ) : esc_html__( 'Next article', 'notonlybook-modern' ); ?></small>
										<strong><?php echo esc_html( get_the_title( $nav_post ) ); ?></strong>
									</span>
								</a>
							<?php endforeach; ?>
						</nav>
					<?php endif; ?>

					<?php
					$related = nob_related_posts( get_the_ID(), 3 );
					if ( $related->have_posts() ) :
					?>
						<section class="nob-related" aria-labelledby="nob-related-title">
							<h2 id="nob-related-title"><?php esc_html_e( 'Related learning resources', 'notonlybook-modern' ); ?></h2>
							<div class="nob-card-grid">
								<?php while ( $related->have_posts() ) : $related->the_post(); get_template_part( 'template-parts/content', 'card' ); endwhile; ?>
							</div>
						</section>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>

					<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
				<?php endwhile; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
