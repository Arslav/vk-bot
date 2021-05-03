<?php


namespace Bot\Commands\Traits;

use Bot\App;
use Bot\Entities\CommandLog;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

trait CooldownTrait
{
    /**
     * @var int
     */
    protected $commandUsageCount = 5;
    /**
     * @var int
     */
    protected $usageInterval = 60*15; //60 sec * 15 min

    public function checkCooldown($user_id) : bool
    {
        $this->saveCommandUsage($user_id);
        return $this->getCommandUsageCount($user_id) < $this->commandUsageCount;
    }

    /**
     * @param $user_id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function saveCommandUsage($user_id) : void
    {
        $em = App::getEntityManager();
        $command_log = new CommandLog();
        $command_log->setCommand(static::class);
        $command_log->setUserId($user_id);
        $em->persist($command_log);
        $em->flush($command_log);
    }

    protected function getCommandUsageCount($user_id) : int
    {
        $repository = App::getEntityManager()->getRepository(CommandLog::class);
        return $repository->createQueryBuilder('l')
            ->select('count(l.id)')
            ->where('l.created_at BETWEEN :start AND :end')
            ->andWhere('l.command = :command')
            ->andWhere('l.user_id = :user_id')
            ->setParameters(new ArrayCollection([
                new Parameter('start', Carbon::now()->timestamp-$this->usageInterval),
                new Parameter('end', Carbon::now()->timestamp),
                new Parameter('user_id', $user_id),
                new Parameter('command', static::class),
            ]))
            ->getQuery()
            ->getSingleScalarResult();
    }
}