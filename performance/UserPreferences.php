<?php

namespace Performance;

class UserPreferences
{
    private $locale;
    private $language;
    private $timezone;
    private $theme;
    private $subscribe_news;
    private $subscribe_messages;

    public function __construct(
        string $locale,
        string $language,
        string $timezone = 'UTC',
        string $theme = 'light',
        bool   $subscribe_news = true,
        bool   $subscribe_messages = true)
    {
        $this->locale = $locale;
        $this->language = $language;
        $this->timezone = $timezone;
        $this->theme = $theme;
        $this->subscribe_news = $subscribe_news;
        $this->subscribe_messages = $subscribe_messages;
    }
}