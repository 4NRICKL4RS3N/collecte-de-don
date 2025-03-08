@extends('admin.layouts.app')

@section('titre', 'cms | à propos')

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
                    <input value="{{ $a_propos->title}}" name="titrePage" type="text"
                           class="form-control border-black rounded-0 bg-white fs-5 mb-3"
                           id="titrePage" placeholder="Titre de la page">
                    <label for="titrePage" class="">Titre de la page</label>
                </div>
            </div>

            <fieldset class="border border-black p-3 mb-4">
                <legend class="float-none w-auto px-3">Contenu</legend>

                <div class="col-12">
                    <textarea name="apropos.titre" type="text"
                              class="form-control border-black rounded-0 bg-white fs-3 mb-3"
                              id="apropos.titre"
                              placeholder="Titre principal">{{ $a_propos_element['apropos.titre']->content }}</textarea>
                </div>

                <div class="row">
                    <div class="col-6">
                        <input type="file" class="filepondImage">
                    </div>

                    <div class="col-6" style="height: fit-content">
                        <div id="contentEditor" class="editor">
                            {!! $a_propos_element['apropos.content']->content !!}
                        </div>
                    </div>
                </div>

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

        let contentQuill = new Quill('#contentEditor', {
            theme: 'snow',
        });

        const csrfToken = '{{csrf_token()}}';
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImagePreview,
            FilePondPluginMediaPreview
        );
        let filepondImage = FilePond.create(document.querySelector('.filepondImage'), {
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

            const fileImage = filepondJumbotron.getFiles().map(file => file.serverId)[0];
            if (fileImage) {
                formData.append('apropos.image', fileImage);
            }

            formData.append('apropos.content', document.getElementById('contentEditor').querySelector('.ql-editor').innerHTML)

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
