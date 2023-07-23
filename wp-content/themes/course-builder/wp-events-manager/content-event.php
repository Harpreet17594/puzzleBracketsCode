<?php
/**
 * The template for displaying event content in the single-event.php template
 *
 * Override this template by copying it to yourtheme/tp-event/templates/content-event.php
 *
 * @author        ThimPress
 * @package       tp-event
 * @version       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
/**
 * tp_event_before_loop_event hook
 *
 */
do_action( 'tp_event_before_loop_event' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}
?>

<article id="event-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * tp_event_before_loop_event_summary hook
	 *
	 * @hooked tp_event_show_event_sale_flash - 10
	 * @hooked tp_event_show_event_images - 20
	 */
	do_action( 'tp_event_before_loop_event_item' );
	?>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="thumbnail">
			<?php do_action( 'tp_event_single_event_thumbnail' ); ?>
			<div class="date">
				<span class="date-start"><?php echo( wpems_event_start( 'd' ) ); ?></span>
				<span class="month-start"><?php echo( wpems_event_start( 'M' ) ); ?></span>
			</div>
		</div>
	<?php endif; ?>

	<div class="content">
		<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<div class="entry-meta">
						<span class="time">
							<i class="fa fa-calendar" aria-hidden="true"></i> <?php echo( wpems_event_start( 'g:i a' ) ); ?> - <?php echo( wpems_event_end( 'g:i a' ) ); ?>
						</span>
			<?php if ( wpems_event_location() ) { ?>
				<span class="location">
								<i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo( wpems_event_location() ); ?>
							</span>
			<?php } ?>
			<?php thim_entry_meta_author(); ?>
		</div>

		<div class="entry-excerpt">
			<?php the_excerpt(); ?>
		</div>

		<div class="read-more">
			<a href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Read more', 'course-builder' ); ?>
				<i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
	</div>


	<?php
	/**
	 * tp_event_after_loop_event_item hook
	 *
	 * @hooked tp_event_show_event_sale_flash - 10
	 * @hooked tp_event_show_event_images - 20
	 */
	do_action( 'tp_event_after_loop_event_item' );
	?>

</article>

<?php do_action( 'tp_event_after_loop_event' ); ?>
