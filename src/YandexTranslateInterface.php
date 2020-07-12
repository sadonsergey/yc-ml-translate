<?php


namespace YandexTranslate;


/**
 * Interface YandexTranslateInterface
 * @package YandexTranslate
 */
interface YandexTranslateInterface
{
    /**
     * @param  string  $langFrom
     * @param  string  $langTo
     * @param  array  $texts
     * @param  string  $format
     *
     * @return mixed
     */
    public function translate(string $langFrom, string $langTo, array $texts, string $format);

    /**
     * @param  string  $text
     *
     * @return mixed
     */
    public function detectLanguage(string $text);
}
