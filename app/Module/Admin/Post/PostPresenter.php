<?php declare(strict_types=1);

namespace App\Module\Admin\Post;

use App\Model\Post\Form\Data\PostFormData;
use App\Model\Post\Form\PostFormFactory;
use App\Model\Post\Grid\PostGridFactory;
use App\Model\Post\PostFacade;
use App\Module\Admin\BaseAdminPresenter;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

class PostPresenter extends BaseAdminPresenter
{
    public function __construct(
        private PostGridFactory $postGridFactory,
        private PostFormFactory $postFormFactory,
        private PostFacade $postFacade
    ) 
    {
    }

    public function createComponentPostGrid(): DataGrid
    {
        return $this->postGridFactory->create(); 
    }

    public function createComponentPostForm(): Form
    {
        $form = $this->postFormFactory->create();

        $form->onSuccess[] = function (PostFormData $data) {
            $this->postFacade->create($data);
            $this->flashMessage("Příspěvek uložen", "success");
        };

        return $form;
    }

    public function actionDelete(string $id): void
    {
        $post = $this->postFacade->remove($id);

        if (!$post) {
            $this->flashMessage("Příspěvek neexistuje.", "danger");
            $this->redirect(":default");
        }

        $this->flashMessage("Příspěvek smazán.", "success");
        $this->redirect(":default");
    }
}
