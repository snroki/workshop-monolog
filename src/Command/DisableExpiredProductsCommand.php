<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DisableExpiredProductsCommand extends Command
{
    protected static $defaultName = 'app:product:disable-expired';

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->productRepository->getExpiredProducts();

        foreach ($products as $id) {
            $this->productRepository->remove($id);
        }

        return 0;
    }
}
