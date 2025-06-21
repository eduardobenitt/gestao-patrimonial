Olá Administrador,

O usuário {{ $user->name }} (Função: {{ $user->funcao }}, Equipe: {{ $user->equipe }}) foi marcado como **INATIVO** em
{{ now()->format('d/m/Y H:i') }}.

Patrimônios vinculados:
@foreach ($patrimonios as $p)
    - {{ $p }}
@endforeach

Se precisar de mais detalhes, acesse o sistema.

Atenciosamente,
Equipe de Gestão de Ativos
