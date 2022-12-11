<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Model\Post\Form;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\BootstrapVersion;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;

/**
 * The form for creating a comment
 */
class PostCommentFormFactory
{

  public function create(): Form
  {
    $form = new BootstrapForm();

    BootstrapForm::switchBootstrapVersion(BootstrapVersion::V5);

    $form->setAjax();

    $form->renderMode = RenderMode::VERTICAL_MODE;

    $form->addTextArea('content', 'Přidat komentář')->setRequired();

    $form->addSubmit('submit', 'Odeslat');

    return $form;
  }

}
