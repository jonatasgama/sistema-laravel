<x-mail::message>
# {{ $tarefa }}

Data limite de conclusão: {{ $data_limite_conclusao }}

<x-mail::button :url="$url">
Visualizar Tarefa
</x-mail::button>

Obg,<br>
{{ config('app.name') }}
</x-mail::message>
