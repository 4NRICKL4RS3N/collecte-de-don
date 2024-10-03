@extends('layouts.client')

@section('titre', 'Nous contacter')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1 class="grand-titre">Entrer en contact</h1>
                <div class="p-4 border-0 rounded-4 donation_container">
                    <form>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="name" class="mb-0 form-label">Nom</label>
                                    <input name="name" class="form-control form-input" id="name" type="text"
                                           placeholder="Nom"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="mb-0 form-label">Email</label>
                                    <input name="email" id="email" class="form-control form-input" type="text"
                                           placeholder="Email"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="numero" class="mb-0 form-label">Numéro</label>
                                    <input name="numero" id="numero" class="form-control form-input" type="text"
                                           placeholder="Numéro"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="message" class="mb-0 form-label">Message</label>
                                <textarea name="message" class="form-control textarea" id="message" rows="3"></textarea>
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
            <div class="col-md-4 ms-sm-5 ms-0 ps-lg-5 ps-md-0 ps-5 pt-5">
                <div>
                    <h5>Envoyez-nous un email</h5>
                    <i class="bi bi-envelope-fill align-middle fs-5 fw-bolder contact-icon" style="color: #DF253A;"></i>
                    <a class="text-decoration-none text-black" href="mailto:contact@gmail.com"><span
                            class="hover-underline-animation left align-middle ms-2 align-middle fs-5">contact@gmail.com</span></a>
                </div>
                <div class="mt-4">
                    <h5>Appellez-nous</h5>
                    <div>
                        <i class="bi bi-telephone-fill align-middle fs-5 fw-bolder contact-icon"
                          style="color: #DF253A;"></i>
                        <span
                            class="hover-underline-animation left align-middle ms-2 align-middle fs-5">034 12 123 12</span>
                    </div>
                    <div>
                        <i class="bi bi-telephone-fill align-middle fs-5 fw-bolder contact-icon"
                          style="color: #DF253A;"></i>
                        <span
                            class="hover-underline-animation left align-middle ms-2 align-middle fs-5">034 12 345 67</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
