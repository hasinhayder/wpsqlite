<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
{
  protected function configure()
  {
    $this
      ->setName('hello')
      ->setHidden(true)
      ->setDescription('Sample hello command');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln(PHP_VERSION_ID);
    $output->writeln(PHP_OS);
    if (PHP_VERSION_ID > 80000) {
      $output->writeln("PHP 8 Detected");
    }else{
      $output->writeln("PHP 5 or 7 Detected");
    }
    return 1;
  }
}
