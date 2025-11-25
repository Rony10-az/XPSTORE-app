<form action="{{ route('community.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <textarea name="content" class="content-box" placeholder="¿Qué quieres compartir hoy?" required></textarea>

    <label class="file-label">
        <i class="fas fa-image"></i> Subir imagen (opcional)
        <input type="file" name="image" class="file-input" accept="image/*" onchange="previewImage(event)">
    </label>

    <img id="preview" class="image-preview" style="display:none;">

    <button class="send-btn">
        <i class="fas fa-paper-plane"></i> Publicar
    </button>
</form>

<script>
    function previewImage(event) {
        const img = document.getElementById('preview');
        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';
    }
</script>