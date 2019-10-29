<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;


class HomeController extends AbstractController{

  /**
   * @param ProductRepository $repository
   * @return Response
   * @Route("/", name="home")
   * 
   */
  public function index(ProductRepository $repository): Response{
    $products = $repository->findBy(array(), array('price' => 'desc'));
    return $this->render('pages/home.html.twig', [
      'products' => $products
    ]);
  }

}



?>
