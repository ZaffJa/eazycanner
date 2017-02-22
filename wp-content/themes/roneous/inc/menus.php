<?php
/**
 * Theme Menu
 *
 * @package TLG Theme
 *
 */

/**
	REGISTER MENU LOCATIONS
**/
if( !function_exists('roneous_register_nav_menus') ) {
	function roneous_register_nav_menus() {
		register_nav_menus( 
			array(
				'primary'  => esc_html__( 'Primary Navigation', 'roneous' ),
			) 
		);
	}
	add_action( 'init', 'roneous_register_nav_menus' );
}

/**
	ADD CUSTOM FIELD TO MENU ITEM
**/
if ( !function_exists('roneous_add_custom_nav_fields') ) {
	function roneous_add_custom_nav_fields( $menu_item ) {
		$menu_item->subtitle = get_post_meta( $menu_item->ID, '_menu_item_subtitle', true );
	    $menu_item->icon 	 = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
	    $menu_item->megamenu = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
	    $menu_item->button 	 = get_post_meta( $menu_item->ID, '_menu_item_button', true );
	    return $menu_item;
	}
	add_filter( 'wp_setup_nav_menu_item', 'roneous_add_custom_nav_fields' );
}

/**
	SAVE MENU CUSTOM FIELD
**/
if ( !function_exists('roneous_update_custom_nav_fields') ) {
	function roneous_update_custom_nav_fields( $menu_id, $menu_item_id, $args ) {
	    if ( isset( $_REQUEST['menu-item-subtitle'] ) && is_array( $_REQUEST['menu-item-subtitle'] ) )
	        update_post_meta( $menu_item_id, '_menu_item_subtitle', $_REQUEST['menu-item-subtitle'][$menu_item_id] );
	    if ( isset( $_REQUEST['menu-item-icon'] ) && is_array( $_REQUEST['menu-item-icon']) )
	        update_post_meta( $menu_item_id, '_menu_item_icon', $_REQUEST['menu-item-icon'][$menu_item_id] );
	    if ( isset( $_REQUEST['menu-item-megamenu'] ) && is_array( $_REQUEST['menu-item-megamenu'] ) )
	        update_post_meta( $menu_item_id, '_menu_item_megamenu', $_REQUEST['menu-item-megamenu'][$menu_item_id] );
	    if ( isset( $_REQUEST['menu-item-button'] ) && is_array( $_REQUEST['menu-item-button'] ) )
	        update_post_meta( $menu_item_id, '_menu_item_button', $_REQUEST['menu-item-button'][$menu_item_id] );
	}
	add_action( 'wp_update_nav_menu_item', 'roneous_update_custom_nav_fields', 10, 3 );
}

/**
	DEFINE MENU WALKER ADMIN EDIT
**/
if ( !function_exists('roneous_edit_walker') ) {
	function roneous_edit_walker( $walker, $menu_id ) {
	    return 'Roneous_Nav_Edit_Walker';
	}
	add_filter( 'wp_edit_nav_menu_walker', 'roneous_edit_walker', 10, 2 );
}

