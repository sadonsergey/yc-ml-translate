<?php

namespace YandexTranslate\Tests;


/**
 * Class DetectLanguageCase
 * @package YandexTranslate\Tests
 */
class DetectLanguageCase extends BaseCase
{

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDetectRussianText()
    {

        $ru = $this->yandexTranslate->detectLanguage('Текст на русском');

        $this->assertEquals('ru', $ru);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDetectEnglishText()
    {
        $en = $this->yandexTranslate->detectLanguage('English text');

        $this->assertEquals('en', $en);
    }
}
