@extends('admin.layouts.app')

@section('titre', 'admin')

@push('scripts_head')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 card-info" style="background-color: #40a8f5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9 ">
                                <h1 id="total_donation" class="data"></h1>
                                <p>Don total récolté</p>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-piggy-bank-fill fs-1 icon-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 card-info" style="background-color: #40a8f5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9 ">
                                <h1 id="total_donors" class="data"></h1>
                                <p>Nombre total des donateurs</p>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-people-fill fs-1 icon-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 card-info" style="background-color: #40a8f5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9 ">
                                <h1 id="total_donation_count" class="data"></h1>
                                <p>Nombre total des dons</p>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-wallet-fill fs-1 icon-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 card-info" style="background-color: #40a8f5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9 ">
                                <h1 id="users_donation" class="data"></h1>
                                <p>Meilleur donateur</p>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-person-heart fs-1 icon-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex align-items-stretch mb-4">
            <div class="col-md-8 col-12">
                <div class="card border-0 card-graphs h-100">
                    <div class="card-header">
                        <h5>Les dons colléctés et les nombres de dons par projets</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="projects_classement"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card border-0 card-graphs h-100">
                    <div class="card-header">
                        <h5>Les dons directs et spécifics aux projets</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="donation_breakdown"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex align-items-stretch mb-4">
            <div class="col-md-8 col-12">
                <div class="card border-0 card-graphs h-100">
                    <div class="card-header">
                        <h5>Les dons colléctés en moyenne par projet</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="projects_avg_donation"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card border-0 card-graphs h-100">
                    <div class="card-header">
                        <h5>Les nouveaux donateurs et les donateurs qui sont revenus</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="donator_new_and_returned"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card border-0 card-graphs">
                    <div class="card-header">
                        <h5>Les utilisateurs et leurs dons</h5>
                    </div>
                    <div class="card-body">
                        <table id="users-table" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Don</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card border-0 card-graphs">
                    <div class="card-header">
                        <h5>Dons entre</h5>
                        <div class="d-flex align-items-center mt-2">
                            <p class="mb-0 d-flex align-items-center">
                                <input type="date" id="end-date" class="form-control me-2" style="max-width: 150px;">
                                <span class="me-2">et</span>
                                <input type="date" id="start-date" class="form-control me-2" style="max-width: 150px;">
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donation_last"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    @vite(['resources/js/dashboard.js'])
@endpush
