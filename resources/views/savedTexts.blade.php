<x-app-layout>
    @include('type_components.saved_texts')




</x-app-layout>

<script>

    const savedTextName = document.getElementById('savedTextName')
    const textNameDiv = document.getElementById('textNameDiv')

    const alertDiv = document.getElementById('alert');


    savedTextName.addEventListener('input', function() {
        if (savedTextName.value.length > 15) {
            savedTextName.value = savedTextName.value.slice(0, 15);
            alertDiv.style = 'visibility: ';
        } else {
            alertDiv.style = 'visibility: hidden ';
        }
    });

    function closeAlert() {
        alertDiv.style = 'visibility: hidden ';
    }
</script>
