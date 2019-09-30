<?php

namespace Dascentral\HubFlowRelease\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class StartCommand extends Command
{
    /**
     * Create a new instance of this class.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('starts');
        $this->setDescription('Create a new feature branch via HubFlow');
        $this->addArgument('name', InputArgument::OPTIONAL, 'The name of the branch to create');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $name = $this->getFeatureName($input, $output);

        $this->startFeature($name);

        $this->outputResult($name, $output);
    }

    /**
     * Identify the name of the feature branch.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return string
     */
    protected function getFeatureName($input, $output)
    {
        if (!$name = $input->getArgument('name')) {
            if (!$name = (new SymfonyStyle($input, $output))->ask('What name should we assign to the branch?')) {
                die('abort');
            }
        }

        $name = str_replace(' ', '-', $name);

        return $name;
    }

    /**
     * Output result to the user.
     *
     * @param  string $name
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function outputResult($name, $output)
    {
        $message = '<comment>' . $name . '</comment> feature branch has been created.';
        $output->write("\n" . $message . "\n\n");
    }

    /**
     * Begin the HubFlow release.
     *
     * @param  string $name
     * @return void
     */
    protected function startFeature($name)
    {
        // $process = new Process("git hf feature start $name");
        // $process->run();
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }
    }
}
