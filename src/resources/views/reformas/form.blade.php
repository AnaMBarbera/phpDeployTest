<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <label>Título</label><br>
    <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" required><br><br>

    <label>Foto Principal</label><br>
    <input type="file" name="main_image"><br>
    @if(!empty($post->main_image))
        <img src="{{ asset('storage/'.$post->main_image) }}" alt="Foto principal" width="150"><br>
    @endif
    <br>

    <h3>Párrafos</h3>
    <div id="paragraphs">
        @if(!empty(old('content')) && is_array(old('content')))
            @foreach(old('content') as $i => $para)
                <div class="paragraph-block" data-index="{{ $i }}">
                    <textarea name="content[{{ $i }}][text]" placeholder="Texto del párrafo" required>{{ $para['text'] }}</textarea><br>
                    <label>Foto Izquierda (opcional)</label>
                    <input type="file" name="content[{{ $i }}][image_left]"><br>
                    <label>Foto Derecha (opcional)</label>
                    <input type="file" name="content[{{ $i }}][image_right]"><br>
                    <button type="button" class="delete" onclick="removeParagraph({{ $i }})">Eliminar párrafo</button>
                    <hr>
                </div>
            @endforeach
        @elseif(!empty($post->content))
            @foreach($post->content as $i => $para)
                <div class="paragraph-block" data-index="{{ $i }}">
                    <textarea name="content[{{ $i }}][text]" placeholder="Texto del párrafo" required>{{ $para['text'] }}</textarea><br>
                    <label>Foto Izquierda (opcional)</label>
                    <input type="file" name="content[{{ $i }}][image_left]"><br>
                    <label>Foto Derecha (opcional)</label>
                    <input type="file" name="content[{{ $i }}][image_right]"><br>
                    @if(!empty($para['image_left']))
                        <img src="{{ asset('storage/'.$para['image_left']) }}" alt="Izquierda" width="100">
                    @endif
                    @if(!empty($para['image_right']))
                        <img src="{{ asset('storage/'.$para['image_right']) }}" alt="Derecha" width="100">
                    @endif
                    <button type="button" class="delete" onclick="removeParagraph({{ $i }})">Eliminar párrafo</button>
                    <hr>
                </div>
            @endforeach
        @else
            <div class="paragraph-block" data-index="0">
                <textarea name="content[0][text]" placeholder="Texto del párrafo" required></textarea><br>
                <label>Foto Izquierda (opcional)</label>
                <input type="file" name="content[0][image_left]"><br>
                <label>Foto Derecha (opcional)</label>
                <input type="file" name="content[0][image_right]"><br>
                <button type="button" class="delete" onclick="removeParagraph(0)">Eliminar párrafo</button>
                <hr>
            </div>
        @endif
    </div>
    <button type="button" onclick="addParagraph()">Añadir párrafo</button><br><br>

    <button type="submit">{{ $buttonText }}</button>
</form>

<script>
    let paragraphCount = document.querySelectorAll('.paragraph-block').length;

    function addParagraph() {
        const container = document.getElementById('paragraphs');
        const index = paragraphCount++;

        const div = document.createElement('div');
        div.classList.add('paragraph-block');
        div.dataset.index = index;
        div.innerHTML = `
            <textarea name="content[${index}][text]" placeholder="Texto del párrafo" required></textarea><br>
            <label>Foto Izquierda (opcional)</label>
            <input type="file" name="content[${index}][image_left]"><br>
            <label>Foto Derecha (opcional)</label>
            <input type="file" name="content[${index}][image_right]"><br>
            <button type="button" onclick="removeParagraph(${index})">Eliminar párrafo</button>
            <hr>
        `;
        container.appendChild(div);
    }

    function removeParagraph(index) {
        const div = document.querySelector(`.paragraph-block[data-index='${index}']`);
        if(div) div.remove();
    }
</script>

