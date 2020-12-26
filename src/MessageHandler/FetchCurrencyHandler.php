<?php

namespace App\MessageHandler;

use App\Message\FetchCurrency;
use App\Services\ParseCurrencyService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class FetchCurrencyHandler implements MessageHandlerInterface
{
    private ParseCurrencyService $currencyService;

    public function __construct(ParseCurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function __invoke(FetchCurrency $message)
    {
        $this->currencyService->handle();
    }
}
