<?php

declare(strict_types=1);

namespace App\Enums;

enum BannerType: string
{
    case HomeSlider   = 'home_slider';
    case Promotional  = 'promotional';
    case Offer        = 'offer';
    case InnerPage    = 'inner_page';
}
