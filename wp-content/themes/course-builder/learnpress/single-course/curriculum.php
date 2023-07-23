<?php
/**
 * Template for displaying the curriculum of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course             = LP()->global['course'];
$post               = get_post();
$lessons            = sizeof( $course->get_lessons() );
$curriculum_heading = apply_filters( 'learn_press_curriculum_heading', 'Course Curriculum' );

?>
<div class="course-curriculum" id="learn-press-course-curriculum">

	<?php if ( $curriculum = $course->get_curriculum() ): ?>
		<?php if ( $curriculum_heading ) { ?>
			<div class="info-course">
				<h2 class="course-curriculum-title"><?php echo esc_attr( $curriculum_heading ); ?></h2>
				<span class="total-lessons">Total learning: <span class="text"><?php echo intval( $lessons ) > 1 ? sprintf( __( '%d lessons</span>', 'course-builder' ), $lessons ) : sprintf( __( '%d <span class="text">lessons</span>', 'course-builder' ), $lessons ); ?></span>
				<span class="total-time">Time: <span class="text"><?php echo get_post_meta( $post->ID, '_lp_duration', true ) ?></span></span>
			</div>

		<?php } ?>

		<?php do_action( 'learn_press_before_single_course_curriculum' ); ?>

		<ul class="curriculum-sections">
			<?php foreach ( $curriculum as $lessons ) : ?>
				<?php learn_press_get_template( 'single-course/loop-section.php', array( 'section' => $lessons ) ); ?>
			<?php endforeach; ?>
		</ul>

	<?php else: ?>
		<p class="curriculum-empty">
			<?php echo apply_filters( 'learn_press_course_curriculum_empty', esc_attr__( 'Curriculum is empty', 'course-builder' ) ); ?>
		</p>
	<?php endif; ?>

	<?php do_action( 'learn_press_after_single_course_curriculum' ); ?>
</div>