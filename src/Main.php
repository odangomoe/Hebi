<?php


namespace Odango\Hebi;


use GuzzleHttp\Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Odango\Hebi\Nyaa\Iterator;
use Pimple\Container;
use Propel\Runtime\Propel;
use Symfony\Component\Yaml\Yaml;

class Main
{
    /**
     * @var Container
     */
    private $container;

    public function init($connection = null) {
        $this->initContainer();
        $this->container['main'] = $this;
        $this->initConfig();
        $this->initLogger();
        $this->initPropel($connection);
        $this->initGuzzle([]);
        ini_set('memory_limit', -1);
    }

    public function getContainer(): Container {
        return $this->container;
    }

    public function initGuzzle($options) {
        $this->container['guzzle'] = new Client($options);
    }

    public function initPropel($config = null) {
        $prefix = "";
        if ($config !== null) {
            $prefix = $config . '-';
        }

        include __DIR__ . '/../config/propel/' . $prefix . 'config.php';
        Propel::getServiceContainer()->setLogger('defaultLogger', $this->container['logger']);
    }

    public function initContainer() {
        $this->container = new Container();
    }

    public function initLogger() {
        $logger = new Logger("Hebi");
        $filename = $this->container['config']['log'];
        if ($filename[0] !== '/') {
            $filename = __DIR__ . '/../' . $filename;
        }

        $handler = new StreamHandler($filename);
        $logger->pushHandler($handler);

        $handler = new StreamHandler('php://stdout');
        $logger->pushHandler($handler);

        $this->container['logger'] = $logger;
    }

    public function initConfig() {
        $this->container['config'] = Yaml::parse(file_get_contents(__DIR__ . '/../config/hebi.yml'))['hebi'] ?? [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function run($action) {
        $this->init();

        switch ($action) {
            case 'nyaa':
                $crawler = new Iterator($this->container);
                $crawler->start();
                break;
            default:
                echo "Action '{$action}' doesn't exist\n";
                exit(1);
        }
    }
}