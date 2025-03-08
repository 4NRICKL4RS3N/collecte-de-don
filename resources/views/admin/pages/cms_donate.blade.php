@extends('admin.layouts.app')

@section('titre', 'cms | donate')

@push('scripts_head')
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
@endpush

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container border border-black p-4">
        <div class="row page">
            <div class="col-3">
                <div class="form-floating">
                    <input value="{{ $donate->title}}" name="titrePage" type="text"
                           class="form-control border-black rounded-0 bg-white fs-5 mb-3"
                           id="titrePage" placeholder="Titre de la page">
                    <label for="titrePage" class="">Titre de la page</label>
                </div>
            </div>

            <fieldset class="border border-black p-3 mb-4">
                <legend class="float-none w-auto px-3">Contenu</legend>

                <fieldset class="border-black border p-3 mb-3">
                    <legend class="float-none w-auto px-3 fs-5">Text</legend>
                    <div class="row">
                        <div class="col-6" style="height: fit-content">
                            <div id="titreEditor" class="editor">
                                {!! $donate_element['donate.titre']->content !!}
                            </div>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset class="border-black border p-3 mb-3">
                    <legend class="float-none w-auto px-3 fs-5">Choix don</legend>
                    <div class="row">
                        @php
                            $amounts = explode(',', $donate_element['donate.amounts']->content);
                        @endphp

                        @foreach($amounts as $index => $amount)
                            <div class="col-3">
                                <input name="donate.amounts[]" type="number"
                                       class="form-control border-black rounded-0 bg-white fs-3 mb-3"
                                       id="donate.amounts_{{ $index }}"
                                       value="{{ trim($amount) }}"
                                       placeholder="Nombre">
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </fieldset>
        </div>
        <button class="save-cms btn btn-success fs-4 text-white" data-micromodal-trigger="save-modal"><i class="bi bi-check-all"></i></button>
    </div>

    <div class="modal micromodal-slide" id="save-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
                <div class="modal__content" id="delete-modal-content">
                    Sauvegarder les modifications
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button class="modal__btn btn-success" id="confirm-save" aria-label="Close this dialog">Confirmer</button>
                </footer>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        MicroModal.init();

        let titreQuill = new Quill('#titreEditor', {
            theme: 'snow',
        });

        const csrfToken = '{{csrf_token()}}';
        
        function collectInputsData() {
            const formData = new FormData();

            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        if (input.checked) {
                            formData.append(input.name, input.value);
                        }
                    } else {
                        formData.append(input.name, input.value);
                    }
                }
            });
            return formData;
        }

        function saveUpdate() {
            const formData = collectInputsData();

            formData.append('donate.titre', document.getElementById('titreEditor').querySelector('.ql-editor').innerHTML);

            const donateAmounts = [];
            document.querySelectorAll('input[id^="donate.amounts_"]').forEach(input => {
                donateAmounts.push(input.value);
            });
            formData.append('donate.amounts', donateAmounts.join(','));

            fetch('{{ route('admin.cms.save') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Page mise à jour");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        document.getElementById('confirm-save').addEventListener('click', saveUpdate);

    </script>
@endpush
