<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Services\SettingService;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(SettingService $settings): void
    {
        $settings->setMany('general', [
            'company_name'             => 'Pacific Tours',
            'company_email'            => 'pacifictoursvancouver@gmail.com',
            'company_phone'            => '6043581236',
            'company_address'          => '28 East 19th Avenue, Vancouver BC V5V 1H7 Canada',
            'invoice_due_days'         => 7,
            'unpaid_booking_ttl_hours' => 48,
        ], ['invoice_due_days' => 'int', 'unpaid_booking_ttl_hours' => 'int']);

        $settings->setMany('theme', [
            'currency' => 'CAD',
            'timezone' => 'America/Vancouver',
            'language' => 'en',
        ]);

        $settings->setMany('payment', [
            'stripe_enabled' => true,
            'paypal_enabled' => false,
        ], ['stripe_enabled' => 'bool', 'paypal_enabled' => 'bool']);

        $settings->setMany('social', [
            'facebook'  => 'https://facebook.com/pacifictours',
            'instagram' => 'https://instagram.com/pacifictours',
            'twitter'   => '',
            'linkedin'  => '',
            'whatsapp'  => 'https://wa.me/16043581236',
            'tripadvisor' => '',
        ]);

        $settings->setMany('seo', [
            'meta_title'       => 'Pacific Tours — Explore British Columbia in Comfort',
            'meta_description' => 'Vancouver-based sightseeing tour operator specialising in professionally operated, carrier-directed sightseeing tours throughout British Columbia.',
        ]);

        // Home page copy — everything the redesigned Blade file reads.
        $settings->setMany('home', [
            'hero_title_lead'      => 'Explore',
            'hero_title_accent'    => 'British Colombia',
            'hero_title_trail'     => 'with Pacific Tours',
            'hero_subtitle'        => 'Discover Vancouver, Whistler, Victoria and the lower Mainland in comfort aboard our premium Mercedes-Benz Sprinter',
            'hero_cta_label'       => 'Explore Packages',
            'hero_bg'              => '',          // upload path to hero photo
            'section_title'        => 'Explore British Columbia in Comfort',
            'destinations_heading' => 'Popular Destinations',
            'destinations_intro'   => 'These are professionally structured carrier-directed sightseeing tours for Pacific Tours using our premium 12-passenger Mercedes-Benz Sprinter. Explore the breathtaking beauty of British Columbia through our carefully curated local tours and sightseeing experiences.',
            'sprinter_image'       => '',          // van image next to destinations grid
            'featured_heading'     => 'Featured Tour Packages',
            'featured_intro'       => 'These are professionally structured carrier-directed sightseeing tours for Pacific Tours using our premium 12-passenger Mercedes-Benz Sprinter. Explore the breathtaking beauty of British Columbia through our carefully curated local tours and sightseeing experiences.',
            'why_heading'          => 'Why Pacific Tours Is the Best Place to Book',
            'why_intro'            => 'Book directly with British Columbia tour specialists for better value, local knowledge, and a seamless travel experience.',
            'testimonials_heading' => 'Real People Real Stories',
            'testimonials_intro'   => 'Hear from travellers who have explored British Columbia with Pacific Tours. Their genuine experiences and memorable journeys reflect the quality, comfort, and care we bring to every tour.',
            'fleet_heading'        => 'Comfortable Mercedes-Benz Sprinter transportation',
            'fleet_bg'             => '',
            'contact_heading'      => 'Contact Us',
            'contact_intro'        => 'Pacific Tours is a Vancouver-based sightseeing tour operator specialising in professionally operated carrier-directed sightseeing tours throughout British Columbia.',
            'map_embed_url'        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2604.4!2d-123.10!3d49.26!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjjCsDA2JzE1LjYiTiAxMjPCsDA1JzM3LjIiVw!5e0!3m2!1sen!2sca!4v1723600000000',
        ]);

        $settings->set('home', 'fleet_features', [
            'High Roof Design', 'Air Conditioning', 'Comfortable Seating',
            'Large Windows', 'Panoramic Views', 'Luggage Capacity',
            'Professional Maintenance', 'Modern Safety Features',
        ], 'json');
    }
}
