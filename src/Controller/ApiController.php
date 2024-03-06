<?php

namespace App\Controller;

use App\Entity\Achievement;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/api/score', name: 'get_score')]
    public function score(GameRepository $gameRepository, UserRepository $userRepository, EntityManagerInterface $entityManagerInterface, Score $score): Response
    {
        
        $entityBody = file_get_contents('php://input');
        $decoded = json_decode($entityBody);
        $game = $gameRepository->findOneByLink($decoded->link);
        $user = $userRepository->find($decoded->userid);

        if ($game === null){
            return new JsonResponse(['message' => 'Game could not be found', 400]);
        }
        if ($user === null){
            return  new JsonResponse(['message' => 'User could not be found', 400]);
        }
        if($game->getHash($user) !== $decoded->hash) {
            return new JsonResponse(['message' => 'Invalid hash'], 400);
        }

        $score = new Score();
        $score->setGame($game);
        $score->setUser($user);
        $score->setPoints($decoded->points);
        $score->setTime($decoded->time);
        $entityManagerInterface->persist($score);
        $entityManagerInterface->flush();


            return  new JsonResponse(['message' => 'Succes'], 200);
    }

    #[Route('/api/achievement', name: 'get_achievement')]
    public function achievement(GameRepository $gameRepository, UserRepository $userRepository, EntityManagerInterface $entityManagerInterface, Achievement $achievement): Response
    {
        
        $entityBody = file_get_contents('php://input');
        $decoded = json_decode($entityBody);
        $game = $gameRepository->findOneByLink($decoded->link);
        $user = $userRepository->find($decoded->userid);

        if ($game === null){
            return new JsonResponse(['message' => 'Game could not be found', 400]);
        }
        if ($user === null){
            return  new JsonResponse(['message' => 'User could not be found', 400]);
        }
        if($game->getHash($user) !== $decoded->hash) {
            return new JsonResponse(['message' => 'Invalid hash'], 400);
        }

        $achievement = new Achievement();
        $achievement->setGame($game);
        $achievement->addUser($user);
        $achievement->setAchievement($decoded->achievement);
        $achievement->setImage($decoded->image);
        $entityManagerInterface->persist($achievement);
        $entityManagerInterface->flush();


            return  new JsonResponse(['message' => 'Succes'], 200);
    }

    #[Route('/api/user', name: 'get_user')]

    public function user(UserRepository $userRepository, User $user){
       $entityBody = file_get_contents('php://input');
        $decoded = json_decode($entityBody);
        $user = $userRepository->find($decoded->userid);

        if ($user === null){
            return  new JsonResponse(['message' => 'User could not be found', 400]);
        }
        return new JsonResponse(['picture' => $user->getPicture(), 'username' => $user->getUsername()], 200);
        
    }
    
    
}
