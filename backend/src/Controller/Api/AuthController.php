<?php


namespace App\Controller\Api;


use App\Entity\User;
use App\Form\UserType;
use App\Service\FormError;
use App\Service\FormErrorService;
use App\Service\UserManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractFOSRestController
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * AuthController constructor.
     *
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Register
     *
     * @param Request $request
     * @param FormErrorService $formErrorService
     * @return Response
     */
    public function register(Request $request, FormErrorService $formErrorService): Response
    {
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(UserType::class, null, ['method' => 'POST']);
        $form->submit($data);

        if (!$form->isValid()) {
            return $this->handleView(
                $this->view([
                        'errors' => $formErrorService->getFormErrors($form)
                ], 422)
            );
        }

        /** @var User $user */
        $user = $form->getData();
        $user->setRoles(['ROLE_USER']);

        return $this->handleView(
            $this->view(
                $this->userManager->createUserTokens($this->userManager->createUser($user)),
                200
            )
        );
    }
}