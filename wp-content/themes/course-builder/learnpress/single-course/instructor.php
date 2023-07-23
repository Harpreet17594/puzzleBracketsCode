<?php
/**
 * Template for displaying the instructor of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];
$link   = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
$user = new WP_User( get_the_author_meta( 'ID' ) );
$major = get_the_author_meta( 'lp_info_major', $user->ID );
?>

<div class="course-author instructors">
	<div class="text"><?php echo esc_html__( 'Instructors', 'course-builder' ) ?></div>
	<div class="info">
		<div class="lp-avatar">
			<a href="<?php echo esc_url( $link ); ?>" class="role">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 147 ); ?>
			</a>
			<div class="social">
				<?php thim_get_author_social_link(); ?>
			</div>
		</div>
		<div class="content">
			<div class="author">
				<a href="<?php echo esc_url( $link ); ?>" class="name">
					<?php echo get_the_author(); ?>
				</a>
				<?php if ( $major ) {
					echo '<div class="role">' . esc_html( $major ) . '</div>';
				} ?>
			</div>
			<div class="author-description">
				<?php echo get_the_author_meta( 'description' ); ?>
			</div>
		</div>
	</div>

</div>
