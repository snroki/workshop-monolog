<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDto
{
    /**
     * @Assert\NotBlank()
     */
    public string $name;
}
