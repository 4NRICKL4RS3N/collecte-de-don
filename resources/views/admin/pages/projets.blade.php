@extends('admin.layouts.app')

@section('titre', 'admin | projets')

@push('scripts_head')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h1>Créer un nouveau projet</h1>

                <form id="objectif-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Nom du projet</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="location">Lieu</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-select" style="width: fit-content" required>
                            <option value="0" selected>en attente</option>
                            <option value="1">en cours</option>
                            <option value="2">terminé</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="tags-input">
                            <label for="input-tag-container">Objectifs</label>
                            <ul id="tags"></ul>
                            <input class="form-control" type="text" id="input-tag" placeholder="entrez un objectif"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="donation_target">Objectif de don</label>
                        <input type="number" name="donation_target" id="donation_target" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="date_start">Début</label>
                                <input type="date" name="date_start" id="date_start" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="date_end">Fin</label>
                                <input type="date" name="date_end" id="date_end" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button id="submit-project" type="submit" class="btn btn-primary">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1>Liste des projets</h1>
                <table id="projectsTable" class="display">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th class="text-end">Objectif don</th>
                        <th class="text-end">Don récolté</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projets as $projet)
                        <tr data-url="/admin/projets/{{ $projet->id }}">
                            <td><a class="text-decoration-none text-black hover-underline" href="/admin/projets/{{ $projet->id }}">{{ $projet->id }}</a></td>
                            <td><a class="text-decoration-none text-black hover-underline" href="/admin/projets/{{ $projet->id }}">{{ $projet->title }}</a></td>
                            <td>{{ $projet->status }}</td>
                            <td class="text-end">{{ number_format($projet->donation_target, 0, ',', ' ') }}</td>
                            <td class="text-end">{{ number_format($projet->donation_collected, 0, ',', ' ') }}</td>
                            {{--                    <td class="text-end">{{ \Carbon\Carbon::parse($projet->date_start)->translatedFormat('d F Y') }}</td>--}}
                            {{--                    <td class="text-end">{{ \Carbon\Carbon::parse($projet->date_end)->translatedFormat('d F Y') }}</td>--}}
                            <td>
                                <button class="btn btn-primary update-btn modify-btn"
                                        data-micromodal-trigger="update-modal" update-data-id="{{ $projet->id }}"
                                        update-data-title="{{ $projet->title }}"
                                        update-data-description="{{ $projet->description }}"
                                        update-data-location="{{ $projet->location }}"
                                        update-data-status="{{ $projet->status }}"
                                        update-data-donation_target="{{ $projet->donation_target }}"
                                        update-data-date_start="{{ $projet->date_start }}"
                                        update-data-date_end="{{ $projet->date_end }}"
                                        update-data-objectives="{{ $projet->project_objectives }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger delete-btn text-white"
                                        data-micromodal-trigger="delete-modal"
                                        delete-data-id="{{ $projet->id }}"
                                        delete-data-title="{{ $projet->title }}">
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
                        Modifiez le projet
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <div class="modal__content" id="update-modal-content">
                    <form id="update-objectif-form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="update-title">Nom du projet</label>
                            <input type="text" name="title" id="update-title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="update-description">Description</label>
                            <textarea name="description" id="update-description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="update-location">Lieu</label>
                            <input type="text" name="location" id="update-location" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="update-status">Status</label>
                            <select name="status" id="update-status" class="form-select" style="width: fit-content"
                                    required>
                                <option value="0" selected>en attente</option>
                                <option value="1">en cours</option>
                                <option value="2">terminé</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="tags-input">
                                <label for="update-input-tag-container">Objectifs</label>
                                <ul id="update-tags"></ul>
                                <input class="form-control" type="text" id="update-input-tag"
                                       placeholder="entrez un objectif"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="update-donation_target">Objectif de don</label>
                            <input type="number" name="donation_target" id="update-donation_target" class="form-control"
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-date_start">Début</label>
                                    <input type="date" name="date_start" id="update-date_start" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="update-date_end">Fin</label>
                                    <input type="date" name="date_end" id="update-date_end" class="form-control"
                                           required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button class="modal__btn btn-danger" id="confirm-update" aria-label="Close this dialog">Modifier
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
                    Êtes-vous sûr de vouloir supprimer le projet <span class="fw-bolder">"<span
                            id="delete-data-title-display"></span>"</span>
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
        {{-- modals --}}
        MicroModal.init();
        // delete projet
        let projectIdToDelete;
        let projectTitleToDelete;
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                projectTitleToDelete = this.getAttribute('delete-data-title');
                projectIdToDelete = this.getAttribute('delete-data-id');
                document.getElementById('delete-data-title-display').textContent = projectTitleToDelete;
            });
        });
        document.getElementById('confirm-delete').addEventListener('click', function () {
            console.log('deleting clicked')
            if (projectIdToDelete) {
                console.log('deleting start')
                fetch(`/admin/projets/delete/${projectIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            notyf.success('Projet supprimé');
                            MicroModal.close('delete-modal');
                            location.reload();
                        } else {
                            notyf.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });

        // update projet
        let projectIdToUpdate;
        let inputTitleToUpdate = document.getElementById('update-title');
        let inputDescriptionToUpdate = document.getElementById('update-description');
        let inputLocationToUpdate = document.getElementById('update-location');
        let inputStatusToUpdate = document.getElementById('update-status');
        let inputDonationTargetToUpdate = document.getElementById('update-donation_target');
        let inputDateStartToUpdate = document.getElementById('update-date_start');
        let inputDateEndToUpdate = document.getElementById('update-date_end');

        let objectifsToUpdateJSON;
        let objectifsToUpdate;
        const updateTags = document.getElementById('update-tags');
        document.querySelectorAll('.update-btn').forEach(button => {
            button.addEventListener('click', function () {
                projectIdToUpdate = this.getAttribute('update-data-id');
                inputTitleToUpdate.value = this.getAttribute('update-data-title');
                inputDescriptionToUpdate.value = this.getAttribute('update-data-description');
                inputLocationToUpdate.value = this.getAttribute('update-data-location');
                inputStatusToUpdate.value = this.getAttribute('update-data-status');
                inputDonationTargetToUpdate.value = this.getAttribute('update-data-donation_target');
                inputDateStartToUpdate.value = this.getAttribute('update-data-date_start');
                inputDateEndToUpdate.value = this.getAttribute('update-data-date_end');

                objectifsToUpdateJSON = JSON.parse(this.getAttribute('update-data-objectives'));
                objectifsToUpdate = objectifsToUpdateJSON.map(item => item['objective'])
                updateTags.innerText = ''
                let updateTag;
                for (const objectif of objectifsToUpdate) {
                    updateTag = document.createElement('li');
                    updateTag.innerText = objectif;
                    updateTag.innerHTML += '<button type="button" class="delete-button"><i class="bi bi-x"></i></button>';
                    updateTags.append(updateTag);
                }
                debugger;
                console.log(objectifsToUpdate);
            });
        });

        const updateInput = document.getElementById('update-input-tag');
        updateInput.addEventListener('keydown', function (event) {
            addObjective(event, updateInput, updateTags, objectifsToUpdate);
        });
        updateTags.addEventListener('click', function (event) {
            deleteObjective(event, objectifsToUpdate);
        });

        function updateProject() {
            const form = document.getElementById('update-objectif-form');
            const formData = new FormData(form);
            formData.append('objectifs', JSON.stringify(objectifsToUpdate));
            formData.append('_method', 'PATCH');
            fetch(`/admin/projets/update/${projectIdToUpdate}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Send CSRF token for Laravel security
                },
                body: formData, // Use FormData as the body
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notyf.success(data.message);
                        location.reload();
                    } else {
                        notyf.error(data.message);
                    }
                })
                .catch((error) => {
                    notyf.error(error);
                    console.error('Error:', error);
                });
        }
        document.getElementById('confirm-update').addEventListener('click', function (event) {
            event.preventDefault();
            updateProject();
        });

        {{-- notification --}}
        var notyf = new Notyf({
            position: {x: 'center', y: 'top'},
        });

        {{-- dynamic objectif --}}
        function addObjective(event, input, tags, objectifs) {
            if (event.key === 'Enter') {
                event.preventDefault();

                const tag = document.createElement('li');
                const tagContent = input.value.trim();

                if (tagContent !== '') {
                    tag.innerText = tagContent;
                    tag.innerHTML += '<button type="button" class="delete-button"><i class="bi bi-x"></i></button>';
                    tags.appendChild(tag);
                    input.value = '';
                    objectifs.push(tagContent);
                }
                console.log(objectifs);
            }
        }

        const tags = document.getElementById('tags');
        const input = document.getElementById('input-tag');
        var objectifs = [];

        input.addEventListener('keydown', function (event) {
            addObjective(event, input, tags, objectifs);
        });

        function deleteObjective(event, objectifs) {
            const deleteButton = event.target.closest('.delete-button');
            if (deleteButton) {
                const tag = deleteButton.parentNode;
                const tagContent = tag.firstChild.textContent.trim();
                tag.remove();
                const index = objectifs.indexOf(tagContent);

                if (index !== -1) {
                    objectifs.splice(index, 1);
                }
                console.log(objectifs);
            }
        }

        tags.addEventListener('click', function (event) {
            deleteObjective(event, objectifs);
        });

        {{-- datatable --}}
        new DataTable('#projectsTable', {
            scrollX: true,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let columnIndex = column.index();
                        // let title = column.header().textContent;
                        if ([1, 3, 4].includes(columnIndex)) {
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
                        if (columnIndex === 2) {
                            let select = document.createElement('select');
                            select.classList.add('form-select')
                            select.classList.add('form-input')

                            let defaultOption = document.createElement('option');
                            defaultOption.value = '';
                            defaultOption.textContent = 'statut';
                            select.appendChild(defaultOption);

                            let statuts = ['en attente', 'en cours', 'terminé'];
                            statuts.forEach(function (statut, index) {
                                let option = document.createElement('option');
                                option.value = index;
                                option.textContent = statut;
                                select.appendChild(option);
                            });

                            column.header().appendChild(select);
                            select.addEventListener('change', () => {
                                let val = select.value;
                                column.search(val).draw();
                            });
                        }
                    })
            }
        })

        {{-- insert projet --}}
        function saveProject() {
            const form = document.getElementById('objectif-form');
            const formData = new FormData(form);

            formData.append('objectifs', JSON.stringify(objectifs));

            fetch('{{ route('admin.projets.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Send CSRF token for Laravel security
                },
                body: formData, // Use FormData as the body
            })
                .then(response => response.json())
                .then(data => {
                    notyf.success('Projet inséré');
                    location.reload();
                    console.log('Success:', data['message']);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        document.getElementById('submit-project').addEventListener('click', function (event) {
            event.preventDefault();
            saveProject();
        });
    </script>
@endpush
