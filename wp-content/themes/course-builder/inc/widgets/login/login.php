<?php

/**
 * Adds Thim_Login_Widget widget.
 */
class Thim_Login_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'thim-login',
			esc_html__( 'Thim: Login', 'course-builder' ),
			array( 'description' => esc_html__( 'Display login link', 'course-builder' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo ent2ncr( $args['before_widget'] );
		$html = '';
		if ( is_user_logged_in() ) {
			$user              = wp_get_current_user();
			$user_profile_edit = get_edit_user_link( $user->ID );
			$user_avatar       = get_avatar( $user->ID, 45 );

			if ( ! class_exists( 'LearnPress' ) ) {
				$html .= '<a href="' . esc_url( $user_profile_edit ) . '" class="user-name"><span class="author">' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
				$html .= '<ul class="user-info">';
			} else {
				$html .= '<a href="' . esc_url( $user_profile_edit ) . '" class="user-name"><span class="author">' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
				$html .= '<ul class="user-info">';

				$dropdown_content_args_default = $dropdown_content_args = array(
					'become_a_teacher' => esc_html__( 'Become An Instructor', 'course-builder' ),
					'courses'          => esc_html__( 'My Courses', 'course-builder' ),
					'orders'           => esc_html__( 'My Orders', 'course-builder' ),
					'certificates'     => esc_html__( 'My Certificates', 'course-builder' ),
					'settings'         => esc_html__( 'Edit Profile', 'course-builder' ),
				);

				$dropdown_content_args = apply_filters( 'thim_header_user_dropdown_content', $dropdown_content_args );

				foreach ( $dropdown_content_args as $slug => $title ) {
					if ( array_key_exists( $slug, $dropdown_content_args_default ) ) {
						if ( $slug == 'become_a_teacher' ) {
							$html .= '<li class="menu-item menu-item-become-a-teacher"><a href="' . learn_press_get_page_link( 'become_a_teacher' ) . '">' . ( $title ) . '</a></li>';
						} else {
							$html .= '<li class="menu-item menu-item-' . esc_attr( $slug ) . '"><a href="' . esc_url( learn_press_user_profile_link( $user->ID, $slug ) ) . '">' . ( $title ) . '</a></li>';
						}
					} else {
						$html .= '<li class="menu-item menu-item-custom"><a href="' . esc_url( $slug ) . '">' . ( $title ) . '</a></li>';
					}
				}
			}

			$html .= '<li class="menu-item menu-item-log-out">' . '<a href="' . wp_logout_url() . '">' . esc_html( $instance['text_logout'] ) . '</a></li>';
			$html .= '</ul>';
		} else {
			$login_url    = thim_get_login_page_url();
			$register_url = thim_get_register_url();
			if ( $instance['link'] ) {
				$login_url    = $instance['link'];
			}
			$html .= '<a href="' . esc_url( $register_url ) . '">' . esc_html( $instance['text_register'] ) . '</a> ' . '/' . ' <a href="' . esc_url( $login_url ) . '">' . esc_html( $instance['text_login'] ) . '</a>';
		}

		echo ent2ncr( $html );

		echo ent2ncr( $args['after_widget'] );
	}

	public function form( $instance ) {
		$text_register = isset( $instance['text_register'] ) ? $instance['text_register'] : esc_attr__( 'Register', 'course-builder' );
		$text_login    = isset( $instance['text_login'] ) ? $instance['text_login'] : esc_attr__( 'Login', 'course-builder' );
		$text_logout   = isset( $instance['text_logout'] ) ? $instance['text_logout'] : esc_attr__( 'Logout', 'course-builder' );
		$link          = isset( $instance['link'] ) ? $instance['link'] : '';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_register' ) ); ?>"><?php esc_attr_e( 'Register Text:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_register' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_register' ) ); ?>" type="text" value="<?php echo esc_attr( $text_register ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_login' ) ); ?>"><?php esc_attr_e( 'Login Text:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_login' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_login' ) ); ?>" type="text" value="<?php echo esc_attr( $text_login ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_logout' ) ); ?>"><?php esc_attr_e( 'Logout Text:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_logout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_logout' ) ); ?>" type="text" value="<?php echo esc_attr( $text_logout ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_attr_e( 'Login URL:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="url" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['text_register'] = ( ! empty( $new_instance['text_register'] ) ) ? strip_tags( $new_instance['text_register'] ) : '';
		$instance['text_login']    = ( ! empty( $new_instance['text_login'] ) ) ? strip_tags( $new_instance['text_login'] ) : '';
		$instance['text_logout']   = ( ! empty( $new_instance['text_logout'] ) ) ? strip_tags( $new_instance['text_logout'] ) : '';
		$instance['link']          = ( ! empty( $new_instance['link'] ) ) ? $new_instance['link'] : '';

		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		}

		return $instance;
	}

}

function thim_register_login_widget() {
	register_widget( 'Thim_Login_Widget' );
}

add_action( 'widgets_init', 'thim_register_login_widget' );
