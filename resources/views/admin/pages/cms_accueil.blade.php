@extends('admin.layouts.app')

@section('titre', 'cms | accueil')

@push('scripts_head')
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
@endpush

@push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
          rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container border border-black p-4">
        <div class="row page">
            <div class="col-3">
                <div class="form-floating">
                    <input value="{{ $accueil->title}}" name="titrePage" type="text"
                           class="form-control border-black rounded-0 bg-white fs-5 mb-3"
                           id="titrePage" placeholder="Titre de la page">
                    <label for="titrePage" class="">Titre de la page</label>
                </div>
            </div>

            <fieldset class="border border-black p-3 mb-4">
                <legend class="float-none w-auto px-3">Contenu</legend>

                <fieldset class="border-black border p-3 mb-3">
                    <legend class="float-none w-auto px-3 fs-5">Section Hero</legend>
                    <div class="row">
                        <div class="col-6">
                            <textarea name="accueil.hero.titre" type="text"
                                      class="form-control border-black rounded-0 bg-white fs-3 mb-3"
                                      id="accueil.hero.titre"
                                      placeholder="Grand titre">{{ $accueil_element['accueil.hero.titre']->content }}</textarea>
                            <div class="form-floating col-8">
                                <input value="{{ $accueil_element['accueil.hero.button']->content }}" name="accueil.hero.button" type="text" class="form-control border-0 rounded-0 bg-black text-white"
                                       id="accueil.hero.button" placeholder="button">
                                <label for="accueil.hero.button" class="text-white">Bouton</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <input type="file" class="filepondJumbotron h-100">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border-black border p-3 mb-3">
                    <legend class="float-none w-auto px-3 fs-5">Section 1</legend>
                    <div class="row">
                        <div class="col-6">
                            <textarea type="text" class="form-control border-black rounded-0 bg-white fs-5"
                                      id="accueil.section1.text" name="accueil.section1.text" placeholder="Text">{{ $accueil_element["accueil.section1.text"]->content }}</textarea>
                        </div>
                        <div class="col-6">
                            <input type="file" class="filepondSection1 h-100">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border-black border p-3 mb-3">
                    <legend class="float-none w-auto px-3 fs-5">Section 2</legend>
                    <div class="row">
                        <div class="col-6">
                            <textarea type="text" class="form-control border-black rounded-0 bg-white fs-5"
                                      id="accueil.section2.text" name="accueil.section2.text" placeholder="Text">{{ $accueil_element["accueil.section2.text"]->content }}</textarea>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border-black border p-3 mb-3">
                    <legend class="float-none w-auto px-3 fs-5">Section CTA</legend>
                    <div class="row">
                        <div class="col-6">
                            <textarea name="accueil.sectionCta.titre" type="text"
                                      class="form-control border-black rounded-0 bg-white fs-3 mb-3"
                                      id="accueil.sectionCta.titre"
                                      placeholder="Grand titre">{{ $accueil_element['accueil.sectionCta.titre']->content }}</textarea>
                            <div class="form-floating col-8">
                                <input value="{{ $accueil_element['accueil.sectionCta.button']->content }}" name="accueil.sectionCta.button" type="text" class="form-control border-0 rounded-0 bg-black text-white"
                                       id="accueil.sectionCta.button" placeholder="button">
                                <label for="accueil.sectionCta.button" class="text-white">Bouton</label>
                            </div>
                        </div>
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
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        MicroModal.init();

        const csrfToken = '{{csrf_token()}}';
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImagePreview,
            FilePondPluginMediaPreview
        );
        let filepondJumbotron = FilePond.create(document.querySelector('.filepondJumbotron'), {
            stylePanelLayout: 'compact',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',
            imagePreviewHeight: 170,
            imageCropAspectRatio: null,
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            acceptedFileTypes: [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif'
            ],
            allowMultiple: false,
            allowFileTypeValidation: true,
            fileValidateTypeLabelExpectedTypesMap: {
                'image/jpeg': '.jpg, .jpeg',
                'image/png': '.png',
                'image/gif': '.gif'
            },
            server: {
                process: {
                    url: '{{ route('upload.temp') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    onload: (response) => {
                        console.log('Upload successful:', response);
                        return response;
                    },
                    onerror: (response) => {
                        console.error('Upload error:', response);
                        return response?.error || 'Upload failed';
                    }
                },
                revert: {
                    url: '/remove-temp',
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                }
            },
            labelIdle: 'Glissez et déposez une image ou <span class="filepond--label-action">Parcourir</span>',
        });

        let filepondSection1 = FilePond.create(document.querySelector('.filepondSection1'), {
            stylePanelLayout: 'compact',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',
            imagePreviewHeight: 170,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            acceptedFileTypes: [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif'
            ],
            allowMultiple: false,
            allowFileTypeValidation: true,
            fileValidateTypeLabelExpectedTypesMap: {
                'image/jpeg': '.jpg, .jpeg',
                'image/png': '.png',
                'image/gif': '.gif'
            },
            server: {
                process: {
                    url: '{{ route('upload.temp') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    onload: (response) => {
                        console.log('Upload successful:', response);
                        return response;
                    },
                    onerror: (response) => {
                        console.error('Upload error:', response);
                        return response?.error || 'Upload failed';
                    }
                },
                revert: {
                    url: '/remove-temp',
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                }
            },
            labelIdle: 'Glissez et déposez une image ou <span class="filepond--label-action">Parcourir</span>',
        });

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

            const fileJumbotron = filepondJumbotron.getFiles().map(file => file.serverId)[0];
            if (fileJumbotron) {
                formData.append('accueil.hero.bgImage', fileJumbotron);
            }

            const fileSection1 = filepondSection1.getFiles().map(file => file.serverId)[0];
            if (fileSection1) {
                formData.append('accueil.section1.image', fileSection1);
            }

            // Send the FormData using fetch
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
