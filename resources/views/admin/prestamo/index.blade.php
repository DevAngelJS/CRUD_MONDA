@extends('adminlte::page')

@section('title', 'Crud Libreria')

@section('content_header')
    <h1>{{ __('Prestamos') }}</h1>
@stop

@section('content')
    <input type="hidden" id="FormOpen" value="0">
    <div id="content-wrapper">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                {{ session('success') }}
            </div>
        @endif
        @include('admin.prestamo.indexContent')
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/prestamo.js') }}"></script>
@endpush

@push('css')
    <style>
        .card {
            margin-top: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .is-invalid ~ .invalid-feedback {
            display: block !important;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .libro-item {
            border-left: 4px solid #4e73df;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .btn-eliminar-libro.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .select2-container--bootstrap4 .select2-selection {
            min-height: 38px;
            padding: 4px 8px;
        }
        input[type="date"] {
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        input[type="date"]:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        textarea {
            resize: none;
            min-height: 100px;
        }
        @keyframes fadeOutDisplay {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                display: none;
            }
        }

        .fade-out-display {
            animation: fadeOutDisplay 1s ease-in-out forwards;
            animation-delay: 4s
        }
    </style>
@endpush