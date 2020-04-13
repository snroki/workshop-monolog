<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ProductDto;
use App\Repository\ProductRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct()
    {
        $this->setLogger(new NullLogger());
    }

    public function createAction(Request $request, ValidatorInterface $validator, ProductRepository $productRepository): JsonResponse
    {
        $productDto = new ProductDto();
        $productDto->name = $request->get('name', '');

        $this->logger->info('Validating create product request', ['request' => (string) $request->getContent()]);
        $errors = $validator->validate($productDto);

        if (count($errors) > 0) {
            $this->logger->error('Bad request sent to create product', ['product' => $productDto, 'errors' => $errors]);

            return new JsonResponse((string) $errors, Response::HTTP_BAD_REQUEST);
        }

        try {
            $productRepository->create($productDto);
        } catch (\Throwable $e) {
            $this->logger->error('Error when saving product in database', ['exception' => $e, 'product' => $productDto]);

            throw $e;
        }

        return new JsonResponse($productDto, Response::HTTP_CREATED);
    }
}
