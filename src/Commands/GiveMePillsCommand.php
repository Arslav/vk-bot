<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;
use Bot\Commands\Traits\CooldownTrait;
use DigitalStar\vk_api\VkApiException;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

class GiveMePillsCommand extends AbstractBaseCommand
{
    use CooldownTrait;

    /**
     * @param $data
     * @return bool
     */
    public function beforeAction($data): bool
    {
        return $this->checkCooldown($data->object->from_id);
    }

    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function action($data): void
    {
        if($pills = $this->getPillsImages()) {
            App::getVk()->sendImage($data->object->peer_id,randomSelect($pills));
        } else {
            App::getVk()->reply('Таблетки кончились');
        }
    }

    private function getPillsImages() : array
    {
        $files = [];
        try
        {
            $finder = new Finder();
            $finder->files()->in(__DIR__.'/../../images/pills');
            foreach ($finder as $file)
            {
                $files[] = $file->getPathname();
            }
        }catch (DirectoryNotFoundException $exception){
            App::getLogger()->error($exception->getMessage());
        }
        return $files;
    }
}

