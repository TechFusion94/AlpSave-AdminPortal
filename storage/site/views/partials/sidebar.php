<?php
$active   = $active ?? '';
$username = $_SESSION['username'] ?? 'Admin';
$initial  = strtoupper(substr($username, 0, 1));
?>
<aside class="dash-sidebar">
    <div class="dash-sidebar__brand">
        <h3 class="login-sidebar__logo">AlpSave</h3>
        <p class="login-sidebar__label">Admin Portal</p>
    </div>

    <nav class="dash-nav">
        <a href="index.php?page=dashboard" class="dash-nav__item <?= $active === 'dashboard' ? 'dash-nav__item--active' : '' ?>">Dashboard</a>

        <?php if (Role::can('manage_users')): ?>
            <a href="index.php?page=users"     class="dash-nav__item <?= $active === 'users' ? 'dash-nav__item--active' : '' ?>">Users</a>
        <?php endif; ?>

        <?php if (Role::can('manage_content')): ?>
            <a href="index.php?page=dataupload" class="dash-nav__item <?= $active === 'dataupload' ? 'dash-nav__item--active' : '' ?>">Data Upload</a>
        <?php endif; ?>

        <a href="index.php?page=pricing"   class="dash-nav__item <?= $active === 'pricing' ? 'dash-nav__item--active' : '' ?>">Update Pricing</a>

    </nav>

    <div class="dash-sidebar__user">
        <div class="dash-sidebar__avatar">
            <?php if (!empty($_SESSION['avatar'])): ?>
                <img src="<?= htmlspecialchars($_SESSION['avatar']) ?>" alt="<?= htmlspecialchars($username) ?>">
            <?php else: ?>
                <?= htmlspecialchars($initial) ?>
            <?php endif; ?>
        </div>
        <div>
            <p class="dash-sidebar__name"><?= htmlspecialchars($username) ?></p>
            <form method="POST" action="index.php?page=dashboard">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="dash-sidebar__logout">Sign out</button>
            </form>
        </div>
    </div>
</aside>