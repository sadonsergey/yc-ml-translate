<?php

namespace ssadon\Tests;


/**
 * Class TranslateCase
 * @package ssadon\Tests
 */
class TranslateCase extends BaseCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testTranslateEnglishToRussian()
    {
        $this->assertEquals('собака', $this->yandexTranslate->translate('en', 'ru', 'dog')['text']);
        $this->assertEquals('кошка', $this->yandexTranslate->translate('en', 'ru', 'cat')['text']);

    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testTranslateRussianToEnglish()
    {
        $this->assertEquals('dog', $this->yandexTranslate->translate('ru', 'en', 'собака')['text']);
        $this->assertEquals('cat', $this->yandexTranslate->translate('ru', 'en', 'кошка')['text']);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testMultipleTranslateRussianToEnglish()
    {
        $texts = $this->yandexTranslate->translate('ru', 'en', ['собака', 'кошка']);

        $this->assertIsArray($texts);
        $this->assertCount(2, $texts);
        $this->assertEquals('dog', $texts[0]['text']);
        $this->assertEquals('cat', $texts[1]['text']);
    }
}
