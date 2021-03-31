<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class CategoryController
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/admin/category/create", name="category_create")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function create(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setSlug(strtolower($slugger->slug($category->getName())));

            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        $formView = $form->createView();

        return $this->render('category/create.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("/admin/category/{id}/edit", name="category_edit")
     * @param int $id
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(int $id, CategoryRepository $categoryRepository, Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
//        $this->denyAccessUnlessGranted("ROLE_ADMIN", null, "Vous n'avez le droit d'accéder à cette ressource");
//        $user = $this->getUser();
//
//        if ($user === null) {
//            return $this->redirectToRoute('security_login');
//        }
//
//        if ($this->isGranted("ROLE_ADMIN") === false) {
//            throw new AccessDeniedHttpException("Vous n'avez le droit d'accéder à cette ressource");
//        }

        $category = $categoryRepository->find($id);

        if (!$category) {
            throw new NotFoundHttpException("Cette catégorie n'existe pas");
        }

//        $user = $this->getUser();
//
//        if ($user === null) {
//            return $this->redirectToRoute('security_login');
//        }
//
//        if ($user !== $category->getOwner()) {
//            throw new AccessDeniedHttpException("Vous n'êtes pas le propriétaire de cette catégorie");
//        }

//        $security->isGranted('CAN_EDIT', $category);

//        $this->denyAccessUnlessGranted('CAN_EDIT', $category, "Vous n'êtes pas le propriétaire de cette catégorie");

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setSlug(strtolower($slugger->slug($category->getName())));

            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        $formView = $form->createView();

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'formView' => $formView
        ]);
    }

    /**
     * @return Response
     */
    public function renderMenuList(): Response
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('category/_menu.html.twig', [
            'categories' => $categories
        ]);
    }
}
