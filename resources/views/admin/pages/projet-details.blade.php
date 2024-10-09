@extends('admin.layouts.app')

@section('titre', 'admin | projets')

@push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.css" rel="stylesheet">
@endpush

@push('scripts_head')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
@endpush

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-12">
                <h1>{{ $projet->title }}</h1>
                <span class="mb-4 badge rounded-pill text-bg-primary badge-outline-primary">{{ $projet->getStatus() }}</span>
                <div class="row">
                    <div class="col-md-4 col-auto">
                        <label class="text-body-secondary">Description</label>
                        <p>{{ $projet->description }}</p>
                    </div>
                    <div class="col-auto">
                        <label class="text-body-secondary">Lieu</label>
                        <p>{{ $projet->location }}</p>
                    </div>
                    <div class="col-auto">
                        <label class="text-body-secondary">Objectif de don</label>
                        <p>{{ number_format($projet->donation_target, 0, ',', ' ') }} Ar</p>
                    </div>
                    <div class="col-auto">
                        <label class="text-body-secondary">Don collécté</label>
                        <p>{{ number_format($projet->donation_collected, 0, ',', ' ') }} Ar</p>
                    </div>
                    <div class="col-auto">
                        <label class="text-body-secondary">Début</label>
                        <p>{{ \Carbon\Carbon::parse($projet->date_start)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="col-auto">
                        <label class="text-body-secondary">Fin</label>
                        <p>{{ \Carbon\Carbon::parse($projet->date_end)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <label class="text-body-secondary mb-1">Objectifs <span class="fw-bold">({{ count($projet->project_objectives) }})</span></label>
                <div>
                    @foreach($projet->project_objectives as $objectif)
                        <span class="px-3 py-2 fs-6 fw-medium badge badge-outline-primary rounded-pill text-bg-primary">{{ $objectif->objective }}</span>
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <label class="text-body-secondary mb-1">Images</label>
                <div class="existing-media">
                    <div id="mediaGrid" class="row">
                        @foreach($projet->project_images as $image)
                            <div class="media-item col-lg-3 col-md-12 mb-4 mb-lg-3" data-media-id="{{ $image->id }}">
                                <div class="bg-image hover-overlay ripple shadow-1-strong rounded">
                                    @if($image->type === 'image')
                                        <img class="rounded" src="{{ asset($image->url) }}" alt="{{ $image->filename }}">
                                    @else
                                        <video src="{{ asset($image->url) }}" controls></video>
                                    @endif
                                </div>
                                <button data-micromodal-trigger="delete-modal" data-delete-type="{{ $image->type }}" data-delete-url="{{ asset($image->url) }}" data-delete-id="{{ $image->id }}" class="delete-button"><i class="bi bi-x-circle-fill"></i></button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <input type="file" class="filepond" multiple>
                @csrf
                <button onclick="processUpload()" class="process-button btn btn-primary">Confirmer les ajouts</button>
            </div>
        </div>
    </div>

    <div class="modal modal-danger micromodal-slide" id="delete-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="delete-modal-title">
                        Confirmez la suppression
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <div class="modal__content" id="delete-modal-content">
                    Êtes-vous sûr de vouloir supprimer l'image ?
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button class="modal__btn btn-danger" id="confirm-delete" aria-label="Close this dialog">Confirmer
                    </button>
                </footer>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        var notyf = new Notyf({
            position: {x: 'center', y: 'top'},
        });
        // Register plugins
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImagePreview,
            FilePondPluginMediaPreview
        );

        // Get CSRF token
        const csrfToken = '{{csrf_token()}}';

        // Create FilePond instance
        const pond = FilePond.create(document.querySelector('.filepond'), {
            acceptedFileTypes: [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
                'video/mp4',
                'video/quicktime',
                'video/x-msvideo',
                'video/x-ms-wmv'
            ],
            allowMultiple: true,
            allowFileTypeValidation: true,
            fileValidateTypeLabelExpectedTypesMap: {
                'image/jpeg': '.jpg, .jpeg',
                'image/png': '.png',
                'image/gif': '.gif',
                'video/mp4': '.mp4',
                'video/quicktime': '.mov',
                'video/x-msvideo': '.avi',
                'video/x-ms-wmv': '.wmv'
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
            labelIdle: 'Glissez et déposez les fichiers ou <span class="filepond--label-action">Parcourir</span>',
            styleItemPanelAspectRatio: 0.5625, // 16:9 aspect ratio
        });

        async function processUpload() {
            const files = pond.getFiles().map(file => file.serverId);

            try {
                const response = await fetch('{{ url()->current() }}/process-upload', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        files: JSON.stringify(files)
                    })
                });

                const result = await response.json();
                pond.removeFiles();

                notyf.success('images ou vidéos ajoutées');
                location.reload();
            } catch (error) {
                notyf.error('Erreur lors du traitement des fichiers:'+error);
            }
        }

        // async function deleteMedia(mediaId) {
        //     try {
        //         const response = await fetch(`/admin/projets/media/delete/${mediaId}`, {
        //             method: 'DELETE',
        //             headers: {
        //                 'X-CSRF-TOKEN': csrfToken
        //             }
        //         });
        //
        //         if (!response.ok) {
        //             throw new Error('Delete failed');
        //         }
        //
        //         // Remove the media item from the grid
        //         const mediaItem = document.querySelector(`.media-item[data-media-id="${mediaId}"]`);
        //         if (mediaItem) {
        //             mediaItem.remove();
        //         }
        //     } catch (error) {
        //         console.error('Error deleting media:', error);
        //         alert('Failed to delete media. Please try again.');
        //     }
        // }

        MicroModal.init();
        // delete projet
        let imageIdToDelete;
        let imageUrlToDelete;
        let deleteModelContent = document.getElementById('delete-modal-content');
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                imageIdToDelete = this.getAttribute('data-delete-id');
                imageUrlToDelete = this.getAttribute('data-delete-url');
                let media = null;
                if (this.getAttribute('data-delete-type') === 'image') {
                    media = document.createElement('img');
                } else {
                    media = document.createElement('video');
                    media.controls = true;
                }
                media.src = imageUrlToDelete;
                media.classList.add('w-100');
                deleteModelContent.append(media);
            });
        });
        document.getElementById('confirm-delete').addEventListener('click', async function () {
            console.log('deleting clicked')
            try {
                const response = await fetch(`/admin/projets/media/delete/${imageIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    notyf.error('Suppression échouée');
                }

                notyf.success('Suppression effectuée');
                location.reload();
            } catch (error) {
                console.error('Error deleting media:', error);
                notyf.error('Suppression échouée');
            }
        });
    </script>
@endpush
