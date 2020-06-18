<?php
declare(strict_types=1);

/**
 * user: michal
 * michal.broniszewski@picodi.com
 * 03.03.2020
 */

namespace CptDeceiver\Command\SSH;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CptDeceiver\Data\SSHDataProvider;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class ConnectCommand
 * @package CptDeceiver\Data
 */
class ConnectCommand extends Command
{
    private const COMMAND_NAME = 'connect';
    private const COMMAND_DESC = 'Connect to one of the Picodi servers via ssh. For more info check wiki: Infrastruktura-Hostingi.';

    /**
     * @var SSHDataProvider
     */
    private $dataProvider;

    /**
     * CreatePartnerDirectories constructor.
     * @param string|null $name
     */
    public function __construct(?string $name = null)
    {
        parent::__construct($name);
        $this->dataProvider = new SSHDataProvider();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESC);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $helper = $this->getHelper('question');
            $environments = $this->dataProvider->getEnvironments();
            $question = new ChoiceQuestion(
                sprintf('Select environment (default %s)', $environments[0]),
                $environments,
                0
            );
            $question->setErrorMessage('Choose from the list or exit command.');

            $environment = $helper->ask($input, $output, $question);
            $output->writeln('You have just selected: ' . $environment);

            $projects = $this->dataProvider->getProjects();
            $question = new ChoiceQuestion(
                sprintf('Select project (default %s)', $projects[0]),
                $projects,
                0
            );
            $question->setErrorMessage('Choose from the list or exit command.');
            $project = $helper->ask($input, $output, $question);
            $output->writeln('You have just selected: ' . $project);

            $servers = $this->dataProvider->getServers();
            $question = new ChoiceQuestion(
                sprintf('Select server (default %s)', $servers[0]),
                $servers,
                0
            );
            $question->setErrorMessage('Choose from the list or exit command.');
            $server = $helper->ask($input, $output, $question);
            $output->writeln('You have just selected: ' . $server);

            $region = '';
            if ($environment === 'prod') {
                $regions = $this->dataProvider->getRegions();
                $question = new ChoiceQuestion(
                    sprintf('Select region (default %s)', $regions[0]),
                    $regions,
                    0
                );
                $question->setErrorMessage('Choose from the list or exit command.');
                $region = $helper->ask($input, $output, $question);
                $output->writeln('You have just selected: ' . $region);
            }

            $command = $this->createCommand($project, $server, $environment, $region);
            $output->writeln('Executing: ' . $command);

//            return shell_exec($command);
        } catch (Exception $exception) {
            print_r($exception->getMessage());
        }

        return 0;
    }

    private function createCommand(string $project, string $server, string $environment, string $region): string
    {
        $template = $this->dataProvider->getTemplate($project);

        return 'ssh ' . sprintf($template, $server, $environment, $region);
    }
}
