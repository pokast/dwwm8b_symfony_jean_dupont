<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    
    #[Route('/admin/category/index', name: 'admin.category.index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('pages/admin/category/index.html.twig', compact('categories'));
        // return $this->render('pages/admin/category/index.html.twig', array('categories' => $categories));
        // return $this->render('pages/admin/category/index.html.twig', ['categories' => $categories]);
    }


    #[Route('/admin/category/create', name: 'admin.category.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CategoryRepository $categoryRepository): Response
    {   
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() )
        {
            $categoryRepository->save($category, true);

            $this->addFlash("success", "Cette catégorie a été ajoutée avec succès!");

            return $this->redirectToRoute("admin.category.index");
        }

        return $this->render('pages/admin/category/create.html.twig', [
            "form" => $form->createView(),
        ]);
    }


    //#[Route('/admin/category/{id<\id+>}/edit', name: 'admin.category.edit', methods: ['GET', 'POST'])]
    #[Route('/admin/category/{id<[0-9]+>}/edit', name: 'admin.category.edit', methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request, CategoryRepository $categoryRepository) : Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() )
        {
            $categoryRepository->save($category, true);

            $this->addFlash("success", "Cette catégorie a été modifiée.");

            return $this->redirectToRoute("admin.category.index");
        }

        return $this->render("pages/admin/category/edit.html.twig", [
            "form" => $form->createView()
       ]);
    }


    #[Route('/admin/category/{id<[0-9]+>}/delete', name: 'admin.category.delete', methods: ['POST'])]
    public function delete(Category $category, Request $request, CategoryRepository $categoryRepository) : Response
    {
        if ( $this->isCsrfTokenValid("category_" . $category->getId(), $request->request->get('_csrf_token')) )
        {
            $categoryRepository->remove($category, true);
            $this->addFlash("success", $category->getName() . " a été supprimé !");
        }

        return $this->redirectToRoute("admin.category.index");
    }
}
