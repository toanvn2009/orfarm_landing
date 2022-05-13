<?php 
//echo "<pre>";print_r($_GET['content']); echo"</pre>";
if ( isset( $_GET['download'] ) ) { 
	
	//require_once ABSPATH . 'wp-admin/includes/export.php';
	include(get_template_directory() . '/includes/export/orfarm_export.php');



	$args = array();
	if ( ! isset( $_GET['content'] ) || 'all' === $_GET['content'] ) {
		$args['content'] = 'all';
	} elseif ( 'posts' === $_GET['content'] ) {
		$args['content'] = 'post';

		if ( $_GET['cat'] ) {
			$args['category'] = (int) $_GET['cat'];
		}

		if ( $_GET['post_author'] ) {
			$args['author'] = (int) $_GET['post_author'];
		}

		if ( $_GET['post_start_date'] || $_GET['post_end_date'] ) {
			$args['start_date'] = $_GET['post_start_date'];
			$args['end_date']   = $_GET['post_end_date'];
		}

		if ( $_GET['post_status'] ) {
			$args['status'] = $_GET['post_status'];
		}
	} elseif ( 'pages' === $_GET['content'] ) {
		$args['content'] = 'page';
		if ( $_GET['page_name'] ) {
			$args['page_name'] = $_GET['page_name'];
		}
		if ( $_GET['page_author'] ) {
			$args['author'] = (int) $_GET['page_author'];
		}

		if ( $_GET['page_start_date'] || $_GET['page_end_date'] ) {
			$args['start_date'] = $_GET['page_start_date'];
			$args['end_date']   = $_GET['page_end_date'];
		}

		if ( $_GET['page_status'] ) {
			$args['status'] = $_GET['page_status'];
		}
	} elseif ( 'attachment' === $_GET['content'] ) {
		$args['content'] = 'attachment';

		if ( $_GET['attachment_start_date'] || $_GET['attachment_end_date'] ) {
			$args['start_date'] = $_GET['attachment_start_date'];
			$args['end_date']   = $_GET['attachment_end_date'];
		}
	} elseif('nav_menu' === $_GET['content'] ) {
		orfarm_menu_exporter();
		die();
	} elseif('main' === $_GET['content'] ) {
		$args['content'] = 'main';
	}
	else {
		$args['content'] = $_GET['content'];
	}
	$args = apply_filters( 'export_args', $args );
	// echo "<pre>"; print_r($_POST); echo "</pre>";  die;
	// echo "<pre>"; print_r($args); echo "</pre>"; die;
	orfarm_export_wp( $args );
	die();
}

function export_date_options( $post_type = 'post' ) {
	global $wpdb, $wp_locale;

	$months = $wpdb->get_results(
		$wpdb->prepare(
			"
		SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
		FROM $wpdb->posts
		WHERE post_type = %s AND post_status != 'auto-draft'
		ORDER BY post_date DESC
			",
			$post_type
		)
	);

	$month_count = count( $months );
	if ( ! $month_count || ( 1 === $month_count && 0 === (int) $months[0]->month ) ) {
		return;
	}

	foreach ( $months as $date ) {
		if ( 0 === (int) $date->year ) {
			continue;
		}

		$month = zeroise( $date->month, 2 );
		echo '<option value="' . $date->year . '-' . $month . '">' . $wp_locale->get_month( $month ) . ' ' . $date->year . '</option>';
	}
}

?>


<form method="get" id="export-xml-123" >
<input type="hidden" name="download" value="true" />
<input type="hidden" name="page" value="export" />
<p><label><input type="radio" name="content" value="all" checked="checked" aria-describedby="all-content-desc" /> <?php _e( 'All content' ); ?></label></p>
<p class="description" id="all-content-desc"><?php _e( 'This will contain all of your posts, pages, comments, custom fields, terms, navigation menus, and custom posts.' ); ?></p>
<p><label><input type="radio" name="content" value="main" checked="checked" aria-describedby="all-content-desc" /> <?php _e( 'Main content' ); ?></label></p>
<p class="description" id="all-content-desc"><?php _e( 'This will contain main content of your posts, comments, custom fields, terms, navigation menus, and custom posts.' ); ?></p>
<p><label><input type="radio" name="content" value="pages" /> <?php _e( 'Pages' ); ?></label></p>
<ul id="page-filters-123"  class="export-filters-123">
	<li>
		<label for="page-status" class="label-responsive"><?php _e( 'Pos name:' ); ?></label>
		<select name="page_name" id="page-name">
			<option value="all"><?php _e( 'All' ); ?></option>
			<?php 
			   foreach(get_pages() as $page ) {
			?>
			    <option value="<?php echo $page->post_name; ?>"><?php echo $page->post_title; ?></option>
			<?php } ?>
	
		
		</select>
	</li>
</ul>
<p><label><input type="radio" name="content" value="nav_menu" /> <?php _e( 'Menus' ); ?></label></p>
<?php
foreach ( get_post_types(
	array(
		'_builtin'   => false,
		'can_export' => true,
	),
	'objects'
) as $post_type ) :

	?>
<?php endforeach; ?>
<p><label><input type="radio" name="content" value="attachment" /> <?php _e( 'Media' ); ?></label></p>
<ul id="attachment-filters" class="export-filters">
	<li>
		<fieldset>
		<legend class="screen-reader-text"><?php _e( 'Date range:' ); ?></legend>
		<label for="attachment-start-date" class="label-responsive"><?php _e( 'Start date:' ); ?></label>
		<select name="attachment_start_date" id="attachment-start-date">
			<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
			<?php export_date_options( 'attachment' ); ?>
		</select>
		<label for="attachment-end-date" class="label-responsive"><?php _e( 'End date:' ); ?></label>
		<select name="attachment_end_date" id="attachment-end-date">
			<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
			<?php export_date_options( 'attachment' ); ?>
		</select>
		</fieldset>
	</li>
</ul>
<p class="submit"><input type="submit"  id="orfarm-export-home123"  value="Export"></p>
</form>