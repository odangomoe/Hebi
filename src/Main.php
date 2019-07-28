<?php


namespace Odango\Hebi;


use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Odango\Hebi\AniDB\Importer;
use Odango\Hebi\Atama\Updater;
use Odango\Hebi\Nyaa\Iterator;
use Odango\Hebi\NyaaSi\Crawler;
use Pimple\Container;
use Propel\Runtime\Propel;
use Symfony\Component\Yaml\Yaml;

class Main
{
    /**
     * @var Container
     */
    private $container;

    public function init($connection = null)
    {
        $this->initContainer();
        $this->container['run'] = $this;
        $this->initConfig();
        $this->initLogger();
        $this->initPropel($connection);
        $this->initGuzzle([]);
        ini_set('memory_limit', -1);
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function initGuzzle($options)
    {

        $cookieFile = __DIR__ . '/../storage/cookie-jar';
        $cookieJar = new FileCookieJar($cookieFile, true);

        $this->container['guzzle'] = new Client(
            array_merge($options, [
                'headers' => [
                    "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/50.0.2661.102 Chrome/50.0.2661.102 Safari/537.36",
                    "Accept" => "*/*",
                    "Accept-Encoding" => "gzip, deflate, sdch",
                    "Accept-Language" => "en-GB,en-US;q=0.8,en;q=0.6"
                ],
                'cookies' => $cookieJar
            ])
        );
    }

    public function initPropel($config = null)
    {
        $prefix = "";
        if ($config !== null) {
            $prefix = $config . '-';
        }

        include __DIR__ . '/../config/propel/' . $prefix . 'config.php';
        Propel::getServiceContainer()->setLogger('defaultLogger', $this->container['logger']);
    }

    public function initContainer()
    {
        $this->container = new Container();
    }

    public function initLogger()
    {
        $logger = new Logger("Hebi");
        $filename = $this->container['config']['log'] ?? false;

        if ($filename !== false) {
            if ($filename[0] !== '/') {
                $filename = __DIR__ . '/../' . $filename;
            }

            $handler = new StreamHandler($filename);
            $logger->pushHandler($handler);
        }

        $handler = new StreamHandler('php://stdout');
        $logger->pushHandler($handler);

        $this->container['logger'] = $logger;
    }

    public function initConfig()
    {
        $configPath = __DIR__ . '/../config/hebi.yml';
        $config = [];
        if (file_exists($configPath)) {
            $config = Yaml::parse(file_get_contents($configPath))['hebi'] ?? [];
        }

        $this->container['config'] = $config;
    }

    /**
     * @codeCoverageIgnore
     * @param $action string
     */
    public function run($action, $args)
    {
        $this->init();

        switch ($action) {
            case 'nyaa':
                $crawler = new Iterator($this->container);
                $crawler->start();
                break;
            case 'anidb':
                $importer = new Importer($this->container);
                $importer->run($args[0] ?? null);
                break;
            case 'atama':
                $updater = new Updater($this->container);
                $updater->run();
                break;
            case 'nyaa-backup':
                $importer = new NyaaBackup\Importer($this->container);
                $importer->run();
                break;
            case 'nyaasi':
                $crawler = new Crawler($this->container);
                $crawler->run();
                break;
            default:
                echo "Action '{$action}' doesn't exist\n";
                exit(1);
        }
    }
}