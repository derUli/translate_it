<?php

declare(strict_types=1);

class TranslateItController extends MainClass
{
    private $moduleName = "translate_it";

    public function downloadFile()
    {
        $acl = new ACL();
        if (!$acl->hasPermission($this->moduleName)) {
            exit();
        }

        $languageCode = Request::getVar("language_code", getCurrentLanguage());
        
        $code = $this->_getCode($_POST, $languageCode);
        send_header('Content-Description: Language File');
        send_header('Content-Type: application/octet-stream');
        $filename = basename($languageCode) . "-" . time() . ".php";
        DownloadResultFromString($code, $filename);
    }

    public function _getCode(array $post, string $languageCode): string
    {
        $code = "<?php\r\n";
        foreach ($post as $key => $value) {
            if (startsWith($key, "TRANSLATION_")) {
                $mykey = str_replace("\"", "\\\"", normalizeLN($key));
                $myvalue = str_replace("\"", "\\\"", normalizeLN($value));
                $code .= "define ( \"$mykey\", \"$myvalue\" );\r\n";
            }
        }
        $code .= "\r\n";
        $code .= "do_event ( \"lang_" . str_replace("\"", "\\\"", $languageCode) . "\" );\r\n";
        return $code;
    }

    public function _getAllTranslations(): array
    {
        $result = [];
        $constants = get_defined_constants();
        foreach ($constants as $key => $value) {
            if (startsWith($key, "TRANSLATION_")) {
                $result[$key] = $value;
            }
        }
        ksort($result);
        return $result;
    }

    // headline of settings page
    public function getSettingsHeadline()
    {
        return get_translation("translate_it");
    }

    public function settings()
    {
        ViewBag::set("translations", $this->_getAllTranslations());
        return Template::executeModuleTemplate($this->moduleName, "form");
    }
}
