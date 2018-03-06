@extends('admin/layouts.app')

@section('custom_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card">
    <div class="card-header">Blogs - Add New <a href="{{ route('blogs.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Title <span class="required">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Write something beautiful today..." onkeyup="countChar(this, 'charNumTitle', 60)" maxlength="60" required>
                        <span id="charNumTitle" class="text-info">60 Characters Left</span>
                    </div>
                    <div class="form-group">
                        <label for="excerpt">Excerpt/Summary <span class="required">*</span></label>
                        <textarea name="excerpt" id="excerpt" class="form-control" rows="3" maxlength="280" placeholder="summary of my beautiful words..." onkeyup="countChar(this, 'charNumExcerpt', 280)" required>{{ old('excerpt') }}</textarea>
                        <span id="charNumExcerpt" class="text-info">280 Characters Left</span>
                        <small id="excerptHelp" class="form-text text-muted">Excerpts are hand-crafted summaries of your content helps search engines and to show post on home page</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="image">Featured Image <span class="required">*</span></label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="categories">Categories <span class="required">*</span></label>
                        <select class="form-control" id="categories" name="categories[]" required multiple>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_id">Author <span class="required">*</span></label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            @foreach($authors as $author)
                            <option value="{{ $author->id }}" @if(Auth::user()->id == $author->id) selected @endif>{{ $author->name }} ({{ $author->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Publish <span class="required">*</span></label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="allow_comments">Allow Comments <span class="required">*</span></label>
                        <select class="form-control" id="allow_comments" name="allow_comments" required>
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#categories').select2({
        theme: "bootstrap",
        tags: true,
        placeholder: "Choose Categories...",
        minimumInputLength: 2,
        delay : 200,
        tokenSeparators: [',','.'],
        ajax: {
            url: '{{ route("categories.ajaxSelectData") }}',
            dataType: 'json',
            cache: true,
            data: function(params) {
              return {
                  term: params.term || '',
                  page: params.page || 1
              }
          },
        }
    });
});

// Count Char Helper
function countChar(val, id, limit) {
    leftChar = limit - val.value.length;
    $('#'+id).text( leftChar + " Characters Left");
}
</script>
@endsection
