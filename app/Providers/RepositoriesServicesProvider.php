<?php

namespace App\Providers;

use App\Repositories\BookDetailsRepository;
use App\Repositories\Interfaces\BookDetailsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServicesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BookDetailsRepositoryInterface::class, BookDetailsRepository::class);
    }
}