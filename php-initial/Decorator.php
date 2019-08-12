<?php

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataProvider;

class DecoratorManager extends DataProvider
{
    public $cache;
    public $logger; // TODO: лучше использовать спецификатор доступа protected (или private), тем более, уже существует метод setLogger

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param CacheItemPoolInterface $cache
     */
    public function __construct($host, $user, $password, CacheItemPoolInterface $cache)
    {
        parent::__construct($host, $user, $password);
        $this->cache = $cache;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(array $input)
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = parent::get($input);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );

            return $result;
        } catch (Exception $e) {
            // TODO: Нет проверки на существование DecoratorManager->logger
            $this->logger->critical('Error'); // TODO: Логировать необходимо не только факт ошибки, но и информацию о ней, включая стек вызовов
        }

        return [];
    }

    // TODO: возможно, следует полностью избавиться от данного метода или, по крайней мере, использовать спецификатор доступа private
    public function getCacheKey(array $input) 
    {
        return json_encode($input);
    }
}

?>
