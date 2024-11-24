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
                <a href="https://web.facebook.com/profile.php?id=100094975885442" target="_blank" rel="noopener noreferrer" class="link-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                         viewBox="0 0 16 16" class="bi bi-facebook">
                        <path
                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"></path>
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
                    @foreach(explode("|||", $page_elements['footer.faq']->content) as $faq)
                        <div class="accordion-item">
                            @php
                                $exploded = explode("||", $faq);
                                $question = $exploded[0];
                                $response = $exploded[1];
                            @endphp
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $loop->index }}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                 data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {{ $response }}
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                {!! $page_elements['footer.condition']->content !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- pc modal --}}
<div class="modal fade" id="pcModal" tabindex="-1" aria-labelledby="pcModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pcModalLabel">Politique de confidentialité</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! $page_elements['footer.politique']->content !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
