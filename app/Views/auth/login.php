<div class="row justify-content-center mt-5">
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4 text-center">Вход</h3>
                <form id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                    <div class="mt-3 text-center">
                        <a href="/register">Регистрация</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', async function(e){
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        const response = await fetch('/api/auth/login', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (response.ok) {
            window.location.href = '/';
        } else {
            if (data.errors) {
                for (const field in data.errors) {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        input.nextElementSibling.textContent = data.errors[field].join(', ');
                    }
                }
            } else {
                alert(data.message || 'Ошибка');
            }
        }
    });
</script>