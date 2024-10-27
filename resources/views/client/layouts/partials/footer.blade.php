<div class="container py-4 py-lg-5 footer">
    <div class="row justify-content-center">
        <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
            <h3 class="fs-6">Nous contacter</h3>
            <ul class="list-unstyled">
                @foreach(explode(',', $page_elements['footer.contacts']->content) as $contact)
                    @if(substr($contact, 0, 1) === '0')
                        <li class="text-secondary">{{ $contact }}</li>
                    @else
                        <li><a class="link-secondary" href="mailto: {{ $contact }}">{{ $contact }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
            <h3 class="fs-6">Explorer</h3>
            <ul class="list-unstyled">
                <li><a class="link-secondary" href="{{ route('client.a-propos') }}">À propos</a></li>
                <li><a class="link-secondary" href="{{ route('client.projets') }}">Projets</a></li>
                <li><a class="link-secondary" href="{{ route('client.contact') }}">Contact</a></li>
            </ul>
        </div>
        <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
            <ul class="list-unstyled">
                <li><a class="link-secondary" data-bs-toggle="modal" data-bs-target="#pcModal">Politique de
                        confidentialité</a></li>
                <li><a class="link-secondary" data-bs-toggle="modal" data-bs-target="#cguModal">Conditions
                        d'utilisation</a></li>
                <li><a class="link-secondary" data-bs-toggle="modal" data-bs-target="#faqModal">FAQ</a></li>
            </ul>
        </div>
        <div
            class="col-lg-3 text-center text-lg-start d-flex flex-column align-items-center order-first align-items-lg-start order-lg-last item social">
            <div class="fw-bold d-flex align-items-center mb-2">
                <x-client.button add-class="btn-primary" lien="/donate" content="{{ $page_elements['footer.button']->content }}"/>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-between align-items-center pt-3">
        <p class="text-muted mb-0">© {{ $page_elements['footer.copyright']->content }}</p>
        <ul class="list-inline mb-0">
            <li class="list-inline-item">
                <a href="#" class="link-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                         viewBox="0 0 16 16" class="bi bi-facebook">
                        <path
                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"></path>
                    </svg>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="link-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                         viewBox="0 0 16 16" class="bi bi-instagram">
                        <path
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"></path>
                    </svg>
                </a>
            </li>
        </ul>
    </div>
</div>

{{-- faq modal --}}
<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalLabel">FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- FAQ Content Goes Here -->
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What is Lorem Ipsum?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Why do we use it?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- cgu modal --}}
<div class="modal fade" id="cguModal" tabindex="-1" aria-labelledby="cguModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cguModalLabel">Conditions Générales d'Utilisation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Dernière mise à jour : [Date]</p>
                <p>Bienvenue sur [Nom du site ou de l'application]. Avant d'utiliser nos services, veuillez lire
                    attentivement ces
                    Conditions Générales d'Utilisation (CGU). En accédant ou en utilisant nos services, vous acceptez
                    les présentes
                    conditions.</p><h4>1. <strong>Acceptation des conditions</strong></h4>
                <p>En accédant à ce site web ou en utilisant l’application, vous acceptez sans réserve les présentes
                    CGU. Si vous
                    n'acceptez pas ces termes, vous n'êtes pas autorisé à utiliser nos services.</p><h4>2. <strong>Accès
                        aux
                        services</strong></h4>
                <p>Nos services sont accessibles à toute personne majeure ou disposant de l’autorisation légale de ses
                    représentants
                    légaux. Nous nous réservons le droit de refuser l’accès à nos services à tout moment et sans
                    préavis, en
                    particulier en cas de non-respect des présentes CGU.</p><h4>3. <strong>Compte utilisateur</strong>
                </h4>
                <p>Pour utiliser certains de nos services, vous devrez créer un compte utilisateur. Vous êtes
                    responsable de la
                    confidentialité de vos informations de connexion et de toutes les activités effectuées via votre
                    compte. Vous
                    acceptez de nous informer immédiatement de toute utilisation non autorisée de votre compte.</p><h4>
                    4. <strong>Utilisation
                        des services</strong></h4>
                <p>Vous vous engagez à utiliser nos services conformément à la législation en vigueur et à respecter les
                    droits des
                    autres utilisateurs. Il est interdit d'utiliser les services pour :</p>
                <ul>
                    <li>Propager des contenus illégaux, diffamatoires ou haineux ;</li>
                    <li>Violer la propriété intellectuelle de tiers ;</li>
                    <li>Mener des activités frauduleuses ou abusives ;</li>
                    <li>Accéder illégalement à d'autres systèmes informatiques.</li>
                </ul>
                <h4>5. <strong>Contenu généré par l'utilisateur</strong></h4>
                <p>Vous conservez les droits de propriété intellectuelle sur tout contenu que vous publiez sur notre
                    plateforme. En
                    publiant du contenu, vous nous accordez une licence mondiale, non exclusive et gratuite pour
                    utiliser,
                    distribuer, modifier ou afficher ce contenu dans le cadre du fonctionnement de nos services.</p><h4>
                    6. <strong>Propriété
                        intellectuelle</strong></h4>
                <p>Tous les éléments présents sur le site/app (textes, images, graphismes, logos, vidéos, etc.) sont
                    protégés par
                    les droits de propriété intellectuelle et sont la propriété exclusive de [Nom de l’entreprise].
                    Toute
                    reproduction, distribution, ou modification sans notre autorisation est strictement interdite.</p>
                <h4>7.
                    <strong>Limitation de responsabilité</strong></h4>
                <p>Nous nous efforçons de maintenir les services disponibles et sécurisés, mais nous ne pouvons garantir
                    un accès
                    ininterrompu ou sans erreur. En aucun cas, nous ne saurions être tenus responsables des dommages
                    directs ou
                    indirects résultant de l'utilisation ou de l'incapacité à utiliser nos services.</p><h4>8. <strong>Modification
                        des CGU</strong></h4>
                <p>Nous nous réservons le droit de modifier les présentes CGU à tout moment. Toute modification sera
                    notifiée via
                    nos services ou par email, et prendra effet immédiatement. En continuant à utiliser nos services
                    après
                    notification, vous acceptez ces modifications.</p><h4>9. <strong>Résiliation</strong></h4>
                <p>Nous nous réservons le droit de résilier ou suspendre votre accès aux services à tout moment et sans
                    préavis, en
                    cas de violation des présentes CGU.</p><h4>10. <strong>Droit applicable</strong></h4>
                <p>Les présentes CGU sont régies et interprétées conformément aux lois en vigueur en [Nom du pays]. Tout
                    litige
                    relatif à ces conditions sera soumis à la compétence exclusive des tribunaux de [Ville ou
                    région].</p><h4>11.
                    <strong>Contact</strong></h4>
                <p>Pour toute question relative à ces CGU, vous pouvez nous contacter à l’adresse suivante : [adresse
                    email].</p>
                <hr>
                <p>Cet exemple est générique et peut être ajusté selon vos besoins. Si vous gérez une entreprise ou un
                    service
                    spécifique, il est conseillé de consulter un professionnel du droit pour rédiger des conditions
                    adaptées à vos
                    exigences et conformes à la législation locale.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- cgu modal --}}
