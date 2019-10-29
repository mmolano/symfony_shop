<?php 

namespace App\Controller\Admin;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;

class AdminProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * @var ObjectManager
    */
    private $em;

    public function __construct(ProductRepository $repository, ObjectManager $em)
    {
      $this->repository = $repository;
      $this->em = $em;
    }
    /**
     * @return Response
     * @Route("/admin", name="admin.product.index")
     */
    public function index()
    {
        $products = $this->repository->findAll();
        return $this->render('admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/admin/product/create", name="admin.product.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request){
      $product = new Product();
      $form = $this->createForm(ProductType::class, $product);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        $this->em->persist($product);
        $this->em->flush();
        return $this->redirectToRoute('admin.product.index');
      }
      return $this->render('admin/product/new.html.twig', [
          'product' => $product,
          'form' => $form->createView()
      ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return Response
     * @Route("/admin/product/{id}", name="admin.product.edit")
     */
    public function edit(Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $this->em->flush();
          return $this->redirectToRoute('admin.product.index');
        }
        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}