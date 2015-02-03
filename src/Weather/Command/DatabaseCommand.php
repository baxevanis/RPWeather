<?php

namespace Weather\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('hello')
            ->setDescription('Say hello')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $return = $this->_downloadLatestFile();
        var_dump($return);
        $output->writeln('OK!?');
    }

    private function _downloadLatestFile()
    {
        $sourceFile = 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz';
        $sourceFile = __DIR__.'\GeoLite2-City.mmdb.gz';
        //$sourceFile = __DIR__ . '\GeoLite2-City.zip';

        echo $sourceFile;

        return $this->_unzipFile($sourceFile, __DIR__.'/db/');

        //http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz
    }

    private function _unzipFile($zipFile, $extractTo)
    {

        if(!file_exists($extractTo)) {
            mkdir($extractTo, 0777, true);
        }

        $zip = new \ZipArchive;
        $res = $zip->open($zipFile, \ZipArchive::CHECKCONS);
        if ($res === TRUE) {
            $res = $zip->extractTo($extractTo, array('GeoLite2-City.mmdb'));
            $zip->close();
            return true;
        } else {
            die('kourambies');
            return false;
        }
    }
}