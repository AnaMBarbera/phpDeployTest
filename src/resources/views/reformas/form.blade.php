<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <label>Título</label><br>
    <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" required><br><br>

    <label>Foto Principal</label><br>
    <input type="file" name="main_image"><br>
    @if(!empty($post->main_image_url))
        <img src="{{ $post->main_image_url }}" alt="Foto principal" width="150"><br>
    @endif
    <br>

    <h3>Párrafos</h3>
    <div id="paragraphs">
        @php
            $contents = old('content', $post->content_with_image_urls ?? []);
        @endphp

    @if(!empty($contents) && is_array($contents))
    @foreach($contents as $i => $para)
        <div class="paragraph-block" data-index="{{ $i }}">
            <textarea name="content[{{ $i }}][text]" placeholder="Texto del párrafo">{{ $para['text'] ?? '' }}</textarea><br>
        
            <label>Foto Izquierda (opcional)</label><br>
            <input type="file" name="image_left_{{ $i }}"><br>
            @if(!empty($para['image_left_url']))
                <img src="{{ $para['image_left_url'] }}" alt="Izquierda" width="100"><br>
            @endif
        
            <label>Foto Derecha (opcional)</label><br>
            <input type="file" name="image_right_{{ $i }}"><br>
            @if(!empty($para['image_right_url']))
                <img src="{{ $para['image_right_url'] }}" alt="Derecha" width="100"><br>
            @endif
        
            <button type="button" class="delete" onclick="removeParagraph({{ $i }})">Eliminar párrafo</button>
            <hr>
        </div>
    @endforeach
    @else
    <div class="paragraph-block" data-index="0">
        <textarea name="content[0][text]" placeholder="Texto del párrafo"></textarea><br>
        <label>Foto Izquierda (opcional)</label><br>
        <input type="file" name="image_left_0"><br>
        <label>Foto Derecha (opcional)</label><br>
        <input type="file" name="image_right_0"><br>
        <button type="button" class="delete" onclick="removeParagraph(0)">Eliminar párrafo</button>
        <hr>
    </div>
    @endif

    </div>

    <button type="button" onclick="addParagraph()">Añadir párrafo</button><br><br>

    <button type="submit">{{ $buttonText }}</button>
</form>

<script>
    // Inicializamos el contador según los bloques ya presentes
    let paragraphCount = document.querySelectorAll('.paragraph-block').length;

    function addParagraph() {
        const container = document.getElementById('paragraphs');
        const index = paragraphCount++;

        const div = document.createElement('div');
        div.classList.add('paragraph-block');
        div.dataset.index = index;
        div.innerHTML = `
            <textarea name="content[${index}][text]" placeholder="Texto del párrafo"></textarea><br>
            <label>Foto Izquierda (opcional)</label><br>
            <input type="file" name="image_left_${index}"><br>
            <label>Foto Derecha (opcional)</label><br>
            <input type="file" name="image_right_${index}"><br>
            <button type="button" onclick="removeParagraph(${index})">Eliminar párrafo</button>
            <hr>
        `;
        container.appendChild(div);
    }

    function removeParagraph(index) {
        const div = document.querySelector(`.paragraph-block[data-index='${index}']`);
        if (div) div.remove();
    }
</script>



