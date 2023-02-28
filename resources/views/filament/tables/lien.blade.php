<div>
    <button class="bg-primary-500 hover:bg-primary-500 text-white font-bold py-2 px-4 rounded" onclick="myFunction()">
        Visitez l'offre
    </button>
    <script>
        function myFunction() {
            window.open('{{ $getState() }}');
        }
    </script>
</div>