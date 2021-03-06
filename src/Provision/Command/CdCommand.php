<?php

namespace Aegir\Provision\Command;

use Aegir\Provision\Command;
use Aegir\Provision\Provision;
use Psy\Shell;
use Psy\Configuration;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CdCommand
 *
 * @package Aegir\Provision\Command
 */
class CdCommand extends Command
{
    const CONTEXT_REQUIRED = TRUE;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
          ->setName('cd')
          ->setDescription($this->trans('commands.cd.description'))
          ->setHelp($this->trans('commands.cd.help'))
          ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = new \Symfony\Component\Process\Process("bash");
        $process->setTty(true);
        if ($this->context->type == 'site') {
            $dir = $this->context->getProperty('root');
        }
        elseif ($this->context->type == 'server') {
            $dir = $this->context->getProperty('server_config_path');
        }

        if (getenv('SHELL')) {
            $shell = getenv('SHELL');
        }
        else {
            $shell = 'bash';
        }

        $process->setCommandLine("cd $dir && $shell");
        $process->setEnv($_SERVER);

        $messages[] = "Opening $shell shell in $dir...";
        $this->io->commentBlock($messages);

        $process->run();
    }
}
