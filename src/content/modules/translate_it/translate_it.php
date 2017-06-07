<?php
class TranslateIt extends Controller {
	private $moduleName = "translate_it";
	public function downloadFile() {
		$code = "<?php\r\n";
		foreach ( $_POST as $key => $value ) {
			if (startsWith ( $key, "TRANSLATION_" )) {
				$mykey = str_replace ( "\"", "\\\"", normalizeLN ( $key ) );
				$myvalue = str_replace ( "\"", "\\\"", normalizeLN ( $value ) );
				$code .= "define ( \"$mykey\", \"$myvalue\" );\r\n";
			}
		}
		header ( 'Content-Description: Language File' );
		header ( 'Content-Type: application/octet-stream' );
		$file = Request::getVar ( "language_code", getCurrentLanguage () );
		$file = basename ( $file ) . ".php";
		header ( 'Content-Disposition: attachment; filename="' . $file . '"' );
		header ( 'Expires: 0' );
		header ( 'Cache-Control: must-revalidate' );
		header ( 'Pragma: public' );
		header ( 'Content-Length: ' . mb_strlen ( $code, '8bit' ) );
		echo $code;
		exit ();
	}
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