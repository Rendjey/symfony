<?php

namespace App\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\GuzzleException;
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

    /**
     * @throws GuzzleException
     */

    protected function authorization($base_uri, $phone)
    {
        $client = new Client([
            'base_uri' => $base_uri,
            'cookies' => true,
            'verify' => false
        ]);
        $jar = new CookieJar;

        $headers = [
            'Content-Type' => 'multipart/form-data;',
            'Accept' => 'application/json',
        ];

        $form_params_number = [
            'phone' => $phone
        ];

//        $form_params_token = [
//            'phone' => '6135eac28c6c5'
//        ];

        $respond = $client->request('GET', 'auth', [
            'cookies' => $jar
        ]);

        $spider_request = $client->request('POST', 'ajax/auth/postSms', [
            'cookies' => $jar,
            'headers' => $headers,
            'form_params' => $form_params_number
        ]);

//        $spider_request_code = $client->request('POST', 'ajax/auth/checkPostSms/', [
//            'cookies' => $jar,
//            'headers' => $headers,
//            'form_params' => $form_params_token
//        ]);

        echo("Status Code: ".$respond->getStatusCode())."\n";
        echo("Status Code: ".$spider_request->getStatusCode())."\n";
//        echo("Status Code: ".$spider_request_code->getStatusCode())."\n";
    }

    /**
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $base_uri = 'https://shop.vsk.ru/';
        $phone = '79951018204';

        $this->authorization($base_uri, $phone);

        return 0;
    }

}
