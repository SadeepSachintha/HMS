<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class RoleAccessTest extends TestCase

{

    use RefreshDatabase;

    /**

     * Test matrix for role-based access.

     * 

     * [route, allowed_roles]

     */

    protected function routeMatrix()

    {

        return [

            ['dashboard', ['admin', 'manager', 'staff']],

            ['reservations.index', ['admin', 'manager', 'staff', 'guest']],

            ['customers.index', ['admin', 'manager', 'staff']],

            ['rooms.index', ['admin', 'manager', 'staff']],

            ['room-types.index', ['admin', 'manager', 'staff']],

            ['food-items.index', ['admin', 'manager', 'staff']],

            ['event-locations.index', ['admin', 'manager', 'staff']],

            ['events.index', ['admin', 'manager', 'staff']],

            ['payments.index', ['admin', 'manager', 'staff']],

            ['invoices.index', ['admin', 'manager', 'staff', 'guest']],

            ['reports.index', ['admin', 'manager']],

            ['staff.index', ['admin', 'manager', 'staff']],

            ['users.index', ['admin']],

            ['notifications.index', ['admin', 'manager', 'staff', 'guest']],

            ['alerts.index', ['admin', 'manager', 'staff', 'guest']],

            ['settings.index', ['admin']],

            ['rooms.create', ['admin', 'manager']],

            ['events.create', ['admin', 'manager']],

            ['room-types.create', ['admin', 'manager']],

            ['food-items.create', ['admin', 'manager']],

            ['event-locations.create', ['admin', 'manager']],

        ];

    }

    /**

     * @dataProvider roleProvider

     */

    public function test_role_access_to_components($role)

    {

        $user = User::factory()->create(['role' => $role]);

        $matrix = $this->routeMatrix();

        foreach ($matrix as $item) {

            $routeName = $item[0];

            $allowedRoles = $item[1];

            

            $response = $this->actingAs($user)->get(route($routeName));

            if (in_array($role, $allowedRoles)) {

                $response->assertStatus(200, "Role '{$role}' should have access to '{$routeName}'");

            } else {

                $response->assertStatus(403, "Role '{$role}' should NOT have access to '{$routeName}'");

            }

        }

    }

    public function roleProvider()

    {

        return [

            ['admin'],

            ['manager'],

            ['staff'],

            ['guest'],

        ];

    }

    /**

     * Test that guest users are redirected to login if they are not authenticated.

     */

    public function test_unauthenticated_users_are_redirected_to_login()

    {

        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));

    }

}

