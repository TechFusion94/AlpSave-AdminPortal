<?php
$username = $_SESSION['username'] ?? 'Admin';
$initial  = strtoupper(substr($username, 0, 1));
?>

<div class="dash-layout">

    <?php $active = 'dashboard'; include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="dash-content">
        <div class="dash-header">
            <div>
                <h1 class="dash-header__title">Dashboard</h1>
                <p class="dash-header__sub">Welcome back, <?= htmlspecialchars($username) ?>.</p>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <p class="stat-card__label">Total users</p>
                <p class="stat-card__value"><?= (int) $totalUsers ?></p>
            </div>
            <div class="stat-card">
                <p class="stat-card__label">Data uploads</p>
                <p class="stat-card__value"><?= (int) $totalUploads ?></p>
            </div>
            <div class="stat-card">
                <p class="stat-card__label">Pricing plans</p>
                <p class="stat-card__value"><?= (int) $totalPlans ?></p>
            </div>
        </div>

        <div class="panel">
            <h2 class="panel__title">Recent registrations</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($recentUsers as $u): ?>
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
                        <td><?= htmlspecialchars($u['role']) ?></td>
                        <td><?= htmlspecialchars(date('d M Y', strtotime($u['created_at']))) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>

</div>