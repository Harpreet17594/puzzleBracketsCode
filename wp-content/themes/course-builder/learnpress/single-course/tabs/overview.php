<?php
/**
 * Displaying the description of single course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];
$user   = learn_press_get_current_user();

if ( ! $course ) {
	return;
}

$description_heading = apply_filters( 'learn_press_single_course_description_heading', '', $course );
?>

<?php if ( $description_heading ) { ?>

	<h2 class="course-description-heading" id="learn-press-course-description-heading"><?php echo esc_attr( $description_heading ); ?></h2>

<?php } ?>

<div class="course-description" id="learn-press-course-description">

	<?php do_action( 'learn_press_begin_single_course_description' ); ?>

	<?php echo ent2ncr( $course->get_description() ); ?>

	<?php do_action( 'learn_press_end_single_course_description' ); ?>
	<?php
	if ( $user->has_course_status( $course->id, array(
			'enrolled',
			'finished'
		) ) || ! $course->is_require_enrollment()
	) {
		do_action( 'thim_learning_end_tab_overview' );
	}
	?>

</div>