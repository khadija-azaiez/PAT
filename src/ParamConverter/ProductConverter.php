<?php

namespace App\ParamConverter;

use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductConverter implements ParamConverterInterface
{
    /** @var ProductRepository */
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $price = $request->get('price');

        return $this->productRepository->searchbyprice($price);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getName() === 'price';
    }
}
