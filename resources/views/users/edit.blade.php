@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Método correto para atualização -->

                        <!-- Nome -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                value="{{ $user->name }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />

                            {{--
                            <@if ($errors->has('name'))
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            @endif
                             --}}

                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                value="{{ $user->email }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Função -->
                        <div class="mt-4">
                            <x-input-label for="funcao" :value="__('Função')" />
                            <x-text-input id="funcao" class="block mt-1 w-full" type="text" name="funcao"
                                value="{{ $user->funcao }}" />
                            <x-input-error :messages="$errors->get('funcao')" class="mt-2" />
                        </div>

                        <!-- Equipe -->
                        <div class="mt-4">
                            <x-input-label for="equipe" :value="__('Equipe')" />
                            <x-text-input id="equipe" class="block mt-1 w-full" type="text" name="equipe"
                                value="{{ $user->equipe }}" />
                            <x-input-error :messages="$errors->get('equipe')" class="mt-2" />
                        </div>

                        <!-- Regime -->
                        <div class="mt-4">
                            <x-input-label for="regime" :value="__('Regime')" />
                            <select id="regime" name="regime" class="block mt-1 w-full">
                                <option value="In Office" {{ $user->regime === 'In Office' ? 'selected' : '' }}>
                                    In Office
                                </option>

                                <option value="Home Office" {{ $user->regime === 'Home Office' ? 'selected' : '' }}>Home
                                    Office
                                </option>

                                <option value="Hibrido" {{ $user->regime === 'Hibrido' ? 'selected' : '' }}>
                                    Hibrido
                                </option>

                                <option value="Prestador" {{ $user->regime === 'Prestador' ? 'selected' : '' }}>
                                    Prestador
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('regime')" class="mt-2" />
                        </div>

                        <!-- Ramal -->
                        <div class="mt-4">
                            <x-input-label for="ramal" :value="__('Ramal')" />
                            <x-text-input id="ramal" class="block mt-1 w-full" type="text" name="ramal"
                                value="{{ $user->ramal }}" />
                            <x-input-error :messages="$errors->get('ramal')" class="mt-2" />
                        </div>

                        <!-- Turno -->
                        <div class="mt-4">
                            <x-input-label for="turno" :value="__('Turno')" />
                            <select id="turno" name="turno" class="block mt-1 w-full">
                                <option value="Integral" {{ $user->turno === 'Integral' ? 'selected' : '' }}>Integral
                                </option>
                                <option value="Manhã" {{ $user->turno === 'Manhã' ? 'selected' : '' }}>Manhã</option>
                                <option value="Tarde" {{ $user->turno === 'Tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                            <x-input-error :messages="$errors->get('turno')" class="mt-2" />
                        </div>

                        <!-- Unidade -->
                        <div class="mt-4">
                            <x-input-label for="unidade" :value="__('Unidade')" />
                            <x-text-input id="unidade" class="block mt-1 w-full" type="text" name="unidade"
                                value="{{ $user->unidade }}" />
                            <x-input-error :messages="$errors->get('unidade')" class="mt-2" />
                        </div>

                        <!-- Permissão -->
                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Permissão')" />
                            <select id="role" name="role" class="block mt-1 w-full">
                                <option value="usuario" {{ $user->role === 'usuario' ? 'selected' : '' }}>Usuário</option>
                                <option value="tecnico" {{ $user->role === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full">
                                <option value="Ativo" {{ $user->status === 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="Inativo" {{ $user->status === 'Inativo' ? 'selected' : '' }}>Inativo
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        @if ($errors->has('error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('error') }}
                            </div>
                        @endif

                        <!-- Botão de Salvar -->
                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Salvar Alterações') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
