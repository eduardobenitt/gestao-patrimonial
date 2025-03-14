@extends('layouts.app')

@section('title', 'Lista de Máquinas')

@section('content')
    <h1>Máquinas</h1>

    <!-- Botão para adicionar nova máquina -->
    <a href="{{ route('maquinas.create') }}" class="btn btn-success mb-3">+ Nova Máquina</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Patrimônio</th>
                <th scope="col">Fabricante</th>
                <th scope="col">Tipo</th>
                <th scope="col">Status</th>
                <th scope="col">Usuário(s) Vinculado(s)</th>
                <th scope="col">Equipamentos Vinculados</th>
                <th scope="col">Editar</th>
                <th scope="col">Excluir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($maquinas as $maquina)
                <tr>
                    <!-- Patrimônio -->
                    <th scope="row">{{ $maquina->patrimonio }}</th>

                    <!-- Fabricante -->
                    <td>{{ $maquina->fabricante ?? 'N/A' }}</td>

                    <!-- Tipo (Notebook ou Desktop) -->
                    <td>{{ ucfirst($maquina->tipo) }}</td>

                    <!-- Status -->
                    <td>
                        <span class="badge {{ $maquina->status === 'Almoxarifado' ? 'bg-secondary' : 'bg-success' }}">
                            {{ $maquina->status }}
                        </span>
                    </td>

                    <!-- Usuário(s) Vinculado(s) -->
                    <td>
                        @if ($maquina->usuarios->isNotEmpty())
                            @foreach ($maquina->usuarios as $usuario)
                                <span class="badge bg-primary">
                                    {{ $usuario->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">Nenhum usuário</span>
                        @endif
                    </td>

                    <!-- Equipamentos Vinculados -->
                    <td>
                        @if ($maquina->equipamentos->isNotEmpty())
                            <ul style="list-style-type: none; padding: 0; margin: 0;">
                                @foreach ($maquina->equipamentos as $equipamento)
                                    <li>
                                        <strong>{{ $equipamento->produto->nome ?? 'Produto não definido' }}</strong> -
                                        {{ $equipamento->patrimonio }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Nenhum equipamento</span>
                        @endif
                    </td>

                    <!-- Botão de Editar -->
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('maquinas.edit', $maquina->id) }}">
                            ✏️ Editar
                        </a>
                    </td>

                    <!-- Botão de Excluir (com confirmação) -->
                    <td>
                        <form action="{{ route('maquinas.destroy', $maquina->id) }}" method="POST"
                            onsubmit="return confirm('Confirme a remoção do registro?')">
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
