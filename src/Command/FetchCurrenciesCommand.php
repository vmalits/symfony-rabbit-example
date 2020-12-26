<?php
declare(strict_types=1);

namespace App\Command;

use App\Message\FetchCurrency;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class FetchCurrenciesCommand extends Command
{
    protected static $defaultName = 'currency:fetch';

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        parent::__construct();
        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this->setDescription('Fetching currencies from Investing.com');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->messageBus->dispatch(new FetchCurrency());
        return Command::SUCCESS;
    }
}
