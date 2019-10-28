<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController{
  

  /**
   * @var ProductRepository
   */
  private $repository; 

  public function __construct(ProductRepository $repository)
  {
   $this->repository = $repository; 
  }
  
  /**
   * @Route("/products", name="product.index")
   * @return Response
   */
  public function index(): Response{
    $product = $this->repository->findAll();
    dump($product);
    return $this->render('product/index.html.twig', [
      'current_menu' => 'products'
    ]);
  }
}

?>