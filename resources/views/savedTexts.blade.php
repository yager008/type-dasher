<x-app-layout>
    @include('type_components.saved_texts')
</x-app-layout>

<script>
    const savedTextName = document.getElementById('savedTextName')
    const textNameDiv = document.getElementById('textNameDiv')

    savedTextName.addEventListener('input', function() {
        if (savedTextName.value.length > 15) {
            savedTextName.value = savedTextName.value.slice(0, 15);
        }
    });
</script>
