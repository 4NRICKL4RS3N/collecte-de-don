@extends('admin.layouts.app')

@section('titre', 'admin | impactes')

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
                <h1>Créer un nouveau impactes</h1>

                <form id="impact-form" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>

                    <div class="form-group mb-2">
                        <label for="content">Contenue</label>
                        <input type="text" name="content" id="content" class="form-control">
                    </div>

                    <div class="form-group">
                        <button id="submit-impact" type="submit" class="mt-3 btn btn-primary">Créer l'impact</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <h1>Liste des impacts</h1>
                <table id="impactsTable" class="display">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($impacts as $impacts)
                        <tr>
                            <td>{{ $impacts->id }}</td>
                            <td>{{ $impacts->title }}</td>
                            <td>{{ $impacts->content }}</td>
                            <td class="text-end">
                                <button class="btn btn-primary update-btn modify-btn"
                                        data-micromodal-trigger="update-modal"
                                        update-data-id="{{ $impacts->id }}"
                                        update-data-title="{{ $impacts->title }}"
                                        update-data-content="{{ $impacts->content }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger delete-btn text-white"
                                        data-micromodal-trigger="delete-modal"
                                        delete-data-id="{{ $impacts->id }}"
                                        delete-data-title="{{ $impacts->title }}">
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
                        Modifiez l'impact
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <div class="modal__content" id="update-modal-content">
                    <form id="update-impact-form" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="update-title">Titre</label>
                            <input type="text" name="title" id="update-title" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label for="update-content">Contenue</label>
                            <input type="text" name="content" id="update-content" class="form-control">
                        </div>
                    </form>
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button type="submit" form="update-impact-form" class="modal__btn btn-danger" id="confirm-update" aria-label="Close this dialog">Modifier
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
                    Êtes-vous sûr de vouloir supprimer l'impact <span class="fw-bolder" id="delete-data-title-display"></span>
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
    <script>
        const csrfToken = '{{csrf_token()}}';
        var notyf = new Notyf({
            position: {x: 'center', y: 'top'},
        });
        MicroModal.init();

        {{-- process update --}}
        let impactIdToUpdate;
        const inputTitleToUpdate = document.getElementById('update-title');
        const inputContentToUpdate = document.getElementById('update-content');
        document.querySelectorAll('.update-btn').forEach(button => {
            button.addEventListener('click', function () {
                impactIdToUpdate = this.getAttribute('update-data-id');
                inputTitleToUpdate.value = this.getAttribute('update-data-title');
                inputContentToUpdate.value = this.getAttribute('update-data-content');
            });
        });
        document.getElementById('update-impact-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('_method', 'PATCH');
            fetch(`/admin/impacts/update/${impactIdToUpdate}`, {
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
                        notyf.success('Impact modifié');
                        console.log(data.data)
                        location.reload();
                    } else {
                        console.error('Error:', data.error);
                        notyf.error('Impact non modifié: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notyf.error('Impact non modifié: ' + error);
                });
        });

        {{-- process delete --}}
        let impactIdToDelete;
        let impactTitleToDelete;
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                impactIdToDelete = this.getAttribute('delete-data-id');
                impactTitleToDelete = this.getAttribute('delete-data-title');
                document.getElementById('delete-data-title-display').textContent = impactTitleToDelete;
            });
        });
        document.getElementById('confirm-delete').addEventListener('click', function () {
            if (impactIdToDelete) {
                console.log('deleting start')
                fetch(`/admin/impacts/delete/${impactIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            notyf.success('Impacts supprimé');
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
        new DataTable('#impactsTable', {
            scrollX: true,
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

        {{-- process insert --}}
        document.getElementById('impact-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('{{ route("admin.impacts.store") }}', {
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
                        notyf.success('Impact inséré');
                        console.log(data.data)
                        location.reload();
                    } else {
                        console.error('Error:', data.error);
                        notyf.error('Impact non inséré');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notyf.error('Impact non inséré');
                });
        });
    </script>
@endpush
