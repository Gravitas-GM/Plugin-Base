<?php
	namespace gravitas\pluginbase;

	use dbstudios\phpenum\Enum;

	class NoticeLevel extends Enum {
		private $cssClass;

		public function __construct($cssClass) {
			$this->cssClass = $cssClass;
		}

		public function getClassName() {
			return $this->cssClass;
		}

		public static function init() {
			parent::register('ERROR', 'error');
			parent::register('NAG', 'update-nag');
			parent::register('UPDATE', 'updated');

			parent::stopRegistration();
		}
	}

	NoticeLevel::init();
?>