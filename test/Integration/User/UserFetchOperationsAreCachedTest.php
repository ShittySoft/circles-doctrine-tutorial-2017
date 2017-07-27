<?php

namespace Integration\User;

use Authentication\Entity\User;
use Authentication\Repository\Users;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\Cache\DefaultCacheFactory;
use Doctrine\ORM\Cache\RegionsConfiguration;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

final class UserFetchOperationsAreCachedTest extends TestCase
{
    public function test_will_cache_user_fetch_operations() : void
    {
        $logger = new DebugStack();
        $configuration = new Configuration();

        $configuration->setMetadataDriverImpl(new XmlDriver(__DIR__ . '/../../../mapping'));
        $configuration->setProxyDir(sys_get_temp_dir());
        $configuration->setProxyNamespace('ProxyExample');
        $configuration->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_ALWAYS);
        $configuration->setSQLLogger($logger);
        $configuration->setSecondLevelCacheEnabled(true);

        $userCache = new ArrayCache();

        $configuration
            ->getSecondLevelCacheConfiguration()
            ->setCacheFactory(new DefaultCacheFactory(
                new RegionsConfiguration(),
                $userCache
            ));

        $em = EntityManager::create(
            [
                'driverClass' => Driver::class,
                'memory'      => true,
            ],
            $configuration
        );

        (new SchemaTool($em))->createSchema($em->getMetadataFactory()->getAllMetadata());

        $users = new class implements Users
        {
            public function has(string $emailAddress) : bool
            {
                return false;
            }

            public function get(string $emailAddress) : User
            {
                throw new \Exception('Not implemented');
            }

            public function store(User $user) : void
            {
                throw new \Exception('Not implemented');
            }
        };

        $user = User::register('foo@example.com', 'bar', $users, function (string $password) : string { return $password; });

        $em->persist($user);

        $em->clear();

        $queriesCount = count($logger->queries);

        $em->find(User::class, 'foo@example.com');

        self::assertCount($queriesCount, $logger->queries, 'No further queries were performed during a fetch operation');
    }
}