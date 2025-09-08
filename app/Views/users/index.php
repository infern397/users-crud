<?php
/**
 * @var Controller $this
 * @var array $users
 */

use App\Core\Controller;
use App\Core\UserContext;
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
        <?php if (UserContext::user()['is_admin']): ?>
            <th></th>
        <?php endif; ?>
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
            <?php if (UserContext::user()['is_admin']): ?>
            <td>
                <button
                        class="btn btn-sm btn-warning editUserBtn"
                        data-user='<?= json_encode($u, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                    Редактировать
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
