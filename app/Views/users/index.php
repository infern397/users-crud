<?php
/**
 * @var Controller $this
 * @var array<User> $users
 */

use App\Core\Controller;
use App\Core\UserContext;
use App\Models\User;

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
        <th class="text-center">ID</th>
        <th>ФИО</th>
        <th>Год рождения</th>
        <th>Пол</th>
        <th>Админ?</th>
        <th>Фото</th>
        <?php if (UserContext::user()->is_admin): ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td class="text-center"><?= htmlspecialchars($u->id) ?></td>
            <td><?= htmlspecialchars($u->full_name) ?></td>
            <td><?= htmlspecialchars($u->birth_year) ?></td>
            <td><?= $u->gender === 'male' ? 'М' : 'Ж' ?></td>
            <td><?= $u->is_admin ? 'Да' : 'Нет' ?></td>
            <td class="text-center">
                <?php if ($u->photo): ?>
                    <img src="/uploads/<?= htmlspecialchars($u->photo) ?>" alt="Фото" width="50">
                <?php endif; ?>
            </td>
            <?php if (UserContext::user()->is_admin): ?>
                <td class="text-end">
                    <button
                            class="btn btn-sm btn-warning editUserBtn"
                            data-user='<?= json_encode($u->getAttributes(), JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                        Редактировать
                    </button>
                    <button
                            class="btn btn-sm btn-danger deleteUserBtn"
                            data-user-id="<?= htmlspecialchars($u->id) ?>">
                        Удалить
                    </button>
                </td>
            <?php endif ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
$this->renderPartial('users/create');
$this->renderPartial('users/edit');
?>

<script>
    document.querySelector('table').addEventListener('click', async function (event) {
        const button = event.target.closest('.deleteUserBtn');
        if (!button) return;

        const userId = button.getAttribute('data-user-id');
        const response = await fetch(`/api/users/${userId}/delete`, {
            method: 'POST',
        });

        const data = response.json();

        if (response.ok) {
            location.reload();
        } else {
            alert(data.message || 'Ошибка');
        }
    });
</script>