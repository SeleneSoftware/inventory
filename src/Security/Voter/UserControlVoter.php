<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserControlVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        $array = explode('|', $attribute);

        return in_array($array[0], ['store', 'category', 'product', 'location', 'admin']);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $array = explode('|', $attribute);

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Get the permissions array
        $permissions = $user->getPermissions()->getMode();

        // admin trumps all
        if ('admin' === $permissions['role']) {
            return true;
        }
        // Some pages require admin.  This checks to see if you are an admin or not.
        if ('admin' === $array[0]) {
            if ('admin' === $permissions['role']) {
                return true;
            } else {
                return false;
            }
        }

        foreach ($permissions as $key => $perm) {
            if ($key === $array[0]) {
                foreach ($perm as $k => $p) {
                    if ($k === $array[1]) {
                        return $p;
                    }
                }
            }
        }

        // ... (check conditions and return true to grant permission) ...

        return false;
    }
}
