<?php
namespace ryunosuke\WebDebugger\Module\Doctrine\Logging;

use Doctrine\DBAL\Driver as DriverInterface;
use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use Psr\Log\LoggerInterface;

final class Driver extends AbstractDriverMiddleware
{
    private LoggerInterface $logger;

    public function __construct(DriverInterface $driver, LoggerInterface $logger)
    {
        parent::__construct($driver);

        $this->logger = $logger;
    }

    public function connect(array $params): DriverInterface\Connection
    {
        return $this->wrap(parent::connect($params));
    }

    public function wrap(DriverInterface\Connection $connection): DriverInterface\Connection
    {
        return new Connection($connection, $this->logger);
    }
}
