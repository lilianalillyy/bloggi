<?php declare(strict_types = 1);

namespace App\Model\Post\Form;

use Contributte\FormsBootstrap\BootstrapForm;

class PostFormFactory
{
    public function create(): BootstrapForm
    {
        $form = new BootstrapForm();

        $form->addText("title", "Titulek")
            ->setMaxLength(255)
            ->setRequired();

        $form->addText("perex", "Perex")
            ->setRequired();

        $form->addTextArea("content", "Obsah")
            ->setHtmlAttribute("data-iseditor")
            ->setRequired();

        $form->addSubmit("submit", "Odeslat")->setBtnClass("btn-primary mt-3");

        return $form;
    }
}