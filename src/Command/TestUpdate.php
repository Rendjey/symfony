<?php

namespace App\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestUpdate extends Command
{

    protected static $defaultName = 'app:Update';

    protected function configure(): void
    {
        $this->setDescription('Test Update.')
            ->setHelp('This Update Symfony Console command.');
    }

    protected function formData($typeFormData): array
    {
        if ($typeFormData == 1) {
            $lastName = "Алексеевич";
            $name = "Николай";
            $secondName = "Мясненко";
            $birthDate = "01-01-1990";
            $email = "example@mail.ru";
            $phone = "79998887766";
            $typeId = "7";
            $serial = "5020";
            $number = "696321";
            $dateIssue = "01-01-2010";
        }

        return [
            "lastName" => $lastName,
            "name" => $name,
            "secondName" => $secondName,
            "birthDate" => $birthDate,
            "email" => $email,
            "phone" => $phone,
            "document" => [
                "typeId" => $typeId,
                "serial" => $serial,
                "number" => $number,
                "dateIssue" => $dateIssue
            ]
        ];
    }

    protected function newClient($client, $jar) {
        return ($client->request('POST', 'lka/ajax/client', [
            'cookies' => $jar,
            'form_params' => $this->formData(1)
        ]));
    }

    protected function listClients($client, $jar) {
        return ($client->request('GET', '/lka/ajax/client?limit=30&status=1,0,-1', [
            'cookies' => $jar,
        ]));
    }

    /**
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $file = './src/Command/data.json';
//        $jar = new FileCookieJar($file);
//        $base_uri = 'https://office.vsk.ru';
//        $client = new Client([
//            'base_uri' => $base_uri,
//            'cookies' => $jar,
//            'verify' => false
//        ]);
//
//        $NewClient = $this->newClient($client, $jar);
//
//        echo("New client status code: ".$NewClient->getStatusCode())."\n";

        $client = new GuzzleHttp\Client(['base_uri' => 'http://httpbin.org']);




        return 0;
    }

}