<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Widget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // System pages the footer and checkout link to; cannot be deleted.
        $pages = [
            'About Us'            => 'default',
            'Contact'             => 'contact',
            'Privacy Policy'      => 'default',
            'Terms & Conditions'  => 'default',
            'Cancellation Policy' => 'default',
            'Visa Information'    => 'visa',
            'Travel Insurance'    => 'insurance',
        ];

        foreach ($pages as $title => $template) {
            Page::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title'          => $title,
                    'template'       => $template,
                    'content'        => "<p>Replace this copy from Admin → CMS → Pages.</p>",
                    'is_system'      => true,
                    'show_in_footer' => true,
                    'status'         => 'published',
                ]
            );
        }

        foreach ([['Header Menu', 'header'], ['Footer Menu', 'footer'], ['Mega Menu', 'mega']] as [$name, $location]) {
            $menu = Menu::updateOrCreate(['location' => $location], ['name' => $name]);

            if ($location === 'header' && $menu->allItems()->count() === 0) {
                foreach ([
                    ['label' => 'Tours',        'type' => 'custom', 'url' => '/tours',        'sort_order' => 1],
                    ['label' => 'Destinations', 'type' => 'custom', 'url' => '/destinations', 'sort_order' => 2],
                    ['label' => 'Blog',         'type' => 'blog',   'url' => '/blog',         'sort_order' => 3],
                    ['label' => 'Contact',      'type' => 'page',   'url' => '/page/contact', 'sort_order' => 4],
                ] as $item) {
                    $menu->allItems()->create($item);
                }
            }
        }

        foreach ([
            ['area' => 'footer_1', 'type' => 'text',      'title' => 'Pacific Tours Canada'],
            ['area' => 'footer_2', 'type' => 'links',     'title' => 'Company'],
            ['area' => 'footer_3', 'type' => 'contact',   'title' => 'Talk to us'],
            ['area' => 'footer_4', 'type' => 'newsletter','title' => 'Trip ideas by email'],
        ] as $widget) {
            Widget::updateOrCreate(['area' => $widget['area']], $widget + ['content' => []]);
        }

        foreach ([
            ['category' => 'booking', 'question' => 'When is the balance due?',        'answer' => 'The balance is due 7 days before departure unless the tour page says otherwise.'],
            ['category' => 'booking', 'question' => 'Can I change my travel date?',    'answer' => 'Date changes are free up to 14 days before departure, subject to availability.'],
            ['category' => 'payment', 'question' => 'Which cards do you accept?',      'answer' => 'All major credit and debit cards through Stripe, plus PayPal where enabled.'],
            ['category' => 'visa',    'question' => 'Do I need a visa for Canada?',    'answer' => 'Most visitors need an eTA or a visitor visa. Check the Visa Information page for details.'],
        ] as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
