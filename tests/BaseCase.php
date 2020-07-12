<?php

namespace ssadon\Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use ssadon\YandexTranslate;


/**
 * Class BaseCase
 * @package YandexTranslate\Tests
 */
abstract class BaseCase extends TestCase
{
    /* @var YandexTranslate */
    public $yandexTranslate;

    /**
     * BaseCase constructor.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct()
    {
        parent::__construct();

        $dotenv = Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();

        $this->yandexTranslate = new YandexTranslate(
            $_ENV['YANDEX_OAUTH_TOKEN'],
            $_ENV['YANDEX_IAM_TOKEN'],
            $_ENV['YANDEX_FOLDER_ID']
        );
    }
}
