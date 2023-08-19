<footer>
    <div class="text-center p-3">
        <strong>© 2023 {{ config('app.name', 'Laravel') }} | BY: Footer
        </strong>
    </div>

</footer>
@vite(['resources/js/app.js'])
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
{{ $js ?? '' }}
</body>

</html>
