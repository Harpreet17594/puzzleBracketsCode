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

$course = LP()->global['course'];

$curriculum_heading = apply_filters( 'learn_press_curriculum_heading', 'Course Content' );
?>
<div class="course-curriculum" id="learn-press-course-curriculum">
	<div class="row title-search">
		<?php if ( $curriculum_heading ) { ?>
			<div class="col-md-9">
				<h2 class="course-curriculum-title"><?php echo( $curriculum_heading ); ?></h2>
			</div>

		<?php } ?>
		<div class="col-md-3 search">
			<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
				<input type="search" class="search-field"
				       placeholder="<?php echo esc_attr__( 'Search...', 'course-builder' ) ?>"
				       value="<?php echo get_search_query() ?>" name="s" />
				<input type="hidden" name="post_type" value="lp_lession">
				<button type="submit" class="search-submit"><span class="ion-android-search"></span></button>
			</form>
		</div>
	</div>

	<?php do_action( 'learn_press_before_single_course_curriculum' ); ?>

	<?php if ( $curriculum = $course->get_curriculum() ): ?>

		<ul class="curriculum-sections">

			<?php foreach ( $curriculum as $section ) : ?>

				<?php learn_press_get_template( 'single-course/loop-section.php', array( 'section' => $section ) ); ?>

			<?php endforeach; ?>

		</ul>

	<?php else: ?>
		<?php echo apply_filters( 'learn_press_course_curriculum_empty', esc_attr__( 'Curriculum is empty', 'course-builder' ) ); ?>
	<?php endif; ?>

	<?php do_action( 'learn_press_after_single_course_curriculum' ); ?>

</div>