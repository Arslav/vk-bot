<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;
use Bot\Entities\WhoHistory;
use Bot\Entities\WhoItem;
use Carbon\Carbon;
use DigitalStar\vk_api\VkApiException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\VarDumper\VarDumper;

class WhoAmICommand extends AbstractBaseCommand
{

    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function action($data): void
    {
        $user_id = $data->object->from_id;
        $history = $this->getHistory($user_id);
        if($history) {
            $name = $history->getName();
        } else {
            $name = $this->getRandomName();
            $this->createHistory($name, $user_id);
        }
        App::getVk()->reply("%a_fn%, ты - $name!");
    }

    protected function getRandomName()
    {
        $repository = App::getEntityManager()->getRepository(WhoItem::class);
        $genuses = $repository->createQueryBuilder('w')
            ->select('w.genus')
            ->distinct()
            ->getQuery()
            ->execute();
        if($genuses == null) throw new \Exception();

        $genus = randomSelect($genuses)['genus'];
        $nouns = $repository->findBy(['genus' => $genus, 'type' => WhoItem::TYPE_NOUN]);
        $adjectives = $repository->findBy(['genus' => $genus, 'type' => WhoItem::TYPE_ADJECTIVE]);

        if(!$nouns || !$adjectives) throw new \Exception();
        $name = randomSelect($adjectives)->getWord().' '.randomSelect($nouns)->getWord();

        return mb_strtolower($name);
    }

    /**
     * @param $user_id
     * @return WhoHistory | null
     * @throws NonUniqueResultException
     */
    private function getHistory(int $user_id) : ?WhoHistory
    {
        $repository = App::getEntityManager()->getRepository(WhoHistory::class);
        /** @var WhoHistory $history */
        $history = $repository->createQueryBuilder('h')
            ->where('h.created_at BETWEEN :start AND :end')
            ->andWhere('h.user_id = :user_id')
            ->setParameters([
                'start' => Carbon::today()->timestamp,
                'end' => Carbon::tomorrow()->timestamp,
                'user_id' => $user_id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
        return $history;
    }

    /**
     * @param string $name
     * @param int $user_id
     * @return WhoHistory | null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function createHistory(string $name, int $user_id) : ?WhoHistory
    {
        $em = App::getEntityManager();
        $history = new WhoHistory();
        $history->setName($name);
        $history->setUserId($user_id);
        $em->persist($history);
        $em->flush($history);
        return $history;
    }

}