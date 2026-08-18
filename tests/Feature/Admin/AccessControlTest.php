<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\RoleName;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_a_customer_cannot_open_the_admin_panel(): void
    {
        $this->asCustomer();

        $this->get('/admin')->assertForbidden();
    }

    public function test_staff_roles_reach_the_dashboard(): void
    {
        foreach ([RoleName::Admin, RoleName::Manager, RoleName::SalesExecutive, RoleName::TourOperator] as $role) {
            $this->asRole($role);
            $this->get('/admin')->assertOk();
        }
    }

    public function test_a_sales_executive_cannot_touch_settings(): void
    {
        $this->asRole(RoleName::SalesExecutive);

        $this->get(route('admin.settings.edit'))->assertForbidden();
    }

    public function test_a_tour_operator_may_only_edit_their_own_tours(): void
    {
        $operator = $this->asRole(RoleName::TourOperator);

        $own   = Tour::factory()->create(['created_by' => $operator->id]);
        $other = Tour::factory()->create(['created_by' => User::factory()->create()->id]);

        $this->get(route('admin.tours.edit', $own->uuid))->assertOk();
        $this->get(route('admin.tours.edit', $other->uuid))->assertForbidden();
    }

    public function test_a_super_admin_bypasses_every_gate(): void
    {
        $this->asRole(RoleName::SuperAdmin);

        $this->get(route('admin.settings.edit'))->assertOk();
        $this->get(route('admin.reports.show', 'revenue'))->assertOk();
    }

    public function test_a_customer_cannot_read_another_customers_booking(): void
    {
        $this->asCustomer();

        $someoneElse = Booking::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->get(route('customer.bookings.show', $someoneElse->uuid))->assertForbidden();
    }
}
