<?php

declare(strict_types=1);

namespace UI\Http\Web\Controller;

use App\Shared\Application\Command\CommandBusInterface;
use App\User\Application\Command\SignUp\SignUpCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use UI\Http\Web\Form\Model\SignUpModel;
use UI\Http\Web\Form\Type\SignUpType;

class SignUpController extends AbstractController
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    #[Route(path: '/signup', name: 'app_signup')]
    public function signUp(Request $request): Response
    {
        $model = new SignUpModel();
        $form = $this->createForm(SignUpType::class, $model);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();

            $command = new SignUpCommand(
                Uuid::uuid4()->toString(),
                $model->getEmail(),
                $model->getPassword(),
            );
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form,
        ]);
    }
}
