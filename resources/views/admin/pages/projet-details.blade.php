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
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{ $projet->title }}</h1>
                <span class="mb-4 badge rounded-pill text-bg-primary">{{ $projet->getStatus() }}</span>
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
            <div class="col-12">
                <label class="text-body-secondary mb-1">Objectifs <span class="fw-bold">({{ count($projet->project_objectives) }})</span></label>
                <div>
                    @foreach($projet->project_objectives as $objectif)
                        <span class="px-3 py-2 fs-6 fw-medium mb-4 badge rounded-pill text-bg-primary">{{ $objectif->objective }}</span>
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <input type="file" class="filepond" multiple>
                @csrf
                <button onclick="processUpload()" class="process-button">Process Upload</button>
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
            labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>',
            styleItemPanelAspectRatio: 0.5625, // 16:9 aspect ratio
        });

        pond.on('error', (error, file) => {
            console.error('FilePond error:', error, file);
        });

        // Add successful upload handling
        pond.on('processfile', (error, file) => {
            if (!error) {
                console.log('Upload successful:', file.serverId);
            }
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
                console.log('Processed files:', result);

                // Clear FilePond after successful processing
                pond.removeFiles();

                alert('Files processed successfully!');
            } catch (error) {
                console.error('Error processing files:', error);
                alert('Error processing files. Please try again.');
            }
        }
    </script>
@endpush