<div class="modal fade" id="pcModal" tabindex="-1" aria-labelledby="pcModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pcModalLabel">Politique de confidentialité</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Dernière mise à jour : [Date]</p>
                <p>Chez [Nom de l'entreprise], nous accordons une grande importance à la confidentialité et à la
                    protection des
                    données personnelles de nos utilisateurs. Cette politique de confidentialité explique comment nous
                    collectons,
                    utilisons, partageons et protégeons vos informations personnelles lorsque vous utilisez nos
                    services.</p><h4>1.
                    <strong>Collecte des informations</strong></h4>
                <p>Nous collectons différents types d’informations lorsque vous utilisez nos services, notamment :</p>
                <ul>
                    <li><strong>Informations que vous fournissez directement</strong> : lors de la création d’un compte,
                        de
                        l’inscription à une newsletter, ou de l’utilisation d’un formulaire de contact (ex. nom, adresse
                        e-mail,
                        numéro de téléphone).
                    </li>
                    <li><strong>Informations collectées automatiquement</strong> : lorsque vous naviguez sur notre site
                        ou utilisez
                        notre application, nous recueillons automatiquement certaines données, telles que votre adresse
                        IP, le type
                        de navigateur, les pages visitées, et les cookies.
                    </li>
                    <li><strong>Informations issues de tiers</strong> : dans certains cas, nous pouvons recevoir des
                        informations
                        vous concernant provenant de partenaires ou de services tiers intégrés à notre plateforme.
                    </li>
                </ul>
                <h4>2. <strong>Utilisation des données</strong></h4>
                <p>Nous utilisons vos données personnelles dans les buts suivants :</p>
                <ul>
                    <li>Fournir, maintenir et améliorer nos services ;</li>
                    <li>Gérer votre compte utilisateur et répondre à vos demandes ;</li>
                    <li>Envoyer des communications marketing, si vous avez donné votre consentement ;</li>
                    <li>Analyser les comportements des utilisateurs pour améliorer l'expérience utilisateur et nos
                        offres ;
                    </li>
                    <li>Assurer la sécurité de nos services et prévenir les activités frauduleuses ou illicites.</li>
                </ul>
                <h4>3. <strong>Partage des données</strong></h4>
                <p>Nous ne vendons ni ne louons vos informations personnelles à des tiers. Cependant, nous pouvons
                    partager vos
                    données dans les situations suivantes :</p>
                <ul>
                    <li><strong>Avec des prestataires de services</strong> qui nous aident à exploiter et améliorer
                        notre plateforme
                        (par exemple, des services d'hébergement, d'analyse ou de marketing).
                    </li>
                    <li><strong>En cas de transaction commerciale</strong> (fusion, acquisition, ou vente d’actifs), vos
                        données
                        pourraient être transférées aux nouveaux propriétaires.
                    </li>
                    <li><strong>Pour se conformer à la loi</strong> ou répondre à une demande légale, comme une
                        ordonnance du
                        tribunal ou une enquête gouvernementale.
                    </li>
                </ul>
                <h4>4. <strong>Protection des données</strong></h4>
                <p>Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles appropriées pour
                    protéger vos
                    données contre toute perte, vol, utilisation abusive ou accès non autorisé. Malgré ces efforts,
                    aucune méthode
                    de transmission ou de stockage des données n'est totalement sécurisée, et nous ne pouvons garantir
                    une sécurité
                    absolue.</p><h4>5. <strong>Vos droits</strong></h4>
                <p>En vertu de la législation en vigueur (par exemple, le RGPD pour les utilisateurs européens), vous
                    disposez de
                    plusieurs droits concernant vos données personnelles :</p>
                <ul>
                    <li><strong>Droit d’accès</strong> : vous pouvez demander une copie des données personnelles que
                        nous détenons
                        sur vous.
                    </li>
                    <li><strong>Droit de rectification</strong> : vous avez le droit de corriger des informations
                        inexactes ou
                        incomplètes.
                    </li>
                    <li><strong>Droit à l’effacement</strong> : vous pouvez demander la suppression de vos données
                        personnelles.
                    </li>
                    <li><strong>Droit de limitation</strong> : vous pouvez demander la limitation du traitement de vos
                        données dans
                        certains cas.
                    </li>
                    <li><strong>Droit d’opposition</strong> : vous pouvez vous opposer au traitement de vos données à
                        des fins de
                        marketing direct.
                    </li>
                    <li><strong>Droit à la portabilité des données</strong> : vous avez le droit de recevoir vos données
                        personnelles dans un format structuré et couramment utilisé, et de les transmettre à un autre
                        responsable de
                        traitement.
                    </li>
                </ul>
                <p>Pour exercer vos droits, veuillez nous contacter à l'adresse suivante : [adresse e-mail].</p><h4>6.
                    <strong>Cookies
                        et technologies similaires</strong></h4>
                <p>Nous utilisons des cookies et d’autres technologies de suivi pour améliorer votre expérience sur
                    notre site. Vous
                    pouvez gérer vos préférences en matière de cookies via les paramètres de votre navigateur ou notre
                    bannière de
                    gestion des cookies. Pour plus d’informations, consultez notre [Politique de Cookies].</p><h4>7.
                    <strong>Conservation
                        des données</strong></h4>
                <p>Nous conservons vos données personnelles aussi longtemps que nécessaire pour fournir nos services ou
                    pour se
                    conformer aux obligations légales. Lorsque les informations ne sont plus nécessaires, nous les
                    supprimons ou les
                    anonymisons.</p><h4>8. <strong>Transfert international de données</strong></h4>
                <p>Vos données personnelles peuvent être transférées et traitées dans des pays autres que celui où vous
                    résidez.
                    Nous nous engageons à nous assurer que tout transfert de données est effectué conformément à la
                    législation en
                    vigueur et que des mesures de sécurité appropriées sont en place pour protéger vos informations.</p>
                <h4>9.
                    <strong>Modification de la politique de confidentialité</strong></h4>
                <p>Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. Toute
                    modification
                    sera publiée sur cette page et, en cas de changements significatifs, vous serez notifié par e-mail
                    ou via nos
                    services.</p><h4>10. <strong>Contact</strong></h4>
                <p>Si vous avez des questions concernant cette politique de confidentialité ou sur la manière dont nous
                    traitons vos
                    données, vous pouvez nous contacter à l’adresse suivante : [adresse e-mail].</p>
                <hr>
                <p>Cet exemple est générique et doit être adapté en fonction de la réglementation applicable (telle que
                    le RGPD, la
                    CCPA, etc.) et des pratiques spécifiques de votre entreprise. Il est conseillé de consulter un
                    professionnel du
                    droit pour garantir la conformité de votre politique de confidentialité.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
