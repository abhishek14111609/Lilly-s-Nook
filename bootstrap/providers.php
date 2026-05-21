<?php

use Barryvdh\DomPDF\ServiceProvider as DomPdfServiceProvider;
use App\Providers\AppServiceProvider;

return [
    DomPdfServiceProvider::class,
    AppServiceProvider::class,
];
