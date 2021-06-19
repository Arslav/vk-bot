<?php


namespace Bot\Commands\Cli;


use Bot\App;

class ConversationsListCommand extends Base\CliCommand
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $response = App::getVk()->request('messages.getConversations', ['count' => 200]); //TODO:
        foreach ($response['items'] as $item)
        {
            $conversation = $item['conversation'];
            $title = isset($conversation['chat_settings']) ? $conversation['chat_settings']['title'] : '-';
            $peer_id =$conversation['peer']['id'];
            $type = $conversation['peer']['type'];
            $filter = $this->args[1] ?? null;
            if($filter == '-c' && $type == 'user') continue;
            if($filter == '-u' && $type == 'chat') continue;
            echo "$type $title $peer_id".PHP_EOL;
        }
    }
}