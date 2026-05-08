@extends('template-admin.layout')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard-superadmin') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('informasi.index') }}">Informasi</a></li>
                                <li class="breadcrumb-item" aria-current="page">Tambah Informasi</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tambah Informasi</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Judul</label>
                                            <input type="text" name="judul" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Thumbnail</label>
                                            <input type="file" name="thumbnail" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Terbit</label>
                                            <input type="date" name="tanggal_terbit" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Penulis</label>
                                            <input type="text" name="penulis" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="published"
                                                    id="published" checked>
                                                <label class="form-check-label" for="published">Published</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Konten</label>
                                            <textarea name="konten" id="tinymce-editor" class="form-control" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- TinyMCE js -->
    <script src="{{ asset('admin') }}/assets/js/plugins/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            height: '400',
            selector: '#tinymce-editor',
            content_style: 'body { font-family: "Inter", sans-serif; }',
            menubar: false,
            toolbar: [
                'styleselect fontselect fontsizeselect',
                'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview | code'
            ],
            plugins: 'advlist autolink link image lists charmap print preview code',
            images_upload_handler: function(blobInfo, success, failure) {
                return new Promise((resolve, reject) => {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{ route('informasi.upload.image') }}');
                    var token = '{{ csrf_token() }}';
                    xhr.setRequestHeader("X-CSRF-TOKEN", token);

                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            if (typeof failure === 'function') failure('HTTP Error: ' + xhr.status);
                            reject('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location != 'string') {
                            if (typeof failure === 'function') failure('Invalid JSON: ' + xhr
                                .responseText);
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        if (typeof success === 'function') success(json.location);
                        resolve(json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                });
            }
        });
    </script>
@endsection
