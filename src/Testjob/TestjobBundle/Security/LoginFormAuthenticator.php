<?php

namespace Testjob\TestjobBundle\Security;

use Testjob\TestjobBundle\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $formFactory;
    private $em;
    private $router;
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router, UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array). If you return null, authentication
     * will be skipped.
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      if ($request->request->has('_username')) {
     *          return array(
     *              'username' => $request->request->get('_username'),
     *              'password' => $request->request->get('_password'),
     *          );
     *      } else {
     *          return;
     *      }
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request)
    {

        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');

        if (!$isLoginSubmit) {
            // skip authentication
            return;
        }

        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        // Вернет ассоциативный массив с username и _password
        $data = $form->getData();

        // Устанавливаем в сессию username, дабы форма в случае ошибки и последующего повторного ввода могла
        // выставить имя пользователя в форму
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;

    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return object|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        //если вернется Null - аутентификация провалена
        $result =  $this->em->getRepository('TestjobBundle:User')
            ->findOneBy(['login' => $username]);

        return $result;
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        if ($this->passwordEncoder->isPasswordValid($user, $password) && $user->getConfirmed() && !$user->getBanned()) {
            return true;
        }
        return false;
    }

    /**
     * Return the URL to the login page.
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('testjob_login');
    }

    /**
     * The user will be redirected to the secure page they originally tried
     * to access. But if no such page exists (i.e. the user went to the
     * login page directly), this returns the URL the user should be redirected
     * to after logging in successfully (e.g. your homepage).
     *
     * @return string
     */
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('testjob_main');
    }
}