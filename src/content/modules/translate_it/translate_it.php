<?php
class TranslateIt extends Controller {
	private $moduleName = "translate_it";
	protected function getAllTranslations() {
		$result = array ();
		$constants = get_defined_constants ();
		foreach ( get_defined_constants () as $key => $value ) {
			if (startsWith ( $key, "TRANSLATION_" )) {
				$result [$key] = $value;
			}
		}
		return $result;
	}
	// headline of settings page
	public function getSettingsHeadline() {
		return get_translation ( "translate_it" );
	}
	public function settings() {
		ViewBag::set ( "translations", $this->getAllTranslations () );
		return Template::executeModuleTemplate ( $this->moduleName, "form" );
	}
}