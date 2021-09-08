<?php

namespace App\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = file_get_contents('data.json');
        $jar = $file;
        $client = new Client([
        'base_uri' => 'https://office.vsk.ru',
        'cookies' => true,
        'verify' => false
    ]);

        $request = $client->request('POST', '/', [
            'cookies' => $jar,
//            'headers' => $headers,
//            'form_params' => $form_params_number
        ]);

        echo("Status Code: ".$request->getStatusCode())."\n";


//        $taskList = json_decode($file,TRUE);
//        $base_uri = 'https://office.vsk.ru/osago/ajax/calculation/update';
//        $client = $this->fclient($base_uri);

        return 0;
    }

}