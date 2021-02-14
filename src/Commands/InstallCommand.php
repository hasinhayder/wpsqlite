<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class InstallCommand extends Command
{
  protected function configure()
  {
    $this
      ->setName('install')
      ->setDescription('Install WordPress with SQLite');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {



    $helper = $this->getHelper('question');


    $question = new Question(
      'Enter SubDomain Name (*.wplocal.xyz without the .wplocal.xyz part): ',
      "test"
    );

    $subdomain = str_replace('.wplocal.xyz', '', $helper->ask($input, $output, $question));

    if (file_exists("{$subdomain}.wplocal.xyz.json")) {
      $question = new ChoiceQuestion(
        'A WordPress site is already installed with the same subdomain. Do you want to Start it?',
        // choices can also be PHP objects that implement __toString() method
        ['yes', 'no'],
        0
      );

      $start = $helper->ask($input, $output, $question);

      if ($start == "yes") {
        exec("sudo php -S {$subdomain}.wplocal.xyz:80 -t {$subdomain}.wplocal.xyz/");
      }
      return 1;
    }

    $question = new ChoiceQuestion(
      'Select your PHP version (defaults to php7)',
      // choices can also be PHP objects that implement __toString() method
      ['PHP7', 'PHP8', 'PHP5.6+'],
      0
    );

    $phpversion = $helper->ask($input, $output, $question);

    // $output->writeln($subdomain);
    // $output->writeln($phpversion);

    $question = new ChoiceQuestion(
      'Do you want to proceed now?',
      // choices can also be PHP objects that implement __toString() method
      ['yes', 'no'],
      0
    );

    $confirmation = $helper->ask($input, $output, $question);
    if ("yes" == $confirmation) {

      $output->writeln("Downloading the latest version of WordPress. Please Hold");
      $result = file_put_contents("./latest.zip", $this->file_get_contents_ssl("http://wordpress.org/latest.zip"));
      $result = true;
      if (file_exists("latest.zip")) {
        $output->writeln("Extracting the zip file");
        if (PHP_OS == "WIN32" || PHP_OS == "Windows" || PHP_OS == "WINNT") {
          exec("tar -xf ./latest.zip");
        } else if (PHP_OS == "Linux") {
          exec("unzip ./latest.zip");
        } else if (PHP_OS == "Darwin") {
          exec("tar -xf ./latest.zip");
        }
        unlink("./latest.zip")
        // exec("")
        //rename("./wordpress", "test.wplocal.xyz");
        // if (PHP_VERSION_ID < 80000) {



        if (is_dir("wordpress")) {
          if ($phpversion == 'PHP7') {
            file_put_contents("./wordpress/wp-content/db.php", $this->file_get_contents_ssl("http://raw.githubusercontent.com/aaemnnosttv/wp-sqlite-db/master/src/db.php"));
          } else {
            file_put_contents("./wordpress/wp-content/db.php", $this->file_get_contents_ssl("http://raw.githubusercontent.com/hasinhayder/wp-sqlite-db/master/src/db.php"));
          }
          rename("./wordpress/wp-config-sample.php", "./wordpress/wp-config.php");
          if (PHP_OS == "WIN32" || PHP_OS == "Windows" || PHP_OS == "WINNT") {
            file_put_contents("./wordpress/start.bat", "sudo php -S {$subdomain}.wplocal.xyz:80");
          } else {
            file_put_contents("./wordpress/start.sh", "sudo php -S {$subdomain}.wplocal.xyz:80");
          }


          rename("./wordpress", "./{$subdomain}.wplocal.xyz");
          $this->createSiteInfo($subdomain);

          $question = new ChoiceQuestion(
            'WordPress is now ready. Do you want to start it?',
            // choices can also be PHP objects that implement __toString() method
            ['yes', 'no'],
            0
          );

          $confirmation = $helper->ask($input, $output, $question);
          if ($confirmation == "yes") {
            if (PHP_OS == "WIN32" || PHP_OS == "Windows" || PHP_OS == "WINNT") {
              exec("php -S {$subdomain}.wplocal.xyz:80 -t {$subdomain}.wplocal.xyz/");
            } else {
              exec("sudo php -S {$subdomain}.wplocal.xyz:80 -t {$subdomain}.wplocal.xyz/");
            }
          }
          return 1;
        }
      }
    }
    return 1;
  }

  private function createSiteInfo($subdomain)
  {
    $data = [
      "domain" => "{$subdomain}.wplocal.xyz",
    ];

    file_put_contents("{$subdomain}.wplocal.xyz.json", json_encode($data, JSON_PRETTY_PRINT));
  }

  private function file_get_contents_ssl($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000); // 3 sec.
    curl_setopt($ch, CURLOPT_TIMEOUT, 10000); // 10 sec.
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }
}
