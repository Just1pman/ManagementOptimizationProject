<?php


namespace App\EventListener;


use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class DatabaseEventListener implements EventSubscriber
{
    const FILENAME = 'dbLogger.log';
    private $logsFolder;

    public function getSubscribedEvents(): array
    {
        return array(
            Events::postUpdate,
            Events::postRemove,
            Events::postPersist
        );
    }

    public function __construct($logsFolder)
    {
        $this->logsFolder = $logsFolder;
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->loggingChanges('Обновление данных в базе данных', $args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->loggingChanges('Удаление данных из базы данных', $args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->loggingChanges('Добавление данных в базу данных', $args);
    }

    public function loggingChanges($message, LifecycleEventArgs $args)
    {
        $log = new Logger('database');

        $log->pushHandler(new StreamHandler($this->logsFolder . self::FILENAME, Logger::INFO));

        $entityManager = $args->getObjectManager();
        $entity = $args->getObject();

        $log->info($message, [$entity]);
    }
}

