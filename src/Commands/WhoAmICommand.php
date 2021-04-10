<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;
use Bot\Entities\WhoHistory;
use Bot\Entities\WhoItem;
use Carbon\Carbon;
use DigitalStar\vk_api\VkApiException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;

class WhoAmICommand extends AbstractBaseCommand
{
    /**
     * @inheritDoc
     * @param $data
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws VkApiException
     * @throws Exception
     */
    public function action($data): void
    {
        $user_id = $data->object->from_id;
        $history = $this->findTodayWhoHistory($user_id);
        if($history) {
            $name = $history->getName();
        } else {
            $name = $this->getRandomName();
            $this->saveWhoHistory($name, $user_id);
        }
        App::getVk()->reply("%a_fn%, ты - $name!");
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getRandomName() : string
    {
        $repository = App::getEntityManager()->getRepository(WhoItem::class);
        $geneses = $repository->createQueryBuilder('w')
            ->select('w.genus')
            ->distinct()
            ->getQuery()
            ->execute();
        //TODO: Придумать название исключения
        if($geneses == null) throw new Exception();

        $genus = randomSelect($geneses)['genus'];
        $nouns = $repository->findBy(['genus' => $genus, 'type' => WhoItem::TYPE_NOUN]);
        $adjectives = $repository->findBy(['genus' => $genus, 'type' => WhoItem::TYPE_ADJECTIVE]);

        if(!$nouns || !$adjectives) throw new Exception();
        $name = randomSelect($adjectives)->getWord().' '.randomSelect($nouns)->getWord();

        return mb_strtolower($name);
    }

    /**
     * @param $user_id
     * @return WhoHistory | null
     * @throws NonUniqueResultException
     */
    private function findTodayWhoHistory(int $user_id) : ?WhoHistory
    {
        return App::getEntityManager()
            ->getRepository(WhoHistory::class)
            ->createQueryBuilder('h')
            ->where('h.created_at BETWEEN :start AND :end')
            ->andWhere('h.user_id = :user_id')
            ->setParameters([
                'start' => Carbon::today()->timestamp,
                'end' => Carbon::tomorrow()->timestamp,
                'user_id' => $user_id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $name
     * @param int $user_id
     * @return WhoHistory | null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function saveWhoHistory(string $name, int $user_id) : ?WhoHistory
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