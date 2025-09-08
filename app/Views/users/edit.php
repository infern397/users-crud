<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editUserForm" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id">
                <div class="mb-3">
                    <label class="form-label">ФИО</label>
                    <input type="text" name="full_name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Почта</label>
                    <input type="text" name="email" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Год рождения</label>
                    <input type="number" name="birth_year" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Пол</label>
                    <select name="gender" class="form-select">
                        <option value="male">Мужской</option>
                        <option value="female">Женский</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Фото</label>
                    <input type="file" name="photo" class="form-control">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_admin" id="edit_is_admin">
                    <label class="form-check-label" for="edit_is_admin">Администратор</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.editUserBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            const user = JSON.parse(this.dataset.user);
            const form = document.getElementById('editUserForm');

            form.id.value = user.id;
            form.full_name.value = user.full_name;
            form.email.value = user.email;
            form.birth_year.value = user.birth_year;
            form.gender.value = user.gender;
            form.is_admin.checked = user.is_admin == 1;

            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        });
    });

    document.getElementById('editUserForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const id = form.id.value;
        const formData = new FormData(form);
        formData.set('is_admin', form.is_admin.checked ? '1' : '0');

        try {
            const response = await fetch(`/api/users/${id}`, {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
                if (data.errors) {
                    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
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
                return;
            }

            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
            location.reload();
        } catch (err) {
            console.error(err);
            alert('Ошибка при запросе');
        }
    });

</script>