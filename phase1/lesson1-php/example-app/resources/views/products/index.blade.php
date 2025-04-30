<html>

<body>
    <h1>المنتجات</h1>
    <form id="profileForm" onsubmit="redirectToProfile(event)">
        <div class="mb-3">
            <label for="id" class="form-label">رقم المستخدم</label>
            <input id="profile_id" type="number" name="id" id="id" class="form-control" min="1" value="1">
        </div>

        <button type="submit" class="btn btn-primary">عرض الملف الشخصي</button>
    </form>

    <ul>
        @foreach ($products as $product)
            <li>{{ $product->name }} - {{ $product->price }} $</li>
        @endforeach
    </ul>
</body>

</html>

<script>
    function redirectToProfile(event) {
        event.preventDefault();
        var userId = document.getElementById('profile_id').value;
        var profileUrl = "{{ url('user') }}/" + userId + "/profile";
        window.location.href = profileUrl;
    }
</script>
