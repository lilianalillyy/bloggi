<?php declare(strict_types=1);

namespace App\Model\Post\Form\Data;

class PostCommentFormData
{

  public function __construct(
    public string $content
  )
  {
  }

}
