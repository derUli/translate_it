<?php

use Spatie\Snapshots\MatchesSnapshots;
use function UliCMS\HTML\stringContainsHtml;

class TranslateItTest extends \PHPUnit\Framework\TestCase
{
    use MatchesSnapshots;

    protected function setUp(): void
    {
        require_once getLanguageFilePath("en");
        Translation::loadAllModuleLanguageFiles("en");
    }

    public function testGetAllTranslations()
    {
        $controller = new TranslateItController();
        $translations = $controller->_getAllTranslations();

        $this->assertGreaterThan(600, count($translations));

        foreach ($translations as $key => $value) {
            $this->assertStringStartsWith("TRANSLATION_", $key);
            $this->assertNotEmpty($value);
        }
    }

    public function testGetSettingsHeadline()
    {
        $controller = new TranslateItController();
        $this->assertMatchesTextSnapshot($controller->getSettingsHeadline());
    }

    public function testSettings()
    {
        $controller = new TranslateItController();
        $html = $controller->settings();
        $this->assertTrue(stringContainsHtml($html));

        $allTranslations = $controller->_getAllTranslations();

        foreach ($allTranslations as $key => $value) {
            $this->assertStringContainsString($key, $html);
        }
    }

    public function testGetCode()
    {
        $controller = new TranslateItController();

        $translations = [
            "TRANSLATION_FOOBAR" => "Foo Bar",
            "TRANSLATION_HELLO_WORLD" => "Hello World"
        ];

        $this->assertMatchesTextSnapshot(
            $controller->_getCode($translations, "fr")
        );
    }
}
