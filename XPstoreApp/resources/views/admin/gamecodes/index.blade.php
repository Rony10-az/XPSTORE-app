@extends('layouts.admin')

@section('title', 'Game Codes - XP Store')

@vite(['resources/css/show.css'])

@section('content')
<div class="show-container">
    <div class="show-header">
        <div class="show-title">
            <h1>Game Codes</h1>
            <p class="show-subtitle">Listado de códigos de videojuegos</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.gamecodes.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Nuevo Código
            </a>
        </div>
    </div>

    <div class="show-layout">
        <div class="main-content">
            <div class="game-info-section">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Videojuego</th>
                            <th>Usado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($codes as $code)
                        <tr>
                            <td>{{ $code->id }}</td>
                            <td>{{ $code->code }}</td>
                            <td>{{ $code->videoGame->title ?? '-' }}</td>
                            <td>{{ $code->used ? 'Sí' : 'No' }}</td>
                            <td>
                                <a href="{{ route('admin.gamecodes.show', $code->id) }}" class="btn-primary">Ver</a>
                                <a href="{{ route('admin.gamecodes.edit', $code->id) }}" class="btn-secondary">Editar</a>
                                <form action="{{ route('admin.gamecodes.destroy', $code->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $codes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection