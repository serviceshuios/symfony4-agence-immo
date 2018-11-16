<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
  public function index(): Response
  {
    //AJOUT EN BASE DE DONNEES
    /*$property = new Property();
    $property -> setTitle("mon premier bien")
              ->setPrice(200000)
              ->setRooms(4)
              ->setBedrooms(3)
              ->setDescription("une petite description")
              ->setSurface(60)
              ->setFloor(4)
              ->setHeat(1)
              ->setCity("MontPellier")
              ->setAddress("15 boulevard Gambetta")
              ->setPostalCode("34000");

              $em = $this->getDoctrine()->getManager();
              $em->persist($property);
              $em->flush();*/
              //$property = $this->repository->findAll();
              $property = $this->repository->findAllVisible();
              dump($property);
    return $this->render('property/home.html.twig', [
      'current_menu' => 'properties'
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
