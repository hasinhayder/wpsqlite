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
  const WPSQLITE_QUESTION_CONFIRMATION = 1;
  const WPSQLITE_QUESTION_INPUT = 2;
  const WPSQLITE_QUESTION_CHOICE = 3;

  private $input;
  private $output;

  protected function configure()
  {
    $this
      ->setName('install')
      ->setDescription('Install WordPress with SQLite');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $this->input = $input;
    $this->output = $output;

    $subdomain = str_replace('.wplocal.xyz', '', $this->ask('Enter SubDomain Name (*.wplocal.xyz without the .wplocal.xyz part): ', self::WPSQLITE_QUESTION_INPUT, "test"));

    if (file_exists("{$subdomain}.wplocal.xyz.json")) {
      $start = $this->ask('A WordPress site is already installed with the same subdomain. Do you want to Start it? (yes/no)', self::WPSQLITE_QUESTION_CONFIRMATION, "yes");

      if ($start == "yes") {
        exec("sudo php -S {$subdomain}.wplocal.xyz:80 -t {$subdomain}.wplocal.xyz/");
      }
      return 1;
    }

    //$phpversion = $this->ask('Select your PHP version (defaults to php7)', self::WPSQLITE_QUESTION_CHOICE, "PHP7", ['PHP7', 'PHP8', 'PHP5.6+']);
    $phpversion = (PHP_VERSION_ID>=80000)?"PHP8":"PHP7";

    $confirmation = $this->ask('This will download 15MB data from https://wordpress.org, do you want to proceed?', self::WPSQLITE_QUESTION_CONFIRMATION, "yes");
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
        unlink("./latest.zip");

        if (is_dir("wordpress")) {
          if ($phpversion == 'PHP7') {
            file_put_contents("./wordpress/wp-content/db.php", $this->file_get_contents_ssl("http://raw.githubusercontent.com/aaemnnosttv/wp-sqlite-db/master/src/db.php"));
          } else {
            file_put_contents("./wordpress/wp-content/db.php", $this->file_get_contents_ssl("http://raw.githubusercontent.com/hasinhayder/wp-sqlite-db/master/src/db.php"));
          }
          rename("./wordpress/wp-config-sample.php", "./wordpress/wp-config.php");
          if (PHP_OS == "WIN32" || PHP_OS == "Windows" || PHP_OS == "WINNT") {
            file_put_contents("./wordpress/start.bat", "php -S {$subdomain}.wplocal.xyz:80");
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

          $confirmation = $this->ask('WordPress is now ready. Do you want to start it?', self::WPSQLITE_QUESTION_CONFIRMATION, 'yes');
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

  private function ask($question, $questionType, $default = "", $options = [])
  {
    $helper = $this->getHelper('question');
    if ($questionType == self::WPSQLITE_QUESTION_INPUT) {
      $question = new Question(
        $question,
        $default
      );
    } elseif ($questionType == self::WPSQLITE_QUESTION_CONFIRMATION) {
      $question = new ChoiceQuestion(
        $question,
        ['yes', 'no'],
        $default
      );
    } elseif ($questionType == self::WPSQLITE_QUESTION_CHOICE) {
      $question = new ChoiceQuestion(
        $question,
        $options,
        $default
      );
    }
    $answer = $helper->ask($this->input, $this->output, $question);
    return $answer;
  }
}
