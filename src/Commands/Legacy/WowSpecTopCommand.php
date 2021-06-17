<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\BaseCommand;
use Bot\Entities\WowSpec;
use Bot\Entities\WowSpecTop;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Parameter;

class WowSpecTopCommand extends BaseCommand
{
    /**
     * @var int
     */
    public $count = 3;

    /**
     * @inheritDoc
     */
    public function run($data): void
    {
        $top = $this->getTop();
        $list = empty($top) ? $this->generateTop() : $top;
        $message = "Сегодня топ: \n";
        /** @var WowSpecTop $item */
        foreach ($list as $item) {
            $rank = $item->getRank();
            $title = $item->getSpec()->getTitle();
            $message .=  "$rank. $title\n";
        }
        App::getVk()->reply($message);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function generateTop(): array
    {
        $em = App::getEntityManager();
        $repository = $em->getRepository(WowSpec::class);
        $all_spec = $repository->findAll();
        shuffle($all_spec);
        $tops = array_slice($all_spec,0,$this->count);
        $result = [];
        for ($i = 0; $i < count($tops); $i++) {
            $wow_top_spec = new WowSpecTop();
            $wow_top_spec->setSpec($tops[$i]);
            $wow_top_spec->setRank($i+1);
            $em->persist($wow_top_spec);
            $em->flush($wow_top_spec);
            $result[] = $wow_top_spec;
        }
        return $result;
    }

    /**
     * @return array
     */
    private function getTop(): array
    {
        $repository = App::getEntityManager()->getRepository(WowSpecTop::class);
        return $repository->createQueryBuilder('w')
            ->where('w.created_at BETWEEN :start AND :end')
            ->setParameters(new ArrayCollection([
                new Parameter('start', Carbon::today()->timestamp),
                new Parameter('end', Carbon::tomorrow()->timestamp)
            ]))
            ->addOrderBy('w.rank')
            ->setMaxResults($this->count)
            ->getQuery()
            ->getResult();
    }
}