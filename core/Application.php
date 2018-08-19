<?php

namespace Core;

class Application
{
    public function run()
    {
        // Загружаем классы в приложение из app
        app()->loadClasses(config()->get('app.required'));
    }
}
