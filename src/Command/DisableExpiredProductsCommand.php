<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\ProductRepository;
use Monolog\ResettableInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DisableExpiredProductsCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected static $defaultName = 'app:product:disable-expired';

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;

        $this->setLogger(new NullLogger());
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->productRepository->getExpiredProducts();

        foreach ($products as $id) {
            $this->logger->info('Removing product', ['product_id' => $id]);
            try {
                $this->productRepository->remove($id);
            } catch (\Throwable $e) {
                $this->logger->error('Cannot remove a product', [
                    'exception' => $e,
                    'product_id' => $id,
                ]);
            }

            if ($this->logger instanceof ResettableInterface) {
                $this->logger->reset();
            }
        }

        return 0;
    }
}
