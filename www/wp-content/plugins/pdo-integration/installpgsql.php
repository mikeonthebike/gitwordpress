<?php
/**
 * This file contains the only one function wp_install().
 *
 * @package SQLite Integration
 * @author Kojima Toshiyasu, Justin Adie
 *
 */

if (!defined('ABSPATH')) {
	echo 'Thank you, but you are not allowed to access this file.';
	die();
}

/**
 * This function overrides wp_install() in wp-admin/includes/upgrade.php
 */
function wp_install($blog_title, $user_name, $user_email, $public, $deprecated = '', $user_password = '') {
	if (!empty($deprecated))
		_deprecated_argument(__FUNCTION__, '2.6');

	wp_check_mysql_version();
	wp_cache_flush();
	/* changes */
	include_once PDODIR . 'querypgsql_create.class.php';
	include_once ABSPATH . 'wp-admin/includes/schema.php';
	$index_array   = array();

	$table_schemas = wp_get_db_schema();
	$queries = explode (";", $table_schemas);
	$query_parser  = new CreateQuery();
	try {
		$pdo = new PDO(FQDB, null, null, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (PDOException $err) {
		$err_data = $err->errorInfo;
		$message  = 'Database connection error!<br />';
		$message .= sprintf("Error message is: %s", $err_data[2]);
		wp_die($message, 'Database Error!');
	}

	try {
		$pdo->beginTransaction();
		foreach ($queries as $query) {
			$query = trim($query);
			if (empty($query))
				continue;
			$rewritten_query = $query_parser->rewrite_query($query);
			if (is_array($rewritten_query)) {
				foreach($rewritten_query as $query){
					echo $query . "<br />";
				}
			}else{
				echo $rewritten_query . "<br />";
			}
//			$pdo->exec($query);
		}
		$pdo->commit();
	} catch (PDOException $err) {
		$err_data = $err->errorInfo;
		$err_code = $err_data[1];
		if (5 == $err_code || 6 == $err_code) {
			// if the database is locked, commit again
			$pdo->commit();
		} else {
			$pdo->rollBack();
			$message  =  sprintf("Error occured while creating tables or indexes...<br />Query was: %s<br />", var_export($rewritten_query, true));
			$message .= sprintf("Error message is: %s", $err_data[2]);
			wp_die($message, 'Database Error!');
		}
	}

	$query_parser = null;
	$pdo   = null;
	/* changes */
	populate_options();
	populate_roles();

	update_option('blogname', $blog_title);
	update_option('admin_email', $user_email);
	update_option('blog_public', $public);

	$guessurl = wp_guess_url();

	update_option('siteurl', $guessurl);

	if (!$public)
		update_option('default_pingback_flag', 0);

	$user_id        = username_exists($user_name);
	$user_password  = trim($user_password);
	$email_password = false;
	if (!$user_id && empty($user_password)) {
		$user_password = wp_generate_password(12, false);
		$message = __('<strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you.');
		$user_id = wp_create_user($user_name, $user_password, $user_email);
		update_user_option($user_id, 'default_password_nag', true, true);
		$email_password = true;
	} else if (!$user_id) {
		$message = '<em>'.__('Your chosen password.').'</em>';
		$user_id = wp_create_user($user_name, $user_password, $user_email);
	}

	$user = new WP_User($user_id);
	$user->set_role('administrator');

	wp_install_defaults($user_id);

	flush_rewrite_rules();

	wp_new_blog_notification($blog_title, $guessurl, $user_id, ($email_password ? $user_password : __('The password you chose during the install.')));

	wp_cache_flush();

	if (isset($_SERVER['SERVER_SOFTWARE']) && stripos($_SERVER['SERVER_SOFTWARE'], 'apache') !== false || isset($_SERVER['SERVER_SIGNATURE']) && stripos($_SERVER['SERVER_SIGNATURE'], 'apache') !== false) {
		;// Your server is Apache. Nothing to do more.
	} else {
		$server_message = sprintf('Your webserver doesn\'t seem to be Apache. So the database directory access restriction by the .htaccess file may not function. We strongly recommend that you should restrict the access to the directory %s in some other way.', FQDBDIR);
		echo '<div style="position: absolute; margin-top: 350px; width: 700px; border: .5px dashed rgb(0, 0, 0);"><p style="margin: 10px;">';
		echo $server_message;
		echo '</p></div>';
	}

	return array('url' => $guessurl, 'user_id' => $user_id, 'password' => $user_password, 'password_message' => $message);
}
?>