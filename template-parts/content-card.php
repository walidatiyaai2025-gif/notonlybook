<?php
/** Resource card. @package NotOnlyBook_Modern */
$category = nob_primary_category();
$placeholder = get_template_directory_uri() . '/assets/images/post-placeholder.svg';
?>
<article <?php post_class( 'nob-card' ); ?>>
	<a class="nob-card-media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
		<?php else : ?>
			<img class="nob-card-placeholder-image" src="<?php echo esc_url( $placeholder ); ?>" alt="" loading="lazy" decoding="async" width="1200" height="675">
		<?php endif; ?>
	</a>
	<div class="nob-card-body">
		<div class="nob-card-meta">
			<?php if ( $category ) : ?><a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a><?php endif; ?>
			<span><?php echo esc_html( get_the_date() ); ?></span>
		</div>
		<h3 class="nob-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="nob-card-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
	</div>
</article>
