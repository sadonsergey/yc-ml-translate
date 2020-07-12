<?php

namespace YandexTranslate;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


/**
 * Class YandexTranslate
 * @package YandexTranslate
 */
class YandexTranslate implements YandexTranslateInterface
{
    /**
     * @var array
     */
    const URLS = [
        'token' => 'https://iam.api.cloud.yandex.net/iam/v1/tokens',
        'translate' => 'https://translate.api.cloud.yandex.net/translate/v2/',
    ];

    /**
     * @var null|string
     */
    protected $IAMToken;
    /**
     * @var null|string
     */
    protected $folderId;

    /**
     * YandexTranslate constructor.
     *
     * @param  null|string  $OAuthToken
     * @param  null|string  $IAMToken
     * @param  null|string  $folderId
     *
     * @throws \Exception|GuzzleException
     */
    public function __construct($OAuthToken = null, $IAMToken = null, $folderId = null)
    {
        /* Validate folder */
        if (!$folderId) {
            throw new \Exception('Folder id not set.');
        } else {
            $this->folderId = $folderId;
        }

        /* Validate token */
        if ($IAMToken) {
            $this->IAMToken = $IAMToken;
        } else {
            if ($OAuthToken && !$IAMToken) {
                $this->IAMToken = $this->getIAMToken($OAuthToken);
            } else {
                if (!$OAuthToken && !$IAMToken) {
                    throw new \Exception('Token not set.');
                }
            }
        }
    }


    /**
     * @param $OAuthToken
     *
     * @return mixed
     * @throws GuzzleException
     */
    private function getIAMToken($OAuthToken)
    {
        $data = $this->request(self::URLS['token'], '', [
            'yandexPassportOauthToken' => $OAuthToken,
        ]);

        return $data['iamToken'];
    }

    /**
     * @param $url
     * @param $uri
     * @param  array  $params
     *
     * @return array
     * @throws GuzzleException
     */
    private function request($url, $uri, array $params)
    {
        $client = new Client(['base_uri' => $url]);
        $response = $client->request('post', $uri, [
            'headers' => array_merge([
                'Accept' => 'application/json',
            ], $this->IAMToken ? [
                'Authorization' => 'Bearer '.$this->IAMToken,
            ] : []),
            'json' => $params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param $text
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function detectLanguage($text)
    {
        $data = $this->request(self::URLS['translate'], 'detect', [
            'text' => $text,
            'folderId' => $this->folderId,
        ]);

        return $data['languageCode'];
    }

    /**
     * @param $langFrom
     * @param $langTo
     * @param  array  $texts
     * @param  string  $format
     *
     * @return array
     * @throws GuzzleException
     */
    public function translate($langFrom, $langTo, $texts = [], $format = 'PLAIN_TEXT')
    {
        $translations = $this->request(self::URLS['translate'], 'translate', [
            'sourceLanguageCode' => $langFrom,
            'targetLanguageCode' => $langTo,
            'texts' => $texts,
            'format' => $format,
            'folderId' => $this->folderId,
        ])['translations'] ?: [];

        if (count($translations) === 1) {
            return current($translations);
        }

        return $translations;
    }
}
