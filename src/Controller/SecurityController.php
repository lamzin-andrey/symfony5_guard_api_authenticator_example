<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegistrationFormType;

class SecurityController extends AbstractController
{
	/** @property User $user Объект авторизованного пользователя TODO оно нам надо? */
	private $user = null;

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

	/**
	 * @Route("/signup", name="signup")
	 * @param Request $request
	 * @param TranslatorInterface $t
	 */
	public function signup(Request $request, TranslatorInterface $t, UserPasswordEncoderInterface $encoder, MailerInterface $mailer)
	{
		$form = $this->createForm(RegistrationFormType::class, $this->user);

		if ($request->getMethod() == 'POST') {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$formData = $request->get('signupform');
				$password = $formData['password'];
				$confirmPassword = $formData['passwordRepeat'];
				if ($confirmPassword != $password) {
					$error = new FormError('Passwords is different');
					$form->get('phone')->addError($error);
				} else {
					/** @var User $user */
					$user = $form->getData();
					$user->setPassword( $encoder->encodePassword($user, $password) );
					$user->setApiToken(sha1(random_bytes(56)));
					$em = $this->getDoctrine()->getManager();
					$em->persist($user);
					$em->flush();
					$this->addFlash('success','Registration complete, you can enter on login page');
					$this->sendRegistrationEmail($formData['email'], $t, $request, $mailer);
				}
			}
		}

		return $this->render('security/signup.html.twig', [
			'form' => $form->createView()
		]);
	}

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

	/**
	 * Отправить email об окончании регистрации
	 * @param string $email
	 * @return
	 */
	private function sendRegistrationEmail(string $email, TranslatorInterface $t, Request $request, MailerInterface $mailer) : void
	{

		$emailObject = (new Email())
			->from($this->getParameter('app.admin_email'))
			->to($email)
			->priority(Email::PRIORITY_HIGH)
			->subject($t->trans('Thank for registration!'))
			->html($t->trans('Thank for registration on our project! <a href="{link}">Return to me</a>', ['{link}' => 'http://' . $request->server->get('HTTP_HOST')]))
		;
		$mailer->send($emailObject);
	}
}
