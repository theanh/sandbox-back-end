<?php
namespace AppBundle\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\User;

class HaftaFOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        if (null === $user) {
            $email = $response->getEmail();
            $facebookId = $response->getUsername();

            $user = $this->userManager->createUser();
            $user->setUsername($email);
            $user->setEmail($email);
            $user->setPlainPassword(md5(uniqid()));
            $user->setEnabled(true);
            $user->setFacebookId($facebookId);

            $this->userManager->updateUser($user);

            return $user;
        }
        // else update access token of existing user
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token

        return $user;
    }
}
