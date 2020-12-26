<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ParseCurrencyService
{
    private HttpClientInterface $httpClient;

    private EntityManagerInterface $entityManager;

    private const CURRENCY_URL = 'https://www.investing.com/crypto/currencies';

    public function __construct(
        HttpClientInterface $httpClient,
        EntityManagerInterface $entityManager
    ) {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function makeRequest(): ResponseInterface
    {
        return $this
            ->httpClient
            ->request('GET', self::CURRENCY_URL);
    }

    private function getHtml(): string
    {
        return $this->makeRequest()->getContent();
    }

    public function parseCurrencies(): array
    {
        $crawler = new Crawler($this->getHtml());
        return $crawler->filter('table > tbody > tr')->each(function (Crawler $node) {
            return $node->filter('td')->each(function (Crawler $node) {
                return $node->text();
            });
        });
    }

    public function alreadyExists(string $name, string $symbol): ?object
    {
        return $this->entityManager->getRepository(Currency::class)->findOneBy([
            'name' => $name,
            'symbol' => $symbol
        ]);
    }

    public function handle(): void
    {
        foreach ($this->parseCurrencies() as $parseCurrency) {
            [, , $name, $symbol, $price] = $parseCurrency;
            $entity = $this->alreadyExists($name, $symbol);

            if (!$entity instanceof Currency) {
                $entity = new Currency();
            }
            $entity->setName($name);
            $entity->setSymbol($symbol);
            $entity->setPrice((int)$price);
            $this->entityManager->persist($entity);
        }
        $this->entityManager->flush();
    }
}
