<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký tài khoản</title>
</head>

<body>
    <h2>Form Đăng Ký (SignIn)</h2>
    <form action="{{ route('auth.check') }}" method="POST">
        @csrf
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Re-Password:</label>
            <input type="password" name="repass" required>
        </div>
        <div>
            <label>MSSV:</label>
            <input type="text" name="mssv" required>
        </div>
        <div>
            <label>Lớp môn học:</label>
            <input type="text" name="lop" required>
        </div>
        <div>
            <label>Giới tính:</label>
            <select name="gioitinh">
                <option value="Nam">Nam</option>
                <option value="Nu">Nữ</option>
            </select>
        </div>
        <br>
        <button type="submit">Sign In</button>
    </form>
</body>

</html>