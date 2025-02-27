@extends('layouts.app')

@section('title', 'Cadastro de Usuário')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Nome -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Função -->
                        <div class="mt-4">
                            <x-input-label for="funcao" :value="__('Função')" />
                            <x-text-input id="funcao" class="block mt-1 w-full" type="text" name="funcao" :value="old('funcao')" />
                            <x-input-error :messages="$errors->get('funcao')" class="mt-2" />
                        </div>

                        <!-- Equipe -->
                        <div class="mt-4">
                            <x-input-label for="equipe" :value="__('Equipe')" />
                            <x-text-input id="equipe" class="block mt-1 w-full" type="text" name="equipe" :value="old('equipe')" />
                            <x-input-error :messages="$errors->get('equipe')" class="mt-2" />
                        </div>

                        <!-- Ramal -->
                        <div class="mt-4">
                            <x-input-label for="ramal" :value="__('Ramal')" />
                            <x-text-input id="ramal" class="block mt-1 w-full" type="text" name="ramal" :value="old('ramal')" />
                            <x-input-error :messages="$errors->get('ramal')" class="mt-2" />
                        </div>

                        <!-- Turno -->
                        <div class="mt-4">
                            <x-input-label for="turno" :value="__('Turno')" />
                            <select id="turno" name="turno" class="block mt-1 w-full">
                                <option value="Integral" {{ old('turno') === 'Integral' ? 'selected' : '' }}>Integral</option>
                                <option value="Manhã" {{ old('turno') === 'Manhã' ? 'selected' : '' }}>Manhã</option>
                                <option value="Tarde" {{ old('turno') === 'Tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                            <x-input-error :messages="$errors->get('turno')" class="mt-2" />
                        </div>

                        <!-- Unidade -->
                        <div class="mt-4">
                            <x-input-label for="unidade" :value="__('Unidade')" />
                            <x-text-input id="unidade" class="block mt-1 w-full" type="text" name="unidade" :value="old('unidade')" />
                            <x-input-error :messages="$errors->get('unidade')" class="mt-2" />
                        </div>

                        <!-- Permissão -->
                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Permissão')" />
                            <select id="role" name="role" class="block mt-1 w-full">
                                <option value="usuario" {{ old('role') === 'usuario' ? 'selected' : '' }}>Usuário</option>
                                <option value="tecnico" {{ old('role') === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Senha -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>

                        <!-- Botão de Cadastro -->
                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
