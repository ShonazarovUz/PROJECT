<?php

use GuzzleHttp\Client;

class Bot
{
    const TOKEN = "7338988336:AAGbgVAsM50awsV0COaYBB8u1Z7AEmyHR_0";
    const API   = "https://api.telegram.org/bot";

    public Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::API . self::TOKEN . "/"]);
    }

    public function StartCommand($chatId)
    {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Hi! Welcome to my bot $chatId"
            ]
        ]);
    }
    public function AddCommand($chatId)
    {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Enter task"
            ]
        ]);
    }

    
}