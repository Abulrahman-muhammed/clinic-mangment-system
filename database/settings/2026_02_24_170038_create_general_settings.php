<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Clinic Management System');
        $this->migrator->add('general.site_email', 'clinic@gmail.com');
        $this->migrator->add('general.site_phone', '01279978123');
        $this->migrator->add('general.site_address', '123 Main St, mansoura, egypt');
        // social media links
        $this->migrator->add('general.facebook_url', 'https://facebook.com/yourpage');
        $this->migrator->add('general.twitter_url', 'https://twitter.com/yourprofile');
        $this->migrator->add('general.linkedin_url', 'https://linkedin.com/in/yourprofile');
        $this->migrator->add('general.instagram_url', 'https://instagram.com/yourprofile');
    }
};
