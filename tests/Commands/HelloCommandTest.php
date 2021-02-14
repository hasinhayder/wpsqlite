<?php


use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

use App\Console\Commands\HelloCommand;

class HelloCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new HelloCommand());

        $command = $application->find('hello');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertEquals($commandTester->getDisplay(), "Hello\n");
    }
}