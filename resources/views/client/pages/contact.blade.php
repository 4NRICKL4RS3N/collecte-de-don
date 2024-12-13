@extends('client.layouts.app')

@section('titre', 'Nous contacter')

@push('scripts_head')
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
@endpush

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="reveal-1 col-md-8 offset-md-1 mb-3">
                <h1 class="grand-titre">Entrer en <span>contact</span></h1>
            </div>
            <div class="reveal-2 col-md-6 offset-md-3">
                <div class="p-4 border-0 rounded-4 donation_container">
                    <form>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="name" class="mb-0 form-label">Nom</label>
                                    <input name="name" class="form-control form-input" id="name" type="text"
                                           placeholder="Jean Rakoto"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="mb-0 form-label">Email</label>
                                    <input name="email" id="email" class="form-control form-input" type="text"
                                           placeholder="exemple@mail.com"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="numero" class="mb-0 form-label">Numéro</label>
                                    <input name="numero" id="numero" class="form-control form-input" type="text"
                                           placeholder="031 23 456 78"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="sujet" class="mb-0 form-label">Sujet</label>
                                    <input name="sujet" class="form-control form-input" id="sujet" type="text"
                                           placeholder="Objet de votre message"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="message" class="mb-0 form-label">Message</label>
                                <textarea name="message" placeholder="Rédigez votre message ici..." class="form-control textarea" id="message" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary mt-3">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/animateGradient.js'])
    <script>
        const option = {
            distance: '50px',
            delay: 100,
            duration: 1000
        };
        ScrollReveal().reveal('.reveal-1', option);
        const option2 = {
            distance: '50px',
            delay: 200,
            duration: 1000
        };
        ScrollReveal().reveal('.reveal-2', option2);
    </script>
@endpush
