<?php

it('muestra la sección de ubicación con la clave de Google Maps', function () {
    config(['services.google_maps.key' => 'clave-de-prueba']);

    $this->get('/')
        ->assertOk()
        ->assertSee('id="ubicacion"', false)
        ->assertSee('data-key="clave-de-prueba"', false);
});

it('no rompe la landing si no hay clave de Google Maps', function () {
    config(['services.google_maps.key' => null]);

    $this->get('/')
        ->assertOk()
        ->assertSee('data-map', false)
        ->assertSee('data-map-fallback', false);
});
