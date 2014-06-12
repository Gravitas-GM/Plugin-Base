<?php
	namespace gravitas\pluginbase;

	abstract class PluginBase {
		public function addMenuPage($title, $type, $plug, $pageName) {
			$main = $this;

			\add_menu_page($title, $title, $type, $plug, function() use ($main, $pageName) {
				$main->getPage($pageName);
			});
		}

		public function getPage($page) {
			if (!file_exists(sprintf('%spages/%s.php', \plugin_dir_path(__FILE__), $page)))
				echo '<div><strong>Page not found.</strong></div>';
			else
				echo file_get_contents(\plugins_url('pages/' . $page . '.php', __FILE__));
		}

		public function addNotice(NoticeLevel $level, $message) {
			\add_action('admin_notices', function() use ($level, $message) {
				printf('<div class="%1$s"><p>%2$s</p></div>', $level, $message);
			});
		}
	}
?>