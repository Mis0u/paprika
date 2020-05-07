<?php

namespace App\Entity;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;


class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Le mot de passe n'est pas le bon"
     * )
     */
    private $oldPassword;

    /**
     * @Assert\Length(
     *     min = 8,
     *     minMessage = "Voter mot de passe doit faire au moins {{ limit }} caractères!"
     * )
     */
    private $newPassword;

    public function getOldPassword() {
        return $this->oldPassword;
    }
 
    public function getNewPassword() {
        return $this->newPassword;
    }
 
    public function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }
 
    public function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
        return $this;
    }
}
