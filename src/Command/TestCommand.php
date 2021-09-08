<?php

namespace App\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{

    protected static $defaultName = 'app:Test';

    protected function configure() : void
    {
        $this->setDescription('Test command.')
            ->setHelp('This Test Symfony Console command.');
    }

    protected function fclient($base_uri): Client
    {
        return new Client([
            'base_uri' => $base_uri,
            'cookies' => true,
            'verify' => false
        ]);
    }

    protected function authorization($client, $phone)
    {
        $jar = new CookieJar;

        $headers = [
            'Content-Type' => 'multipart/form-data;',
            'Accept' => 'application/json',
        ];

        $form_params_number = [
            'phone' => $phone
        ];

        $respond = $client->request('GET', 'auth', [
            'cookies' => $jar
        ]);

        $spider_request = $client->request('POST', 'ajax/auth/postSms', [
            'cookies' => $jar,
            'headers' => $headers,
            'form_params' => $form_params_number
        ]);

        echo("Status Code: ".$respond->getStatusCode())."\n";
        echo("Status Code: ".$spider_request->getStatusCode())."\n";
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $base_uri = 'https://shop.vsk.ru/';
        $phone = '79951018204';

        $client = $this->fclient($base_uri);
        $this->authorization($client, $phone);

        return 0;
    }

}
