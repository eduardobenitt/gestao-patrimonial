@extends('layouts.app')

@section('title', 'Cadastro de Produto')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-box-seam"></i> Cadastro de Produto</h5>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('produtos.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <h6 class="mb-3 text-primary"><i class="bi bi-info-circle"></i> Informações do Produto</h6>
                                <div class="card border-light bg-light">
                                    <div class="card-body">
                                        <div class="mb-0">
                                            <label for="nome" class="form-label fw-bold">Nome do Produto</label>
                                            <input type="text" id="nome" name="nome"
                                                class="form-control @error('nome') is-invalid @enderror"
                                                value="{{ old('nome') }}" required autofocus>
                                            <small class="form-text text-muted">
                                                Exemplos: Mouse, Teclado, Monitor, Headset, etc.
                                            </small>
                                            @error('nome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Salvar Produto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
