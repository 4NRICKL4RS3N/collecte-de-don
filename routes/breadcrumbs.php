<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\ServiceProvider as BreadcrumbsServiceProvider;

Breadcrumbs::for('admin', function ($trail) {
    $trail->push('Accueil', route('admin'));
});

Breadcrumbs::for('admin.projets', function ($trail) {
    $trail->parent('admin');
    $trail->push('Projets', route('admin.projets'));
});
Breadcrumbs::for('admin.projets.show', function ($trail, $projet) {
    $trail->parent('admin.projets');
    $trail->push($projet->title, route('admin.projets.show', $projet->id));
});

Breadcrumbs::for('admin.temoignages', function ($trail) {
    $trail->parent('admin');
    $trail->push('Témoignages', route('admin.temoignages'));
});

Breadcrumbs::for('admin.impacts', function ($trail) {
    $trail->parent('admin');
    $trail->push('Impacts', route('admin.impacts'));
});
