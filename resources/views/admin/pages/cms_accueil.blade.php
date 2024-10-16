@extends('admin.layouts.app')

@section('titre', 'cms | accueil')

@push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container border border-black p-4">
        <div class="row page">
            <fieldset class="border border-black p-3">
                <legend class="float-none w-auto px-3">Header</legend>
                <div class="form-floating col-2 ms-auto">
                    <input type="text" class="form-control border-0 rounded-0 bg-black text-white" id="floatingInput" placeholder="button">
                    <label for="floatingInput" class="text-white">Button</label>
                </div>
            </fieldset>

            <fieldset class="border border-black p-3">
                <legend class="float-none w-auto px-3">Contenu</legend>

                <fieldset class="border-black border p-3 mb-3">
                    <legend class="float-none w-auto px-3 fs-5">Section Hero</legend>
                    <div class="row">
                        <div class="col-6">
                            <textarea type="text" class="form-control border-black rounded-0 bg-white fs-3 mb-3"
                                      id="floatingInput" placeholder="Grand titre"></textarea>
                            <div class="form-floating col-4">
                                <input type="text" class="form-control border-0 rounded-0 bg-black text-white"
                                       id="floatingInput" placeholder="button">
                                <label for="floatingInput" class="text-white">Button</label>
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
                            <textarea type="text" class="form-control border-black rounded-0 bg-white fs-3 mb-3"
                                      id="floatingInput" placeholder="Grand titre"></textarea>
                            <textarea type="text" class="form-control border-black rounded-0 bg-white fs-5"
                                      id="floatingInput" placeholder="Text"></textarea>
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
                            <textarea type="text" class="form-control border-black rounded-0 bg-white fs-3 mb-3"
                                      id="floatingInput" placeholder="Grand titre"></textarea>
                            <textarea type="text" class="form-control border-black rounded-0 bg-white fs-5"
                                      id="floatingInput" placeholder="Text"></textarea>
                        </div>
                    </div>
                </fieldset>
            </fieldset>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        const csrfToken = '{{csrf_token()}}';
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImagePreview,
            FilePondPluginMediaPreview
        );
        FilePond.create(document.querySelector('.filepondJumbotron'), {
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

        FilePond.create(document.querySelector('.filepondSection1'), {
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

    </script>
@endpush
