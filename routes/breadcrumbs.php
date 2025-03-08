<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\ServiceProvider as BreadcrumbsServiceProvider;

Breadcrumbs::for('admin', function ($trail) {
    $trail->push('Tableau de bord', route('admin'));
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

Breadcrumbs::for('admin.cms.header-footer', function ($trail) {
    $trail->parent('admin');
    $trail->push('CMS Header & Footer', route('admin.cms.header-footer'));
});
Breadcrumbs::for('admin.cms.accueil', function ($trail) {
    $trail->parent('admin');
    $trail->push('CMS Accueil', route('admin.cms.accueil'));
});
Breadcrumbs::for('admin.cms.a-propos', function ($trail) {
    $trail->parent('admin');
    $trail->push('CMS À propos', route('admin.cms.a-propos'));
});
Breadcrumbs::for('admin.cms.donate', function ($trail) {
    $trail->parent('admin');
    $trail->push('CMS Faire un don', route('admin.cms.donate'));
});
