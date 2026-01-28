<form action="/luu-tuoi" method="POST">
    @csrf
    Nhập tuổi của bạn: <input type="number" name="tuoi">
    <button type="submit">Lưu Session</button>
</form>