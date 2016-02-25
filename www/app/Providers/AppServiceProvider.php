<?php

namespace StartMeUp\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Serializer\DataArraySerializer;
//use League\Fractal\Serializer\JsonApiSerializerSerializer;
use League\Fractal\Serializer\SerializerAbstract;
use StartMeUp\Contracts\Repositories\AddressesContract;
use StartMeUp\Contracts\Repositories\CountriesContract;
use StartMeUp\Contracts\Repositories\LocalitiesContract;
use StartMeUp\Repositories\Eloquent\AddressesRepository;
use StartMeUp\Repositories\Eloquent\CountriesRepository;
use StartMeUp\Repositories\Eloquent\LocalitiesRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        /*
         * Dependency Injection bindings.
         */
        // Binding Contract (Interface)) to concrete class.
        $this->app->bind(AddressesContract::class, AddressesRepository::class);
        $this->app->bind(CountriesContract::class, CountriesRepository::class);
        $this->app->bind(LocalitiesContract::class, LocalitiesRepository::class);

        // Binding the abstract class SerializerAbstract to concrete class.
//        $this->app->bind(SerializerAbstract::class, JsonApiSerializer::class);
        $this->app->bind(SerializerAbstract::class, DataArraySerializer::class);
    }
}
