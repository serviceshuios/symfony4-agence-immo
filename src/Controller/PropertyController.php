<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController
{
/**
 *@var PropertyRepository
 */
  private $repository;

  public function __construct(PropertyRepository $repository)
  {
    $this->repository =$repository;
  }
/**
 * @Route("/biens",name="property.index")
 * @return Response
 */
  public function index(PaginatorInterface $paginator, Request $request): Response
  {

    $properties = $paginator->paginate(
      $this->repository->findAllVisibleQuery(),
      $request->query->getint('page',1),
      12
    );
    return $this->render('property/home.html.twig', [
      'current_menu' => 'properties',
      'properties' => $properties
    ]);
  }
/**
*@Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
*@param Property property
*@return Response
*/
  public function show(Property $property,string $slug): Response
  {
    if ($property->getSlug()!==$slug)
    {
      return $this->redirectToRoute('property.show',[
        'id'=> $property->getId(),
        'slug'=> $property->getSlug()
      ],301);
    }
    return $this->render("property/show.html.twig" ,[
      'property' => $property,
      'current_menu' => 'properties'
    ]);
  }
}
 ?>
