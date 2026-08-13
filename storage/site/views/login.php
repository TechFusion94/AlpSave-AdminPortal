<?php
$errors = $errors ?? [];
?>

<div class="login-layout">

    <aside class="login-sidebar">
        <div class="login-sidebar__brand">
            <h3 class="login-sidebar__logo">AlpSave</h3>
            <p class="login-sidebar__label">Admin Portal</p>
        </div>
        <div class="login-sidebar__copy">
            <h2 class="login-sidebar__headline">Manage your platform with confidence</h2>
            <p class="login-sidebar__sub">Secure access for authorised administrators.</p>
            <p class="login-sidebar__sub">All sessions are logged and audited.</p>
        </div>
        <p class="login-sidebar__copyright">© 2026 AlpSave · Zurich, Switzerland</p>
    </aside>

    <main class="login-content">

        <div class="login-content__form">
            <h2 class="reg-content__heading">Welcome back</h2>
            <p class="reg-content__sub">Sign in to the AlpSave admin area</p>

            <?php if (isset($errors['login'])): ?>
                <div class="form-error-banner">⚠ <?= htmlspecialchars($errors['login']) ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login" novalidate>
                <input type="hidden" name="csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-input" type="text" id="username" name="username"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                           placeholder="alpsave">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-input" type="password" id="password" name="password"
                           placeholder="password">
                </div>

                <div class="form-nav form-nav--single">
                    <button type="submit" class="btn btn--primary">Sign in</button>
                </div>

            </form>

        </div>
    </main>

</div>
