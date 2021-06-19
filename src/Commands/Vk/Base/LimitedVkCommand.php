<?php


namespace Bot\Commands\Vk\Base;


use Bot\App;
use Bot\Entities\CommandLog;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Parameter;

abstract class LimitedVkCommand extends VkCommand
{
    /**
     * @var int
     */
    public $limit = 10;

    /**
     * @var int
     */
    public $interval = 300;

    /**
     * LimitedVkCommand constructor.
     * @param array $aliases
//     * @param int $limit
//     * @param int $interval
     */
    public function __construct(array $aliases)
    {
        parent::__construct($aliases);
    }

    /**
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function beforeAction(): bool
    {
        $this->saveCommandUsage();
        return $this->checkLimit();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function checkLimit() : bool
    {
        return $this->getCommandUsageCount() < $this->limit;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function saveCommandUsage() : void
    {
        $em = App::getEntityManager();
        $command_log = new CommandLog();
        $command_log->setCommand(static::class);
        $command_log->setUserId($this->from_id);
        $em->persist($command_log);
        $em->flush($command_log);
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    protected function getCommandUsageCount() : int
    {
        $repository = App::getEntityManager()->getRepository(CommandLog::class);
        return $repository->createQueryBuilder('l')
            ->select('count(l.id)')
            ->where('l.created_at BETWEEN :start AND :end')
            ->andWhere('l.command = :command')
            ->andWhere('l.user_id = :user_id')
            ->setParameters(new ArrayCollection([
                new Parameter('start', Carbon::now()->timestamp-$this->interval),
                new Parameter('end', Carbon::now()->timestamp),
                new Parameter('user_id', $this->from_id),
                new Parameter('command', static::class),
            ]))
            ->getQuery()
            ->getSingleScalarResult();
    }
}