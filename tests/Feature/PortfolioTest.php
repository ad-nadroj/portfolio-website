<?php

namespace Tests\Feature;

use Tests\TestCase;

class PortfolioTest extends TestCase
{
    /**
     * Test that the portfolio page loads successfully and contains onboarding overlay elements.
     */
    public function test_portfolio_page_loads_and_contains_onboarding_overlay(): void
    {
        $response = $this->get('/portfolio');

        $response->assertStatus(200);
        $response->assertSee('onboarding-overlay');
        $response->assertSee('showOnboarding');
        $response->assertSee('onboardingOverlay');
    }
}
