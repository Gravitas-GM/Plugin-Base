<?php
	namespace gravitas\pluginbase;

	abstract class PluginBase {
		const PLUGIN_ROOT_SEARCH_LEN = 18;

		public function addMenuPage($title, $pageName, $pageType = null, $hook = 'admin_menu', $plug = null) {
			if ($pageType === null)
				$pageType = PageType::OPTIONS();

			if ($pageType instanceof PageType)
				$pageType = $pageType->getCapability();

			if ($plug === null)
				$plug = strtolower(str_replace(' ', '-', $title));

			$page = self::getPage($pageName);

			add_action($hook, function() use ($title, $page, $pageType, $plug) {
				add_menu_page($title, $title, $pageType, $plug, function() use ($page) {
					echo $page;
				});
			});
		}

		public function getPage($page) {
			if (!file_exists(sprintf('%s/pages/%s.php', self::getPluginRoot(), $page)))
				return '<div><strong>Page not found.</strong></div>';

			return file_get_contents(sprintf('%s/pages/%s.php', self::getPluginUrlRoot(), $page));
		}

		public function addNotice(NoticeLevel $level, $message) {
			add_action('admin_notices', function() use ($level, $message) {
				printf('<div class="%1$s"><p>%2$s</p></div>', $level, $message);
			});
		}

		public function getPluginRoot() {
			$pos = strpos(__DIR__, "wp-content/plugins") + self::PLUGIN_ROOT_SEARCH_LEN;
			
			return substr(__DIR__, 0, strpos(__DIR__, '/', $pos + 1));
		}

		public function getPluginUrlRoot() {
			$url = plugins_url('', __DIR__);
			$pos = strpos($url, "wp-content/plugins") + self::PLUGIN_ROOT_SEARCH_LEN;

			return substr($url, 0, strpos($url, '/', $pos + 1));
		}
	}
?>
