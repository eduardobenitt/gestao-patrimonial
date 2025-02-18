@extends('layouts.app')

@section('title', 'Lista de Equipamentos')

@section('content')
    <h1>Equipamentos</h1>

    
    <a href="{{ route('equipamentos.create') }}" class="btn btn-success mb-3">+ Novo Equipamento</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Patrimônio</th>
                <th scope="col">Produto</th>
                <th scope="col">Fabricante</th>
                <th scope="col">Status</th>
                <th scope="col">Máquina Vinculada</th>
                <th scope="col">Editar</th>
                <th scope="col">Excluir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipamentos as $equipamento)
                <tr>
                    <th scope="row">{{ $equipamento->patrimonio }}</th>

                    
                    <td>
                        {{ $equipamento->produto ? $equipamento->produto->nome : 'Não informado' }}
                    </td>

                    <td>{{ $equipamento->fabricante ?? 'N/A' }}</td>

                    
                    <td>
                        <span class="badge {{ $equipamento->status === 'Em Uso' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $equipamento->status }}
                        </span>
                    </td>

                   
                    <td>
                        {{ $equipamento->maquina ? $equipamento->maquina->patrimonio : 'Nenhuma' }}
                    </td>

                    
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('equipamentos.edit', $equipamento->id) }}">
                            ✏️ Editar
                        </a>
                    </td>

                    
                    <td>
                        <form action="{{ route('equipamentos.destroy', $equipamento->id) }}" method="POST" onsubmit="return confirm('Confirme a remoção do registro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑 Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
