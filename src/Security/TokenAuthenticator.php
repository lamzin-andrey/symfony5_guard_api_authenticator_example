<?php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	* Вызывается при каждом запросе, чтобы решить, должен ли этот аутентификатор быть
	* использован для запроса. Возвращение `false` приведёт к пропуску.
	* этого аутентификатора
	*/
	public function supports(Request $request)
	{
		return $request->headers->has('X-AUTH-TOKEN');
	}

	/**
	* Вызывается при каждом запросе. Верните все учетные данные,
	* которые вы хотите передать getUser(), как $credentials.
	*/
	public function getCredentials(Request $request)
	{
		return $request->headers->get('X-AUTH-TOKEN');
	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
		if (null === $credentials) {
			// Заголовок токена был пуст, проверка подлинности не выполняется
			// с кодом состояния HTTP 401 «Не авторизован»
			return null;
		}

		// если возвращается пользователь, вызывается checkCredentials ()
		return $this->em->getRepository(User::class)
		->findOneBy(['apiToken' => $credentials])
		;
	}

	public function checkCredentials($credentials, UserInterface $user)
	{
		// Проверьте учетные данные - например, убедитесь, что пароль действителен.
		// В случае использования токена API проверка учетных данных не требуется.

		// Верните `true`, чтобы вызвать успешную аутентификацию
		return true;
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		// в случае успеха, пусть запрос продолжается
		return null;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		$data = [
		// вы можете захотеть сначала изменить или скрыть сообщение
		'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

		// или перевести это сообщение
		// $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
		];

		return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
	}

	/**
	* Вызывается, когда требуется аутентификация, но она не отправляется
	*/
	public function start(Request $request, AuthenticationException $authException = null)
	{
		$data = [
		// вы могли бы перевести это сообщение
		'message' => 'Authentication Required'
		];

		return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
	}

	public function supportsRememberMe()
	{
		return false;
	}
}