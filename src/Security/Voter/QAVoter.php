<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class QAVoter extends Voter
{
    /** @var Security $security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['QA_EDIT', 'QA_OWNER']);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'QA_EDIT':
                return $this->canView($subject, $user);
                break;
            case 'QA_OWNER':
                return $this->isOwner($subject, $user);
                break;
        }

        return false;
    }

    private function canView($qa, User $user)
    {
        return $this->isOwner($qa, $user)
            || $this->security->isGranted('ROLE_MODERATOR');
    }

    private function isOwner($qa, User $user)
    {
        return $user === $qa->getUser();
    }
}
