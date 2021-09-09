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
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $base_uri = 'https://office.vsk.ru/';
        $phone = '79999999999';

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

        $cookieMiner = $client->request('GET', '', [
            'cookies' => $jar
        ]);

        $postSms = $client->request('POST', 'ajax/auth/postSms/', [
            'cookies' => $jar,
//            'headers' => $headers,
            'form_params' => $form_params_number
        ]);

        $postSmsBodyString = $postSms->getBody();
        $token = json_decode($postSmsBodyString, true);

        $form_params_token = [
            'token' => $token
        ];

        $postCode = $client->request('POST', 'ajax/auth/postCode/', [
            'cookies' => $jar,
            'form_params' => $form_params_token
        ]);


        echo("Cookie status code: ".$cookieMiner->getStatusCode())."\n";
        echo("Cookie status code: ".$postSms->getStatusCode())."\n";
        echo("Cookie status code: ".$postCode->getStatusCode())."\n";


//        $file = './src/Command/data.json';
//        file_put_contents($file, json_encode($jar));
        return 0;
    }

}
