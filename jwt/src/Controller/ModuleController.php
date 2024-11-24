<?php
// src/Controller/ModuleController.php

namespace App\Controller;

use App\Entity\Module;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/api/modules', name: 'get_modules', methods: ['GET'])]
    public function index(ModuleRepository $moduleRepository): JsonResponse
    {

        $modules = $moduleRepository->createQueryBuilder('m')
            ->select('m.id, m.title')
            ->getQuery()
            ->getResult();

        return $this->json($modules);
    }

    #[Route('/api/modules', name: 'create_module', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $data = json_decode($request->getContent(), true);


        if (empty($data['title']) || empty($data['description'])) {
            return $this->json(['message' => 'Title and description are required.'], Response::HTTP_BAD_REQUEST);
        }

        $module = new Module();
        $module->setTitle($data['title']);
        $module->setDescription($data['description']);
        $module->setCreatedAt(new \DateTimeImmutable()); 

        error_log('Module created: ' . $module->getTitle() . ' - ' . $module->getDescription());

        $entityManager->persist($module);
        try {
            $entityManager->flush();
        } catch (\Exception $e) {
            error_log('Error persisting module: ' . $e->getMessage());
            return $this->json(['message' => 'Error creating module.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return $this->json([
            'message' => 'Module created successfully',
            'module' => [
                'title' => $module->getTitle(),
                'description' => $module->getDescription(),
                'createdAt' => $module->getCreatedAt()->format('Y-m-d H:i:s'),
            ]
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/modules/{id}', name: 'get_module_details', methods: ['GET'])]
    public function getModuleDetails(int $id, ModuleRepository $moduleRepository): JsonResponse
    {

        $module = $moduleRepository->find($id);

        if (!$module) {
            return $this->json(['error' => 'Module not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $module->getId(),
            'title' => $module->getTitle(),
            'description' => $module->getDescription(),
            'createdAt' => $module->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
