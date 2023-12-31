<?php
/**
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course     = LP()->global['course'];
$viewable   = learn_press_user_can_view_lesson( $item->ID, $course->id );
$tag        = $viewable ? 'a' : 'span';
$target     = $viewable ? 'target="' . apply_filters( 'learn_press_section_item_link_target', '_blank', $item ) . '"' : '';
$item_title = apply_filters( 'learn_press_section_item_title', get_the_title( $item->ID ), $item );
$item_link  = $viewable ? 'href="' . $course->get_item_link( $item->ID ) . '"' : '';
$time       = get_post_meta( $item->ID, '_lp_duration', true );
?>

<li <?php learn_press_course_item_class( $item->ID ); ?> data-type="<?php echo esc_attr( $item->post_type ); ?>">
	<?php do_action( 'learn_press_before_section_item_title', $item, $section, $course, 1 ); ?>
	<?php do_action( 'learn_press_course_lesson_quiz_before_title', $item ) ?>
	<<?php echo esc_attr( $tag ); ?> class="course-item-title button-load-item" <?php echo esc_attr( $target ); ?> <?php echo esc_attr( $item_link ); ?> data-id="<?php echo esc_attr( $item->ID ); ?>" data-complete-nonce="<?php echo wp_create_nonce( 'learn-press-complete-' . $item->post_type . '-' . $item->ID ); ?>"><?php echo esc_attr( $item_title ); ?></<?php echo esc_attr( $tag ); ?>>
<?php if ( $time ) { ?>
	<span class="time"><?php echo esc_html( $time ); ?></span>
<?php } ?>
<?php do_action( 'learn_press_after_section_item_title', $item, $section, $course ); ?>
</li>

