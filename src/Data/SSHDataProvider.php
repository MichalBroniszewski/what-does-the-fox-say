<?php
declare(strict_types=1);

/**
 * user: michal
 * michal.broniszewski@picodi.com
 * 03.03.2020
 */

namespace CptDeceiver\Data;

use Symfony\Component\Yaml\Yaml;

/**
 * Class SSHDataProvider
 * @package CptDeceiver\Data
 */
class SSHDataProvider
{
    /**
     * @var string
     */
    private const SSH_FILE_PATH = __DIR__ . '/../../ssh.yaml';

    private $data;

    public function __construct()
    {
        $this->data = $this->getSSHData();
    }

    /**
     * @return array
     */
    public function getSSHData(): array
    {
        return Yaml::parseFile(self::SSH_FILE_PATH);
    }

    public function getEnvironments(): array
    {
        return $this->data['environment'];
    }

    public function getProjects(): array
    {
        return $this->data['project'];
    }

    public function getServers(): array
    {
        return $this->data['server'];
    }

    public function getRegions(): array
    {
        return $this->data['region'];
    }

    public function getTemplates(): array
    {
        return $this->data['command_templates'];
    }

    public function getTemplate(string $project): string
    {
        $templates = $this->getTemplates();
        return $templates[$project];
    }
}
