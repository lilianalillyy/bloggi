<?php declare(strict_types=1);

namespace App\Model\Post\Rating;

enum PostRatingKind: string
{
  case Like = "like";
  case Dislike = "dislike";
}
