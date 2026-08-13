<?php
$users  = $users  ?? [];
$errors = $errors ?? [];
?>
<div class="dash-layout">

    <?php $active = 'users'; include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="dash-content">
        <div class="dash-header">
            <h1 class="dash-header__title">Users</h1>
            <a href="index.php?page=register" class="btn btn--primary">+ Add user</a>
            <p class="dash-header__sub">Manage registered admin accounts</p>
        </div>

        <?php if (!empty($errors['general'])): ?>
            <div class="form-error-banner"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <div class="upload-widget">
            <table class="data-table">
                <thead>
                <tr>
                    <th></th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>
                            <?php if (!empty($u['avatar'])): ?>
                                <img class="avatar-badge" src="<?= htmlspecialchars($u['avatar']) ?>" alt="">
                            <?php else: ?>
                                <span class="avatar-badge"><?= htmlspecialchars(strtoupper(substr($u['username'], 0, 1))) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['department']) ?></td>

                        <td>
                            <form method="POST" action="index.php?page=users" style="display:inline">
                                <input type="hidden" name="csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                <input type="hidden" name="action" value="update_role">
                                <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                                <select name="role" class="form-input form-select" onchange="this.form.submit()">
                                    <?php
                                    $roles = [
                                        'super_admin'  => 'Super Admin',
                                        'admin'        => 'Admin',
                                        'data_manager' => 'Data Manager',
                                        'read_only'    => 'Read Only',
                                    ];
                                    foreach ($roles as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $u['role'] === $value ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <noscript><button type="submit">Save</button></noscript>
                            </form>
                        </td>

                        <td>
                            <?php if ((int) $u['id'] !== (int) ($_SESSION['userid'] ?? 0)): ?>
                                <form method="POST" action="index.php?page=users"
                                      onsubmit="return confirm('Delete this user?')" style="display:inline">
                                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                                    <button type="submit" class="btn btn--danger">Delete</button>
                                </form>
                            <?php else: ?>
                                <span class="form-hint">You</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>