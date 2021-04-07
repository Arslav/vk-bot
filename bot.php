<?php

use DigitalStar\vk_api\vk_api;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('LOG_LEVEL', $_ENV['LOG_LEVEL']);
define('VK_API_TOKEN', $_ENV['VK_API_TOKEN']);
define('VK_API_VERSION', $_ENV['VK_API_VERSION']);
define('VK_API_CONFIRM_STRING', $_ENV['VK_API_CONFIRM_STRING']);

$log = new Logger('bot');
$log->pushHandler(new StreamHandler('app.log', LOG_LEVEL));

$vk = vk_api::create(VK_API_TOKEN, VK_API_VERSION)->setConfirm(VK_API_CONFIRM_STRING);

$data = $vk->initVars($id, $message, $payload, $user_id, $type);

$log->debug('type: '.print_r($type,true));
$log->debug('payload: '.print_r($payload,true));
$log->debug('data: '.print_r($data,true));
$log->debug('message: '.print_r($message,true));
$log->debug('user_id: '.print_r($user_id,true));
$message = mb_strtolower($message);

if($type == 'message_new') {
	$log->info('VK message_new event start');
    if($message == "слава, кто я?") {
		$log->info('Find command: "Слава, кто я?"');
        $str = who();
        $vk->reply("%a_fn%, ты - $str!");
    }
	if($message == "слава, кто слава?")
	{
		$log->info('Find command: "Слава, кто Слава?"');
		$vk->reply("НАША СЛАВА РУССКАЯ ДЕРЖАВА, ВОТ КТО НАША СЛАВА!!!!");
	}
	if($message == "слава, кто хендис?")
	{
		$log->info('Find command: "Слава, кто Хендис?"');
		$vk->reply("Вячеслав из дома Ардесов именуемый Хэндис, солнцеликий, магистр ордена рыцарей Наару, один из основателей гильдии, первый рейд лидер, хранитель устава, создатель гильдейской геральдики, лорд и защитник группы ВК и сервера Дискорд");
	}
	if($message == "ыыыы" || $message=="кря" || $data == "аыаыаыа")
	{
		$log->info('Find command: "ыыыыы"');
        $vk->reply('ыыыы');
	}
}



function who() : string
{
    $nouns_list = [
        'male' => [
            'Шизоид',
            'Император',
            'Другой квадрат',
            'Инвалид',
            'Мифик-дурик',
            'Паладин',
            'Туча',
            'Вайп на треше',
            'Айсикью',
            'Дурик',
            'Путник',
            'Флюгегехаймен',
            'Клоун',
            'Денатурал',
            'Мыш',
            'Рога-хант',
            'Гном-террорист',
        ],
        'female' => [
            'Креветка',
            'Сосалка лока',
            'Булочка',
            'Печенька в клеточку',
            'Вафелька',
            'Сися',
            'Мышь',
            'Крутила',
            'Занеш',
            'Женщина 24 лет',
            'Боешка',
            'Анима',
        ],
    ];
    $adjectives_list = [
        'male' => [
            'Ыканутый',
            'Собравший все бафы на урон и инту',
            'Уронивший',
            'Непоевший',
            'Уставший',
            'Энергичный',
            'Злой',
            'Капризный',
            'Вредный',
            'Засыпающий',
            'Денатуральный',
            'Спамящий',
            'Бесполезный',
            'Большой синий и светящийся',
            'Вумный',
            'Собравший все бафы на урон и инту',
            'Элитный',
            'Эпический',
            'Гиперультрасупер редкий',
            'Паладинистый',
            'С дебаффом от вантийки',
            'Застаканный',
            'Поевший',
            'Познавший все тайны подвала',
            'Сбежавший из подвала',
            'Вещающий из подвала',
            'Сбежавший из дурки',
        ],
        'female' => [
            'Ыканутая',
            'Собравшая все бафы на урон и инту',
            'Уронившая',
            'Непоевшая',
            'Уставшая',
            'Энергичная',
            'Злая',
            'Капризная',
            'Вредная',
            'Засыпающая',
            'Денатуральная',
            'Спамящая',
            'Бесполезная',
            'Большая синяя и светящаяся',
            'Вумная',
            'Собравшая все бафы на урон и инту',
            'Элитная',
            'Эпическая',
            'Гиперультрасупер редкая',
            'Паладинистая',
            'С дебаффом от вантийки',
            'Застаканная',
            'Поевшая',
            'Познавшая все тайны подвала',
            'Сбежавшая из подвала',
            'Вещающая из подвала',
            'Сбежавшая из дурки',
        ],
    ];

    $genders = ['male', 'female'];

    $gender = $genders[rand(1, count($genders)) - 1];

    $nouns = $nouns_list[$gender];
    $adjectives = $adjectives_list[$gender];

    $noun_id = rand(1, count($nouns)) - 1;
    $adjective_id = rand(1, count($adjectives) - 1);

    return  mb_strtolower($adjectives[$adjective_id]." ".$nouns[$noun_id]);
}
?>