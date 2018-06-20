@extends('layouts.app')

{{-- Remove padding from main --}}
@section('styling-main', '')

@section('navbar-links')
    <li><a href="#app" class="nav-link active">Sākums</a></li>
    <li><a href="#greatWorks" class="nav-link">Labie Darbi</a></li>
    <li><a href="#events" class="nav-link">Pasākumi</a></li>
    <li><a href="#getInvolved" class="nav-link">Iesaisties!</a></li>
@endsection

@section('content')

<div class="parallax">
    <div class="parallax-container card">
        <div class="card-body text-center">
            <div class="row">
                <div class="col-xs-4 col-md-12">
                    <h4>Ogres 1. vidusskolas projekts</h4>
                </div>

                <div class="col-xs-4 col-md-12">
                    <h2>100 labie darbi</h2>
                </div>

                <div class="col-xs-4 col-md-12">
                    <div class="card-buttons">
                        <a href="#getInvolved" class="ml-4 btn btn-primary">Iesaistīties</a>
                        <a href="#greatWorks" class="mr-4 btn btn-outline-secondary">Uzzināt vairāk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container wrapper wrapper-index">
    {{-- Section - 100 Great Works --}}
    <section tabindex="-1" class="container mb-5">
        <h1 id="greatWorks" class="text-center">100 labie darbi</h1>

        <hr>

        {{-- Tables --}}
        <div class="row">
            @if ($completedWorks && $currentWorks && $plannedWorks != null)
                <div class="col-lg-7">
                    <h3 class="text-center">{{ $completedWorks->status ?? 'Pabeigtie darbi' }}</h3>

                    {{-- Completed works --}}
                    <table class="table table-bordered table-striped table-hover table-clickable">
                        <thead class="table-primary">
                            <tr>
                                <th>Darbs</th>
                                <th>Skolotājs</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($completedWorks->works ?? [] as $work)
                                <tr>
                                    <td>{{ $work->title }}</td>
                                    <td>{{ $work->teacher->fullName() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-5 no-padding-left">
                    <h3 class="text-center">{{ $currentWorks->status ?? 'Pašreizējie darbi' }}</h3>

                    {{-- Current works --}}
                    <div class="great-works-limit">
                        <table class="table table-bordered table-striped table-hover table-clickable">
                            <thead class="table-primary">
                                <tr>
                                    <th>Darbs</th>
                                    <th>Skolotājs</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($currentWorks->works ?? [] as $work)
                                    <tr>
                                        <td>{{ $work->title }}</td>
                                        <td>{{ $work->teacher->fullName() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Planned works --}}
                    <div class="great-works-limit">
                        <table class="table table-bordered table-striped table-hover table-clickable">
                            <h3 class="text-center">{{ $plannedWorks->status ?? 'Plānotie darbi' }}</h3>

                            <thead class="table-primary">
                                <tr>
                                    <th>Darbs</th>
                                    <th>Skolotājs</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($currentWorks->works ?? [] as $work)
                                    <tr>
                                        <td>{{ $work->title }}</td>
                                        <td>{{ $work->teacher->fullName() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="col">
                    <div class="alert alert-warning"><b>Sistēmā nav pievienoti 100 labie darbi.</b></div>
                </div>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="row">
            <div class="col-md-9">
                <p class="text-muted">Šeit netiek rādīti visi labie darbi, lai redzētu visus nospiežiet <a href="/work">šeit</a>.</p>
            </div>

            <div class="col-lg-3 great-works-buttons">
                <button class="btn btn-outline-primary">Prezentācija</button>
                <button class="btn btn-outline-primary">Nolikums</button>
            </div>
        </div>
    </section>

    {{-- Section - Events --}}
    <section tabindex="-1" class="container">
        <h1 id="events" class="text-center">Pasākumi</h1>

        <hr>

        <div class="row mb-5">
            <div class="col-lg-8">
                <a href="{{ asset('images/event-1.jpg') }}" data-lightbox="image-1">
                    <img src="{{ asset('images/event-1.jpg') }}" class="img-fluid img-thumbnail mb-2" class="mb-3" alt="placeholder">
                </a>
                <a href="{{ asset('images/event-2.jpg') }}" data-lightbox="image-1"></a>
                <a href="{{ asset('images/event-3.jpg') }}" data-lightbox="image-1"></a>

                <h2>Tuvākais pasākums</h2>

                <h4>Pasākums 1</h4>

                <h4 class="text-muted">20. jūnijs 2018</h4>

                <button class="btn btn-lg btn-outline-primary">Skatīt</button>
            </div>

            <div class="col-lg-4">
                <div id="calendar"></div>
            </div>
        </div>
    </section>

    {{-- Section - Involvement --}}
    <section tabindex="-1" class="container pb-3">
        <h1 id="getInvolved" class="text-center">{{ $involve->section_title ?? 'Iesaisties!' }}</h1>

        <hr>

        <div class="row d-flex">
            <div class="col-lg-8 d-flex">
                <a href="{{ isset($involve) ? asset($involve->image) : '' }}" data-lightbox="image-2">
                    <img src="{{ isset($involve) ? asset($involve->image) : '' }}" class="img-fluid img-thumbnail" alt="Iesaisties!">
                </a>
            </div>

            <div class="col-lg-4 d-flex flex-wrap align-content-between">
                <div>
                    <h2 class="pt-2">{{ $involve->title ?? 'Vidusskolai vajag tevi!' }}</h2>

                    @if (!isset($involve->body))
                        <div class="alert alert-warning"><b>Sistēmā nav pievienots apraksts par iesaistīšanos!</b></div>
                    @else
                        <p>
                            {{ $involve->body }}
                        </p>
                    @endif
                </div>

                <div class="d-flex flex-grow justify-content-between">
                    <a href="#" class="btn btn-outline-primary">Dāvināt</a>
                    <a href="/recommend/create" class="btn btn-outline-primary">Ieteikt</a>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
    <script defer src="{{ asset('js/pages/index.js') }}"></script>
@endsection
