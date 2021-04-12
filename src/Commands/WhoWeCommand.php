<?php


namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;
use Bot\Entities\WhoHistory;
use Carbon\Carbon;
use DigitalStar\vk_api\VkApiException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

class WhoWeCommand extends AbstractBaseCommand
{
    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function action($data): void
    {
        $peer_id = $data->object->peer_id;
        $histories = App::getEntityManager()
            ->getRepository(WhoHistory::class)
            ->createQueryBuilder('h')
            ->where('h.created_at BETWEEN :start AND :end')
            ->andWhere('h.peer_id = :peer_id')
            ->setParameters(new ArrayCollection([
                new Parameter('start', Carbon::today()->timestamp),
                new Parameter('end', Carbon::tomorrow()->timestamp),
                new Parameter('peer_id', $peer_id),
            ]))
            ->getQuery()
            ->getResult();

        if(!$histories) {
            App::getVk()->reply("я не знаю");
            return;
        }

        $message = "";
        /** @var WhoHistory $history */
        foreach ($histories as $history)
        {
            $real_name = App::getVk()->getAlias($history->getUserId(), false);
            $name = $history->getName();
            $message .= "$real_name - $name \n";
        }

        App::getVk()->reply($message);

    }
}