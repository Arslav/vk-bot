<?php

namespace Bot\Commands\Vk;

use Bot\App;
use Bot\Commands\Vk\Base\VkCommand;
use Bot\Entities\WhoHistory;
use Bot\Entities\WhoItem;
use Carbon\Carbon;
use DigitalStar\vk_api\VkApiException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Parameter;
use Exception;

class WhoAmICommand extends VkCommand
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
    public function run(): void
    {
        $history = $this->findTodayWhoHistory();
        if (!$history) {
            $name = $this->getRandomName();
            $this->saveWhoHistory($name);
        } else {
            $name = $history->getName();
        }
        App::getVk()->reply("%a_fn%, ты - $name!", ['disable_mentions' => 1]);
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getRandomName(): string
    {
        $repository = App::getEntityManager()->getRepository(WhoItem::class);
        $geneses = $repository->createQueryBuilder('w')
            ->select('w.genus')
            ->distinct()
            ->getQuery()
            ->execute();
        //TODO: Придумать название исключения
        if ($geneses == null) throw new Exception();

        $genus = randomSelect($geneses)['genus'];
        $nouns = $repository->findBy(['genus' => $genus, 'type' => WhoItem::TYPE_NOUN]);
        $adjectives = $repository->findBy(['genus' => $genus, 'type' => WhoItem::TYPE_ADJECTIVE]);

        if (!$nouns || !$adjectives) throw new Exception();
        $name = randomSelect($adjectives)->getWord() . ' ' . randomSelect($nouns)->getWord();

        return mb_strtolower($name);
    }

    /**
     * @return WhoHistory | null
     * @throws NonUniqueResultException
     */
    private function findTodayWhoHistory(): ?WhoHistory
    {
        return App::getEntityManager()
            ->getRepository(WhoHistory::class)
            ->createQueryBuilder('h')
            ->where('h.created_at BETWEEN :start AND :end')
            ->andWhere('h.user_id = :user_id')
            ->andWhere('h.peer_id = :peer_id')
            ->setParameters(new ArrayCollection([
                new Parameter('start', Carbon::today()->timestamp),
                new Parameter('end', Carbon::tomorrow()->timestamp),
                new Parameter('user_id', $this->from_id),
                new Parameter('peer_id', $this->peer_id),
            ]))
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $name
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function saveWhoHistory(string $name): void
    {
        $em = App::getEntityManager();
        $history = new WhoHistory();
        $history->setName($name);
        $history->setUserId($this->from_id);
        $history->setPeerId($this->peer_id);
        $em->persist($history);
        $em->flush($history);
    }

}