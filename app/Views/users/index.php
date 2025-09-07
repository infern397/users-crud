<?php
/**
 * @var array $users
 */
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Пользователи</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
        Создать пользователя
    </button>
</div>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Год рождения</th>
        <th>Пол</th>
        <th>Админ?</th>
        <th>Фото</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['full_name']) ?></td>
            <td><?= htmlspecialchars($u['birth_year']) ?></td>
            <td><?= $u['gender'] === 'male' ? 'Мужчина' : 'Женщина' ?></td>
            <td><?= $u['is_admin'] ? 'Да' : 'Нет' ?></td>
            <td>
                <?php if ($u['photo']): ?>
                    <img src="/uploads/<?= htmlspecialchars($u['photo']) ?>" alt="Фото" width="50">
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createUserForm" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Создать пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
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
                    <label class="form-label">Пароль</label>
                    <input type="text" name="password" class="form-control">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('createUserForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        formData.set('is_admin', form.is_admin.checked ? '1' : '0');

        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        try {
            const response = await fetch('/api/users', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
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
                return;
            }

            const modal = bootstrap.Modal.getInstance(document.getElementById('createUserModal'));
            modal.hide();
        } catch (err) {
            console.error(err);
            alert('Ошибка при запросе');
        }
    });
</script>
