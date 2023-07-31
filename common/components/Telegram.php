<?php

namespace common\components;

use yii\base\Component;
use yii\httpclient\Client;

class Telegram extends Component
{
    public $apiUrl;
    public $botId;
    public $chatId;

    public function sendMsg(string $msg): void
    {
        $client = new Client();
        $client->createRequest()
            ->setUrl($this->apiUrl . '/bot' . $this->botId . '/sendMessage')
            ->setMethod('POST')
            ->setData([
                'chat_id' => $this->chatId,
                'text' => $msg,
                'parse_mode' => 'html'
            ])
            ->send();
    }
}
