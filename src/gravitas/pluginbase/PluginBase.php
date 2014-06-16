<?php
	namespace gravitas\pluginbase;

	use \Serializable;

	abstract class PluginBase implements Serializable {
		const PLUGIN_ROOT_SEARCH_LEN = 18;

		private $pageCache = array();

		public function addMenuPage($title, $pageName, $pageType = null, $hook = 'admin_menu', $plug = null) {
			if ($pageType === null)
				$pageType = PageType::OPTIONS();

			if ($pageType instanceof PageType)
				$pageType = $pageType->getCapability();

			if ($plug === null)
				$plug = strtolower(str_replace(' ', '-', $title));

			$page = $this->getPage($pageName);

			add_action($hook, function() use ($title, $page, $pageType, $plug) {
				add_menu_page($title, $title, $pageType, $plug, function() use ($page) {
					echo $page;
				});
			});
		}

		public function getPage($page) {
			if (array_key_exists($page, $this->pageCache))
				return $this->pageCache[$page];

			if (!file_exists(sprintf('%s/pages/%s.php', $this->getPluginRoot(), $page)))
				return '<div><strong>Page not found.</strong></div>';
			else {
				ob_start();

				include sprintf('%s/pages/%s.php', $this->getPluginRoot(), $page);

				$data = ob_get_clean();
			}

			$this->pageCache[$page] = $data;

			return $data;
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

		public function serialize() {
			return serialize(array());
		}

		public function unserialize($data) {
			// No need to do anything, really
		}
	}
?>
