@foreach ($imageFiles as $imageFile)
    <img src="{{ asset('assets/equipments_folderimages/' . basename($imageFile)) }}" alt="Image">
    <button onclick="selectImage('{{ basename($imageFile) }}')">Select</button>
@endforeach

<script>
    function selectImage(imageName) {
        // Redirect back to the editfolder route with the selected image filename as a query parameter
        window.location.href = "{{ route('equipments.editfolder', ['id' => $folder->id]) }}?selected_image=" + imageName;
    }
</script>
