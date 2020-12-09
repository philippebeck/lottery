<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class LottoController
 * @package App\Controller
 */
class LottoController extends MainController
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

        $predictions = [];

        return $this->render("back/lotto/predictLotto.twig", ["predictions" => $predictions]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            ModelFactory::getModel("Lotto")->createData($this->getPost()->getPostArray());
            $this->getSession()->createAlert("New lotto created successfully !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/lotto/createLotto.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            ModelFactory::getModel("Lotto")->updateData($this->getGet()->getGetVar("id"), $this->getPost()->getPostArray());
            $this->getSession()->createAlert("Successful modification of the selected lotto !", "blue");

            $this->redirect("admin");
        }

        $lotto = ModelFactory::getModel("Lotto")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/lotto/updateLotto.twig", ["lotto" => $lotto]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Lotto")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Lotto actually deleted !", "red");

        $this->redirect("admin");
    }
}
