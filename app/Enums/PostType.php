<?php

declare(strict_types=1);

namespace App\Enums;

enum PostType: string
{
    case Blog = 'blog';
    case News = 'news';
}
