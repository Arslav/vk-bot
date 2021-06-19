<?php


namespace Bot\Commands\Cli;


use Bot\App;
use Bot\Commands\Cli\Base\CliCommand;
use Carbon\Carbon;
use DigitalStar\vk_api\VkApiException;

class CheckBirthdayCommand extends CliCommand
{
    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function run()
    {
        foreach ($this->getPeerIds() as $peer_id) {
            $response = App::getVk()->request('messages.getConversationMembers', [
                'peer_id' => $peer_id,
                'fields' => 'bdate'
            ]);
            foreach ($response['profiles'] as $profile) {
                $date = isset($profile['bdate']) ? $this->parseVkBirthday($profile['bdate']) : null;
                if($date == Carbon::today()){
                    $first_name = $profile['first_name'];
                    $last_name = $profile['last_name'];
                    $id = $profile['id'];
                    $message = "Сегодня у пользователя @$id($first_name $last_name) день рождения! Поздравляем!";
                    App::getVk()->sendMessage($peer_id, $message);
                }

            }
        }
    }

    private function parseVkBirthday(string $date_str) : Carbon
    {
        preg_match('/(?<day>\d*).(?<month>\d*)(.(?<year>\d*))?/', $date_str, $date_arr);
        $date = Carbon::today();
        $date->setDay($date_arr['day']);
        $date->setMonth($date_arr['month']);
        return $date;
    }

    private function getPeerIds() : array
    {
        $response = App::getVk()->request('messages.getConversations');
        $peer_ids = [];
        foreach ($response['items'] as $item)
        {
            $conversation = $item['conversation'];
            $type = $conversation['peer']['type'];
            if($type == 'chat') $peer_ids[] = $conversation['peer']['id'];
        }
        return $peer_ids;
    }
}