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
     * @var array
     */
    private $lotto = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $predictions = [];

        return $this->render("back/lotto/predictLotto.twig", ["predictions" => $predictions]);
    }

    private function setLottoData()
    {
        $this->lotto["boule_1"] = $this->getPost()->getPostVar("boule_1");
        $this->lotto["boule_2"] = $this->getPost()->getPostVar("boule_2");
        $this->lotto["boule_3"] = $this->getPost()->getPostVar("boule_3");
        $this->lotto["boule_4"] = $this->getPost()->getPostVar("boule_4");
        $this->lotto["boule_5"] = $this->getPost()->getPostVar("boule_5");

        $this->lotto["seconde_boule_1"] = $this->getPost()->getPostVar("seconde_boule_1");
        $this->lotto["seconde_boule_2"] = $this->getPost()->getPostVar("seconde_boule_2");
        $this->lotto["seconde_boule_3"] = $this->getPost()->getPostVar("seconde_boule_3");
        $this->lotto["seconde_boule_4"] = $this->getPost()->getPostVar("seconde_boule_4");
        $this->lotto["seconde_boule_5"] = $this->getPost()->getPostVar("seconde_boule_5");

        $this->lotto["numero_chance"]   = $this->getPost()->getPostVar("numero_chance");
        $this->lotto["jour_de_tirage"]  = $this->getPost()->getPostVar("jour_de_tirage");
        $this->lotto["date_de_tirage"]  = $this->getPost()->getPostVar("date_de_tirage");

        $this->lotto["annee_numero_de_tirage"]  = $this->getPost()->getPostVar("annee_numero_de_tirage");
        $this->lotto["combinaison_gagnante"]    = $this->getPost()->getPostVar("combinaison_gagnante");

        $this->lotto["seconde_combinaison_gagnante"] = $this->getPost()->getPostVar("seconde_combinaison_gagnante");
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
            $this->setLottoData();

            ModelFactory::getModel("Lotto")->createData($this->lotto);
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
            $this->setLottoData();

            ModelFactory::getModel("Lotto")->updateData($this->getGet()->getGetVar("id"), $this->lotto);
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
