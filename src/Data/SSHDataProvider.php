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
    private const SSH_FILE_PATH = 'ssh.yml';

    /**
     * @return array
     */
    public function getSSHData(): array
    {
        return Yaml::parseFile(self::SSH_FILE_PATH);
    }

    public function getEnvironments(): array
    {
        $sshData = $this->getSSHData();

        return array_keys($sshData);
    }
}
