@extends('layouts.app')

@section('title', $post->id ? 'Modifica Post' : 'Crea Post')

@section('actions')
  <div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mx-1">
      Torna alla lista
    </a>

    @if ($post->id)
      <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary mx-1">
        Mostra Post
      </a>
    @endif
  </div>
@endsection

@section('content')

  @include('layouts.partials.errors')

  <section class="card py-2">
    <div class="card-body">

      @if ($post->id)
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="row">
          @method('put')
        @else
          <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="row">
      @endif

      @csrf

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="title" class="form-label">Titolo</label>
        </div>
        <div class="col-md-10">
          <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $post->title) }}" />
          @error('title')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>


      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="is_published" class="form-label">Pubblicato</label>
        </div>
        <div class="col-md-10">
          <input type="checkbox" name="is_published" id="is_published"
            class="form-check-control @error('is_published') is-invalid @enderror" @checked(old('is_published', $post->is_published))
            value="1" />
          @error('is_published')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="image" class="form-label">Immagine</label>
        </div>
        <div class="col-md-8">
          <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" />
          @error('image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="col-2">
          <img src="{{ $post->getImageUri() }}" class="img-fluid" alt="" id="image-preview">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="text" class="form-label">Testo</label>
        </div>
        <div class="col-md-10">
          <textarea name="text" id="text" class="form-control
             @error('text') is-invalid @enderror"
            rows="5">{{ old('text', $post->text) }}</textarea>
          @error('text')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>


      <div class="row">
        <div class="offset-2 col-8">
          <input type="submit" class="btn btn-primary" value="Salva" />
        </div>
      </div>
      </form>

    </div>
  </section>
@endsection

@section('scripts')
  <script>
    const imageInputEl = document.getElementById('image');
    const imagePreviewEl = document.getElementById('image-preview');
    const placeholder = imagePreviewEl.src;

    imageInputEl.addEventListener('change', () => {
      if (imageInputEl.files && imageInputEl.files[0]) {
        const reader = new FileReader();
        reader.readAsDataURL(imageInputEl.files[0]);

        reader.onload = e => {
          imagePreviewEl.src = e.target.result;
        }
      } else imagePreviewEl.src = placeholder;
    })
  </script>
@endsection
