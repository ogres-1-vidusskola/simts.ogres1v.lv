@extends('layouts.app')

@section('title', 'Rediģēt ' . $work->title)

@section('navbar-links')
    <li>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Informācijas panelis</a></li>
            <li class="breadcrumb-item"><a href="/work">100 labie darbi</a></li>
            <li class="breadcrumb-item"><a href="/work/{{ $work->id }}">{{ $work->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </li>
@endsection

@section('content')
    <div class="container wrapper">
        <h1 class="text-center">Rediģēt {{ $work->title }}</h1>

        <hr>

        @include('inc.messages')

        <form action="/work/{{ $work->id }}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf

            <div class="form-group">
                <label for="title">Nosaukums</label>
                <input type="text" name="title" id="title" placeholder="Nosaukums" class="form-control" value="{{ $work->title }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="body">Apraksts</label>
                <textarea name="body" id="body" cols="30" rows="10" required class="form-control" placeholder="Apraksts">{{ $work->body }}</textarea>
            </div>

            <div class="form-group">
                <label for="teacher">Vadītājs</label>
                <select name="teacher_id" class="form-control" required id="teacher">
                    @foreach ($teachers as $teacher)
                        <option {{ $teacher->id == $work->teacher_id ? 'selected' : '' }} value="{{ $teacher->id }}">{{ $teacher->fullName() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="work_status">Darba statuss</label>
                <select name="work_status_id" id="work_status" required class="form-control">
                    @foreach ($statuses as $status)
                        <option {{ $status->id == $work->work_status_id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="completed_at">Plānotais pabeigšanas datums</label>
                <input type="date" class="form-control" placeholder="Pabeigšanas datums" name="completed_at" id="completed_at"
                    value="{{ $work->completed_at != null ? $work->completed_at->format('Y-m-d') : '' }}">
            </div>

            <div class="form-group">
                <div id="image-upload" class="{{ $work->image ? 'd-none' : '' }}">
                    <div class="custom-file">
                        <input type="file" accept="image/*" name="image" id="image" class="custom-file-label">
                        <label for="image" class="custom-file-label">Pievienot attēlu</label>
                    </div>

                    <small class="form-text text-muted">Maksimums 5MB.</small>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" value="Saglabāt" class="btn btn-outline-primary form-control">
            </div>
        </form>

        @if ($work->image)
            <div class="row">
                <div class="col">
                    <a id="image-view-button" class="btn btn-outline-secondary mb-2" target="_blank" href="{{ $work->imageUrl }}">Skatīt attēlu</a><br id="image-break">
                </div>

                <div class="col text-right">
                    <form action="/work/image/{{ $work->id }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash-alt"></i> Dzēst pievienoto attēlu
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script defer src="{{ asset('js/pages/work.js') }}"></script>
@endsection
