<div class="row justify-content-center mt-5">
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4 text-center">Регистрация</h3>

                <form id="registerForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">ФИО</label>
                        <input type="text" name="full_name" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Год рождения</label>
                        <input type="number" name="birth_year" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Пол</label>
                        <select name="gender" class="form-select">
                            <option value="">Выберите...</option>
                            <option value="male">Мужской</option>
                            <option value="female">Женский</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Фото</label>
                        <input type="file" name="photo" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">
                        <label class="form-check-label" for="is_admin">Администратор</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                    <div class="mt-3 text-center">
                        <a href="/login">Уже есть аккаунт?</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function clearErrors(formId) {
        const form = document.getElementById(formId);
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    }

    function showErrors(formId, errors) {
        const form = document.getElementById(formId);

        for (const field in errors) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.parentElement.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = errors[field].join(', ');
                }
            }
        }
    }

    document.getElementById('registerForm').addEventListener('submit', async function(e){
        e.preventDefault();
        clearErrors('registerForm');

        const formData = new FormData(e.target);
        formData.set('is_admin', e.target.is_admin.checked ? '1' : '0');

        const response = await fetch('/api/auth/register', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (response.ok) {
            window.location.href = '/';
        } else {
            if (data.errors) {
                showErrors('registerForm', data.errors);
            } else {
                alert(data.message || 'Ошибка');
            }
        }
    });
</script>