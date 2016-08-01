<?php
	namespace Gravitas\PluginBase;

	use DaybreakStudios\Common\Enum\Enum;

	/**
	 * Class PageType
	 *
	 * @package gravitas\PluginBase
	 *
	 * @method static PageType OPTIONS()
	 */
	class PageType extends Enum {
		private $capability;

		public function __construct($capability) {
			$this->capability = $capability;
		}

		public function getCapability() {
			return $this->capability;
		}

		public static final function init() {
			parent::register('OPTIONS', 'manage_options');
		}
	}