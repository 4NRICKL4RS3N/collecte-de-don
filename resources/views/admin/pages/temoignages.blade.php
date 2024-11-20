@extends('admin.layouts.app')

@section('titre', 'admin | projets')

@push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
          rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.css"
          rel="stylesheet">
    @vite(['resources/sass/admin/pages/temoignages.scss'])
@endpush

@push('scripts_head')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 col-lg-6">
                <h1>Créer un nouveau témoignage</h1>

                <form id="temoignage-form" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="testifier_name">Auteur du témoignage</label>
                        <input type="text" name="testifier_name" id="testifier_name" class="form-control">
                    </div>

                    <div class="form-group mb-2">
                        <label for="statement">Déclaration</label>
                        <textarea name="statement" id="statement" class="form-control"></textarea>
                    </div>

                    <div class="form-group w-50">
                        <label for="image-temoignage-form">Image</label>
                        <input id="image-temoignage-form" type="file" class="filepond">
                    </div>

                    <div class="form-group">
                        <button id="submit-project" type="submit" class="mt-3 btn btn-primary">Créer le témoignage
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <h1>Liste des témoignages</h1>
                <table id="temoignagesTable" class="display">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Auteur</th>
                        <th>Déclaration</th>
                        <th>Image</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($testimonies as $testimony)
                        <tr>
                            <td>{{ $testimony->id }}</td>
                            <td>{{ $testimony->testifier_name }}</td>
                            <td>{{ $testimony->statement }}</td>
                            <td><img style="max-width: 100px" class="h-auto text-center" src="{{ asset($testimony->image_url) }}"></td>
                            <td class="text-end">
                                <button class="btn btn-primary update-btn modify-btn"
                                        data-micromodal-trigger="update-modal"
                                        update-data-id="{{ $testimony->id }}"
                                        update-data-testifier_name="{{ $testimony->testifier_name }}"
                                        update-data-statement="{{ $testimony->statement }}"
                                        update-data-image_url="{{ $testimony->image_url }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger delete-btn text-white"
                                        data-micromodal-trigger="delete-modal"
                                        delete-data-id="{{ $testimony->id }}"
                                        delete-data-testifier_name="{{ $testimony->testifier_name }}">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal modal-danger micromodal-slide" id="update-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="update-modal-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="update-modal-title">
                        Modifiez le témoignage
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <div class="modal__content" id="update-modal-content">
                    <form id="update-temoignage-form" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="update-testifier_name">Auteur du témoignage</label>
                            <input type="text" name="testifier_name" id="update-testifier_name" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label for="update-statement">Déclaration</label>
                            <textarea name="statement" id="update-statement" class="form-control"></textarea>
                        </div>

                        <img src="" class="my-2 w-100 rounded" id="update-image_url">

                        <div class="form-group w-100">
                            <label for="update-image-temoignage-form">Image</label>
                            <input id="update-image-temoignage-form" type="file" class="filepondUpdate">
                        </div>
                    </form>
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button type="submit" form="update-temoignage-form" class="modal__btn btn-danger" id="confirm-update" aria-label="Close this dialog">Modifier
                    </button>
                </footer>
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
                    Êtes-vous sûr de vouloir supprimer le témoignage de <span class="fw-bolder" id="delete-data-testifier-display"></span>
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
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        const csrfToken = '{{csrf_token()}}';
        var notyf = new Notyf({
            position: {x: 'center', y: 'top'},
        });
        MicroModal.init();

        {{-- image update --}}
        const pondUpdate = FilePond.create(document.querySelector('.filepondUpdate'), {
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
            styleItemPanelAspectRatio: 0.5625 // 16:9 aspect ratio
        });


        {{-- process update --}}
        let temoignageIdToUpdate;
        const inputTestifierNameToUpdate = document.getElementById('update-testifier_name');
        const inputStatementToUpdate = document.getElementById('update-statement');
        const imageTestimony = document.getElementById('update-image_url')
        document.querySelectorAll('.update-btn').forEach(button => {
            button.addEventListener('click', function () {
                temoignageIdToUpdate = this.getAttribute('update-data-id');
                inputTestifierNameToUpdate.value = this.getAttribute('update-data-testifier_name');
                inputStatementToUpdate.value = this.getAttribute('update-data-statement');
                imageTestimony.src = this.getAttribute('update-data-image_url');
                console.log(this.getAttribute('update-data-testifier_name'));
            });
        });
        document.getElementById('update-temoignage-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const files = pondUpdate.getFiles();
            if (files.length > 0 && files[0].serverId) {
                const file = files[0].serverId;
                formData.append('image', file);
            }
            formData.append('_method', 'PATCH');
            fetch(`/admin/temoignages/update/${temoignageIdToUpdate}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notyf.success('Témoignage modifié');
                        console.log(data.data)
                        location.reload();
                    } else {
                        console.error('Error:', data.error);
                        notyf.error('Témoignage non modifié: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notyf.error('Témoignage non modifié: ' + error);
                });
        });

        {{-- process delete --}}
        let temoignageIdToDelete;
        let auteurNameToDelete;
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                temoignageIdToDelete = this.getAttribute('delete-data-id');
                auteurNameToDelete = this.getAttribute('delete-data-testifier_name');
                document.getElementById('delete-data-testifier-display').textContent = auteurNameToDelete;
            });
        });
        document.getElementById('confirm-delete').addEventListener('click', function () {
            if (temoignageIdToDelete) {
                console.log('deleting start')
                fetch(`/admin/temoignages/delete/${temoignageIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            notyf.success('Témoignages supprimé');
                            location.reload();
                        } else {
                            notyf.error(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

        });

        {{-- datatable --}}
        new DataTable('#temoignagesTable', {
            scrollX: true,
            columns: [
                null,
                {width: '200px'},
                {width: '400px'},
                {width: '50px'},
                null
            ],
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let columnIndex = column.index();
                        // let title = column.header().textContent;
                        if ([1, 2].includes(columnIndex)) {
                            let input = document.createElement('input');
                            // input.placeholder = title;
                            input.classList.add('form-control')
                            input.classList.add('form-input')

                            column.header().appendChild(input);
                            input.addEventListener('keyup', () => {
                                if (column.search() !== this.value) {
                                    column.search(input.value).draw();
                                }
                            });
                        }
                    })
            }
        })

        {{-- image insert --}}
        const pond = FilePond.create(document.querySelector('.filepond'), {
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
            styleItemPanelAspectRatio: 0.5625 // 16:9 aspect ratio
        });

        {{-- process insert --}}
        document.getElementById('temoignage-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const file = pond.getFiles().map(file => file.serverId)[0];
            const formData = new FormData(this);
            formData.append('image', file);
            fetch('{{ route("admin.temoignages.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notyf.success('Témoignage inséré');
                        console.log(data.data)
                        location.reload();
                    } else {
                        console.error('Error:', data.error);
                        notyf.error('Témoignage non inséré');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notyf.error('Témoignage non inséré');
                });
        });
    </script>
@endpush
