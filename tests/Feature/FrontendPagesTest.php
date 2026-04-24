<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_frontend_pages_are_available(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('about.index'))->assertOk();
        $this->get(route('contact.index'))->assertOk();
        $this->get(route('blog.index'))->assertOk();
    }

    public function test_contact_form_can_be_submitted(): void
    {
        $response = $this->post(route('contact.index'), [
            'name' => 'Arash Test',
            'email' => 'arash@example.com',
            'phone' => '09120000000',
            'subject' => 'درخواست همکاری',
            'project_type' => 'توسعه با لاراول',
            'budget' => '۳۰ تا ۷۰ میلیون',
            'message' => 'برای توسعه و بهینه سازی سایت نیاز به همکاری دارم و اطلاعات اولیه را ارسال می کنم.',
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('success');
    }

    public function test_sitemap_is_available_as_xml(): void
    {
        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('<urlset', false);
    }
}
