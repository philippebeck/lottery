<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        $allNewLotto    = ModelFactory::getModel("NewLotto")->listData();
        $allOldLotto    = ModelFactory::getModel("OldLotto")->listData();
        $allUsers       = ModelFactory::getModel("Users")->listData();

        return $this->render("back/admin.twig", [
            "allNewLotto"   => $allNewLotto,
            "allOldLotto"   => $allOldLotto,
            "allUsers"      => $allUsers
        ]);
    }
}
