<?php
	namespace gravitas\pluginbase;

	use dbstudios\phpenum\Enum;

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

			parent::stopRegistration();
		}
	}

	PageType::init();
?>