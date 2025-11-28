@extends('layouts.admin')

@section('title', 'Gestión de Ítems - XP Store')
@section('subtitle', 'Administra ítems del marketplace')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-boxes"></i> Gestión de Ítems</h1>
            <p class="admin-subtitle">Sección lista para conectar con tu modelo de ítems o marketplace.</p>
        </div>
    </div>

    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-box-open"></i></div>
        <h3>Sin ítems configurados aún</h3>
    </div>
</div>
@endsection
