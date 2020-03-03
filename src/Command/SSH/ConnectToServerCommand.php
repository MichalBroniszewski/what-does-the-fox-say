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

/**
 * Class ConnectToServerCommand
 * @package CptDeceiver\Data
 */
class ConnectToServerCommand extends Command
{
    /**
     * @var string
     */
    private const COMMAND_NAME = 'ssh:connect';

    /**
     * @var SSHDataProvider
     */
    private $dataProvider;

    /**
     * @var string
     */
    private const COMMAND_DESC = 'Connect to one of the Picodi servers via ssh';

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

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            print_r($this->dataProvider->getEnvironments());
            return 0;
        } catch (Exception $exception) {
            print_r($exception->getMessage());
            return 1;
        }
    }
}