/**
	OVERRIDE MENU WALKER SITE
**/
if( !class_exists('Roneous_Nav_Walker') ) {
	class Roneous_Nav_Walker extends Walker_Nav_Menu {
	
		/**
		 * @see Walker::start_lvl()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of page. Used for padding.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul role=\"menu\" class=\" subnav\">\n";
		}
	
		/**
		 * @see Walker::start_el()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param int $current_page Menu item ID.
		 * @param object $args
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$class_names = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			if ( $args->has_children && $depth == 0 || $args->has_children && $depth == 1 ){
				$class_names .= ' has-dropdown';
			}
			if ( in_array( 'current-menu-item', $classes ) ) {
				$class_names .= ' active';
			}
			if ( 'yes' == $item->megamenu ) {
				$class_names .= ' megamenu-item';
			}
			if ( 'yes' == $item->button ) {
				$class_names .= ' menu-item-btn';
			}
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$output .= $indent . '<li' . ( $id ? ' id="' . esc_attr( $id ) . '"' : '' ) . ' ' . 
										 ( $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '' ) .'>';
			/**
			 * If item has_children add atts to a.
			 */
			$atts = array();
			$atts['target'] = !empty( $item->target )	? $item->target	: '';
			$atts['rel']    = !empty( $item->xfn )		? $item->xfn	: '';
			if ( $args->has_children && $depth === 0 ) {
				$atts['href'] = !empty( $item->url ) ? $item->url : '';
			} else {
				$atts['href'] = !empty( $item->url ) ? $item->url : '';
			}
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( !empty( $value ) ) {
					$value = 'href' === $attr ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . esc_attr( $attr ) . '="' . $value . '"';
				}
			}
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . ( ! empty( $item->icon ) ? '<i class="'. esc_attr( $item->icon ).'"></i> ' : '' ) . apply_filters( 'the_title',  $item->title, $item->ID ) . $args->link_after;
			$item_output .= ! empty( $item->attr_title ) ? '<span class="label">' . $item->attr_title . '</span>' : '';
			$item_output .= ! empty( $item->subtitle ) ? '<span>' . $item->subtitle . '</span>' : '';
			$item_output .= $args->has_children && 0 === $depth ? '</a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
		
		/**
		 * @see Walker::end_el()
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {}
	
		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth.
		 *
		 * This method shouldn't be called directly, use the walk() method instead.
		 *
		 * @see Walker::start_el()
		 *
		 * @param object $element Data object
		 * @param array $children_elements List of elements to continue traversing.
		 * @param int $max_depth Max depth to traverse.
		 * @param int $depth Depth of current element.
		 * @param array $args
		 * @param string $output Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
	        if ( ! $element ) return;
	        $id_field = $this->db_fields['id'];
	        if ( is_object( $args[0] ) ) {
	           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
	        }
	        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	    }
	
		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a manu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 *
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'manage_options' ) ) {
				extract( $args );
				$fb_output = null;
				if ( $container ) {
					$fb_output = '<' . esc_attr( $container );
					if ( $container_id ) $fb_output .= ' id="' . esc_attr( $container_id ) . '"';
					if ( $container_class ) $fb_output .= ' class="' . esc_attr( $container_class ) . '"';
					$fb_output .= '>';
				}
				$fb_output .= '<ul';
				if ( $menu_id ) $fb_output .= ' id="' . esc_attr( $menu_id ) . '"';
				if ( $menu_class ) $fb_output .= ' class="' . esc_attr( $menu_class ) . '"';
				$fb_output .= '>';
				$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">'
								. esc_html__( 'Set up a navigation now', 'roneous' ) . '</a></li>';
				$fb_output .= '</ul>';
				if ( $container ) $fb_output .= '</' . esc_attr( $container ) . '>';
				echo htmlspecialchars_decode($fb_output);
			}
		}
	}
}

/**
	OVERRIDE MENU WALKER ADMIN EDIT
**/
if( !class_exists('Roneous_Nav_Edit_Walker') ) {
	class Roneous_Nav_Edit_Walker extends Walker_Nav_Menu {
		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker_Nav_Menu::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker_Nav_Menu::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Start the element output.
		 *
		 * @see Walker_Nav_Menu::start_el()
		 * @since 3.0.0
		 *
		 * @global int $_wp_nav_menu_max_depth
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 * @param int    $id     Not used.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			ob_start();
			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) )
					$original_title = false;
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title = get_the_title( $original_object->ID );
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( esc_html__( '%s (Invalid)', 'roneous' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( esc_html__('%s (Pending)', 'roneous' ), $item->title );
			}

			$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

			$submenu_text = '';
			if ( 0 == $depth )
				$submenu_text = 'style="display: none;"';

			?>
			<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode(' ', $classes ); ?>">
				<div class="menu-item-bar">
					<div class="menu-item-handle">
						<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo esc_attr( $submenu_text ); ?>><?php esc_html_e( 'sub item', 'roneous' ); ?></span></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);
								?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'roneous'); ?>">&#8593;</abbr></a>
								|
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-down-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);
								?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'roneous'); ?>">&#8595;</abbr></a>
							</span>
							<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_attr_e('Edit Menu Item', 'roneous'); ?>" href="<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
							?>"><?php esc_html_e( 'Edit Menu Item', 'roneous' ); ?></a>
						</span>
					</div>
				</div>

				<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
					<?php if ( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'URL', 'roneous' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-wide">
						<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Navigation Label', 'roneous' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="field-title-attribute description description-wide">
						<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Title Attribute', 'roneous' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<!-- BEGIN: SUBTITLE FIELD - - - - - - - - - - - -->
					<p class="field-tlg-subtitle field-subtitle description description-wide">
						<label for="edit-menu-item-subtitle-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Subtitle', 'roneous' ); ?><br />
							<input type="text" id="edit-menu-item-subtitle-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-subtitle" name="menu-item-subtitle[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->subtitle ); ?>" />
						</label>
					</p>
					<!-- END: SUBTITLE FIELD - - - - - - - - - - - -->
					<!-- BEGIN: ICON FIELD - - - - - - - - - - - -->
					
					<p class="field-tlg-icon description description-wide">
						<label for="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Icon', 'roneous' ); ?><br />
							<input type="text" id="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-tlg-icon field-tlg-icon" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->icon ); ?>" />
							<input type="submit" class="button-secondary tlg-icon-trigger" value="<?php echo esc_attr( esc_html__( 'Show/Hide Icon list', 'roneous' ) ) ?>" data-target="#tlg-icons-menu-<?php echo esc_attr($item_id); ?>">
							<input type="submit" class="button-secondary tlg-icon-clear" value="<?php echo esc_attr( esc_html__( 'Clear', 'roneous' ) ) ?>" data-target="#edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
							<?php
							if( roneous_is_plugin_active( 'tlg_framework/index.php' ) ) {
								$icons = tlg_framework_get_icons();
								echo '<span class="tlg-icons slide-tlg-icon" id="tlg-icons-menu-'.esc_attr( $item_id ).'"><span class="tlg-icons-wrapper">';
								foreach( $icons as $icon ) { 
									$active = get_post_meta( $item_id, '_menu_item_icon', true ) == $icon ? ' active' : '';
									echo '<i class="icon '. esc_attr( $icon . $active ) .'" data-icon-class="'. esc_attr($icon) .'" data-icon-input="#edit-menu-item-icon-'.esc_attr( $item_id ).'"></i>';
								}
								echo '</span></span>';
							} else {
								echo '<p><strong>'.esc_html__( 'Please activate the TLG FrameWork plugin to use icon in menu.', 'roneous' ).'</strong></p>';
							}
							?>
						</label>
					</p>
					<!-- END: ICON FIELD - - - - - - - - - - - - -->
					<!-- BEGIN: MEGA MENU FIELD - - - - - - - - -->
					<p class="field-tlg-megamenu description description-thin">
						<label for="edit-menu-item-megamenu-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Enable mega menu?', 'roneous' ); ?><br />
							<?php
							$active_yes = $active_no = '';
							if ( 'yes' == get_post_meta( $item_id, '_menu_item_megamenu', true ) ) $active_yes = 'selected="selected"';
							else $active_no = 'selected="selected"';
							?>
							<select id="edit-menu-item-megamenu-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu" name="menu-item-megamenu[<?php echo esc_attr( $item_id ); ?>]">
								<option value="yes" <?php echo esc_attr( $active_yes ) ?>><?php esc_html_e( 'Yes', 'roneous' ) ?></option>
								<option value="no" <?php echo esc_attr( $active_no ) ?>><?php esc_html_e( 'No', 'roneous' ) ?></option>
							</select>
						</label>
					</p>
					<!-- END: MEGA MENU FIELD - - - - - - - - - -->
					<!-- BEGIN: BUTTON FIELD - - - - - - - - -->
					<p class="field-tlg-button description description-thin">
						<label for="edit-menu-item-button-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Enable button style?', 'roneous' ); ?><br />
							<?php
							$active_yes = $active_no = '';
							if ( 'yes' == get_post_meta( $item_id, '_menu_item_button', true ) ) $active_yes = 'selected="selected"';
							else $active_no = 'selected="selected"';
							?>
							<select id="edit-menu-item-button-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-button" name="menu-item-button[<?php echo esc_attr( $item_id ); ?>]">
								<option value="yes" <?php echo esc_attr( $active_yes ) ?>><?php esc_html_e( 'Yes', 'roneous' ) ?></option>
								<option value="no" <?php echo esc_attr( $active_no ) ?>><?php esc_html_e( 'No', 'roneous' ) ?></option>
							</select>
						</label>
					</p>
					<!-- END: BUTTON FIELD - - - - - - - - - -->
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php esc_html_e( 'Open link in a new window/tab', 'roneous' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'CSS Classes (optional)', 'roneous' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Link Relationship (XFN)', 'roneous' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Description', 'roneous' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'roneous' ); ?></span>
						</label>
					</p>

					<p class="field-move hide-if-no-js description description-wide">
						<label>
							<span><?php esc_html_e( 'Move', 'roneous' ); ?></span>
							<a href="#" class="menus-move menus-move-up" data-dir="up"><?php esc_html_e( 'Up one', 'roneous' ); ?></a>
							<a href="#" class="menus-move menus-move-down" data-dir="down"><?php esc_html_e( 'Down one', 'roneous' ); ?></a>
							<a href="#" class="menus-move menus-move-left" data-dir="left"></a>
							<a href="#" class="menus-move menus-move-right" data-dir="right"></a>
							<a href="#" class="menus-move menus-move-top" data-dir="top"><?php esc_html_e( 'To the top', 'roneous' ); ?></a>
						</label>
					</p>

					<div class="menu-item-actions description-wide submitbox">
						<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( esc_html__('Original: %s', 'roneous' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
						echo wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'delete-menu-item',
									'menu-item' => $item_id,
								),
								admin_url( 'nav-menus.php' )
							),
							'delete-menu_item_' . $item_id
						); ?>"><?php esc_html_e( 'Remove', 'roneous' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
							?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e('Cancel', 'roneous' ); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}
	}
}