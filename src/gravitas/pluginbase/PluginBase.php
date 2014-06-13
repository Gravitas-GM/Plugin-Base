<?php
	namespace gravitas\pluginbase;

	abstract class PluginBase {
		public function addMenuPage($title, $pageName, $pageType = PageType::OPTIONS, $hook = 'admin_menu', $plug = null) {
			if ($pageType instanceof PageType)
				$pageType = $pageType->getCapability();

			if ($plug === null)
				$plug = strtolower(str_replace(' ', '-', $title));
			
			$page = self::getPage($pageName);

			add_action($hook, function() use ($inst, $title, $page, $pageType, $plug) {
				add_menu_page($title, $title, $pageType, $plug, function() use ($inst, $page) {
					echo $page;
				});
			});
		}

		public function getPage($page) {
			if (!file_exists(sprintf('%spages/%s.php', plugin_dir_path(__FILE__), $page)))
				return '<div><strong>Page not found.</strong></div>';


			return file_get_contents(plugins_url('pages/' . $page . '.php', __FILE__));
		}

		public function addNotice(NoticeLevel $level, $message) {
			add_action('admin_notices', function() use ($level, $message) {
				printf('<div class="%1$s"><p>%2$s</p></div>', $level, $message);
			});
		}
	}
?>