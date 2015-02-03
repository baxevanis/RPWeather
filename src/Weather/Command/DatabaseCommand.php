<?php

namespace Weather\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class DatabaseCommand extends ContainerAwareCommand
{
    const DOWNLOAD_URL = 'http://geolite.maxmind.com/download/geoip/database/';
    const DB_DESTINATION_DIRECTORY = '/data/';
    const FREE_DB_FILE = 'GeoLite2-City.mmdb.gz';

    protected function configure()
    {
        $this
            ->setName('hello')
            ->setDescription('Say hello')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceFile = 'GeoLite2-City.mmdb.gz';
        $output->writeln(sprintf('Start downloading %s', $sourceFile));
        $this->_downloadLatestFile($output);
        $output->writeln('<info>Unzip completed</info>');
    }

    private function _downloadLatestFile($output)
    {
        $routeDir = $this->getContainer()->get('kernel')->getRootDir();
        $destinationDirectory = $routeDir . self::DB_DESTINATION_DIRECTORY;
        $fullDestinationFile = $destinationDirectory.'GeoLite2-City.mmdb.gz';

        $fullSourceURL = self::DOWNLOAD_URL.self::FREE_DB_FILE;

        if(!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0777, true);
        }

        if (!copy($fullSourceURL, $fullDestinationFile)) {
            $output->writeln('<error>Error during file download occured</error>');
            return false;
        }

        system('gunzip -f "'.$fullDestinationFile.'"');

        return true;
    }
}