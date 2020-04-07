<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ProductDto;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController
{
    public function createAction(Request $request, ValidatorInterface $validator, ProductRepository $productRepository): JsonResponse
    {
        $productDto = new ProductDto();
        $productDto->name = $request->get('name', '');

        $errors = $validator->validate($productDto);

        if (count($errors) > 0) {
            return new JsonResponse((string) $errors, Response::HTTP_BAD_REQUEST);
        }

        $productRepository->create($productDto);

        return new JsonResponse($productDto, Response::HTTP_CREATED);
    }
}
