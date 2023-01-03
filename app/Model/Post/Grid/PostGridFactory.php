<?php declare(strict_types = 1);

namespace App\Model\Post\Grid;

use App\Model\Database\EntityManager;
use App\Model\Post\Post;
use App\UI\Grid\GridTranslator;
use Ublaboo\DataGrid\DataGrid;
use Nette\Forms\Container;
use Nette\Utils\ArrayHash;

class PostGridFactory
{
    public function __construct(
        private EntityManager $em
    ) {
    }

    public function create(): DataGrid
    {
        $grid = new DataGrid();

        $grid->setDataSource($this->em->post()->createQueryBuilder("p"), "p");

        $grid->addColumnText("id", "ID");

        $grid->addColumnText("title", "Titulek");

        $grid->addColumnText("perex", "Perex")
            ->setRenderer(fn (Post $post) => mb_strimwidth($post->getPerex(), 0, 150, '...'));

        $grid->addColumnText("content", "Obsah")
            ->setRenderer(fn (Post $post) => mb_strimwidth($post->getContent(), 0, 150, '...'));

        $grid
            ->addAction("delete", "Smazat", "delete")
            ->setClass("btn btn-sm btn-danger ajax")
            ->setIcon("trash");

        $grid->setTranslator(new GridTranslator());

        $inlineAdd = $grid->addInlineAdd();

        $inlineEdit = $grid
          ->addInlineEdit()
          ->setClass("btn btn-sm btn-secondary ajax")
          ->setText("Upravit");
    
        $onControlAdd = function (Container $container): void {
          $container->addText("title", "")->setRequired();
          $container->addText("perex", "")->setRequired();
          $container->addTextArea("content", "")
            ->setHtmlAttribute("data-iseditor", "")
            ->setRequired();
        };
    
        $inlineAdd->onControlAdd[] = $onControlAdd;
        $inlineEdit->onControlAdd[] = $onControlAdd;
    
        $inlineEdit->onSetDefaults[] = function (
          Container $container,
          Post $post
        ): void {
          $container->setDefaults($post->toArray());
        };
    
        /**
         * @var ArrayHash $values
         */
        $onSubmit = function ($id, $values = null) use ($grid) {
          /** Whether a new record is being made? */
          $create = $values === null;
    
          /**
           * During the edit, values are passed as a second argument,
           * however when creating a new entry, values are passed as the first argument.
           */
          if ($create) {
            $values = $id;
          }
    
          /**
           * If a new entry is being added, create a new entity instance,
           * otherwise find an existing one in the database.
           * 
           * @var Post $post
           */
          $post = $create
            ? new Post()
            : $this->em->post()->findOneById($id);
    
          /**
           * If the entity is not present, abort.
           */
          if (!$post) {
            $grid->flashMessage("Příspěvek neexistuje.", "error");
            return;
          }
    
          /**
           * Update the entity's data.
           */
          $post->setTitle($values->title)
            ->setPerex($values->perex)
            ->setContent($values->content);
    
          $this->em->persist($post);
          $this->em->flush($post);
    
          $grid->flashMessage("Změny uloženy", "success");
        };
    
        $inlineAdd->onSubmit[] = $onSubmit;
        $inlineEdit->onSubmit[] = $onSubmit;

        return $grid;
    }
}