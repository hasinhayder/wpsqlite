<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartCommand extends Command
{
  protected function configure()
  {
    $this
      ->setName('start')
      ->setDescription('Start a WordPress SQLite Site')
      ->addArgument("name", InputArgument::REQUIRED, "Site Name");
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $siteName = $input->getArgument("name");
    if(file_exists("{$siteName}.json")){
      if (PHP_OS == "WIN32" || PHP_OS == "Windows" || PHP_OS == "WINNT") {
        exec("php -S {$siteName}:80 -t {$siteName}/");
      } else {
        exec("sudo php -S {$siteName}:80 -t {$siteName}/");
      }
    }else{
      $output->writeln("This site doesn't exist");
    }
    return 1;
  }
}
